<script src='{{ asset('modules/Place_Editor.js') }}?v=9'></script>
<script>
    function show_place_editor(place){
        const editor_data = {
            place: place,
            place_prefix: '{{places_url($locale)}}',
            locale: '{{$locale}}',
            locales: locales,
            thumbnail_prefix: "{{asset('places')}}"+'/',
            on_load: function(){
                const cselect = new DynamicSelect('#edit_select_country',{
                    placeholder: "@lang('otherworlds.select_country')",
                    data: country_data
                });

                const cselect2 = new DynamicSelect('#edit_select_category', {
                    placeholder: "@lang('otherworlds.select_category')",
                    data: category_data
                });

                cselect.select_option(place.country_id);
                cselect2.select_option(place.category_id);
            },
            on_locale_change: function(modal_object, new_locale){
                console.log('called on_locale_change');
                const ajax_data = {
                    url: '{{ URL('/ajax/admin/places/get') }}',
                    request_data:{
                        _token: csrf_token,
                        locale: new_locale,
                        place_id: place.id
                    },
                    success_func: function(response_data) {
                        console.log(response_data);
                        modal_object._setplace(response_data['place']);
                    }
                }
                ajax(ajax_data);
            },
            //place functions
            on_submit_edit_place: function(modal_object){
                console.log('called on_edit_place');
                place_update(modal_object, place);
            },
            on_delete_place: function(modal_object){
                console.log('called on_delete_place');
                place_delete(modal_object);
            },
            //source functions
            on_submit_sources: function(modal_object){
                console.log('called on_submit_sources');
                source_update(modal_object, place);
            },
            on_delete_source: function(modal_object, locale){
                console.log('called on_delete_source');
                source_delete(modal_object);
            },

            //media functions
            on_delete_media: function(modal_object, media_id){
                console.log('called on_delete_media');
                media_delete(modal_object, media_id);
            },
            on_media_add_one: function(modal_object){
                console.log('called on_media_add_one');
                media_add(modal_object, place);
            },
            on_media_add_page: function(modal_object){
                console.log('called on_media_add_page');
                media_add_page(modal_object, place);
            },
        };

        return new Place_Editor(editor_data);
    }

    function place_update(modal_object, place){
        modal_object._disable();
        const modal = modal_object.element;

        const form_data = new FormData();
        form_data.append('_token', csrf_token);
        form_data.append('locale', modal.querySelector('#select_locale').value);
        form_data.append('place_id', place.id);
        form_data.append('country_id', modal.querySelector('input[name="edit_select_country"]').value);
        form_data.append('category_id', modal.querySelector('input[name="edit_select_category"]').value);
        form_data.append('name', modal.querySelector('input[name="name"]').value);
        form_data.append('synopsis', modal.querySelector('textarea[name="synopsis"]').value);
        form_data.append('gallery_url', modal.querySelector('input[name="gallery_url"]').value);
        form_data.append('thumbnail', modal.querySelector('input[name="thumbnail"]').files[0]);
        form_data.append('checked', modal.querySelector('input[name="place_checked"]').checked);
        modal.querySelector('input[name="thumbnail"]').value= '';
        const ajax_data = {
            url: '{{ URL('/ajax/admin/places/update') }}',
            request_data: form_data,
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    modal_object._setplace(response_data['place']);
                    send_search();
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }
        console.log(modal.querySelector('input[name="place_checked"]').checked);
        
        ajax(ajax_data);
    }

    function place_delete(modal_object){
        const place_id = modal_object.data.place.id;
        const ajax_data = {
            url: '{{ URL("/ajax/admin/places/delete") }}',
            request_data: {
                _token: csrf_token,
                place_id: place_id,
            },
            success_func: function(response_data) {
                if(response_data['success'] && response_data['success'] == true){
                    const row = document.querySelector(`tr[place_id="${place_id}"]`)
                    row.parentElement.removeChild(row);
                    modal_object._close();
                }
            }
        }
        ajax(ajax_data, "Deleting place...");
    }

    function source_update(modal_object, place){
        modal_object._disable();
        const selected_locale = modal_object._selected_locale();
        const source = modal_object.data.place.sources.find(source => source.locale === selected_locale);
        if(!source){ return source_create(modal_object, place, selected_locale); }

        const ajax_data = {
            url: '{{ URL('/ajax/admin/sources/update') }}',
            request_data: {
                _token: csrf_token,
                source_id: source.id,
                source_title: modal_object.query('[name="source_title"]').value,
                source_url: modal_object.query('[name="source_url"]').value,
                source_content: unformat_html(modal_object.query('[name="source_content"]').value),
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    const index = modal_object.data.place.sources.findIndex(s => s.locale === selected_locale);
                    modal_object.data.place.sources[index] = response_data['source'];
                    modal_object._setplace(modal_object.data.place);
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }
        ajax(ajax_data);
    }

    function source_create(modal_object, place, selected_locale){
        modal_object._disable();
        const ajax_data = {
            url: '{{ URL('/ajax/admin/sources/create') }}',
            request_data: {
                _token: csrf_token,
                place_id: place.id,
                locale: selected_locale,
                source_title: modal_object.query('[name="source_title"]').value,
                source_url: modal_object.query('[name="source_url"]').value,
                source_content: unformat_html(modal_object.query('[name="source_content"]').value),
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    modal_object.data.place.sources.push(response_data['source']); //add the source
                    modal_object._setplace(modal_object.data.place);
                    send_search();
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }
        ajax(ajax_data,'Creating Source');
    }

    function source_delete(modal_object){
        const selected_locale = modal_object._selected_locale();
        const source = modal_object.data.place.sources.find(source => source.locale === selected_locale);
        if(!source){ return show_message({type: 'danger', icon: 'fa-exclamation', text: 'Source not found'}); }

        modal_object._disable();
        const ajax_data = {
            url: '{{ URL("/ajax/admin/sources/delete") }}',
            request_data: {
                _token: csrf_token,
                source_id: source.id,
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    const index = modal_object.data.place.sources.findIndex(s => s.locale === selected_locale);
                    modal_object.data.place.sources.splice(index, 1);
                    modal_object._setplace(modal_object.data.place);
                    send_search();
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }
        ajax(ajax_data);
    }

    function media_delete(modal_object, media_id){
        if(!media_id){ return show_message({type: 'danger', icon: 'fa-exclamation', text: 'Media not found'}); }

        const ajax_data = {
            url: '{{ URL("/ajax/admin/medias/delete") }}',
            request_data: {
                _token: csrf_token,
                media_id: media_id,
            },
            before_func: function(){
                modal_object._disable();
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    const index = modal_object.data.place.medias.findIndex(media => media.id === media_id);
                    modal_object.data.place.medias.splice(index, 1);
                    const mediabox = modal_object.query(`[media_id='${media_id}']`);
                    mediabox.parentElement.removeChild(mediabox);
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }
        ajax(ajax_data, "Deleting media...");
    }

    function media_add(modal_object, place){
        const input = modal_object.query('input[name="media_url"]');
        if(input.value == ''){ return; }
        const ajax_data = {
            url: '{{ URL("/ajax/admin/medias/create") }}',
            request_data: {
                _token: csrf_token,
                place_id: place.id,
                page_url: input.value,
            },
            before_func: function(){
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    modal_object._add_media(response_data['new_media']);
                    input.value = "";
                }
            },
            after_func: function(){
            }
        }
        console.log(ajax_data);
        ajax(ajax_data, "Adding media...");
    }

    function media_add_page(modal_object, place){
        const input_src = modal_object.query('input[name="media_url"]');
        const input_page = modal_object.query('input[name="page_url"]');
        if(input_src.value == '' || input_page.value == ""){ return; }
        const ajax_data = {
            url: '{{ URL("/ajax/admin/medias/create/page") }}',
            request_data: {
                _token: csrf_token,
                place_id: place.id,
                src_url: input_src.value,
                page_url: input_page.value,
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    modal_object._add_media(response_data['new_media']);
                    input_src.value = "";
                    input_page.value = "";
                }
            },
        }
        console.log(ajax_data);
        ajax(ajax_data, "Adding media with page URL...");
    }
    console.log('Place Editor Loaded.');
</script>
