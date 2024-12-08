@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.places') | Admin {{config('app.name')}}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}"/>
    <link rel="stylesheet" href="{{asset('modals/modals.css?v=1')}}">
    <script src="{{asset('modals/modals.js')}}"></script>

    <section class="wrapper col-12 col-lg-10">
        <div class="title">
            <div class="text">
                <i class="fa-solid fa-panorama"></i>
                <h3>@lang('otherworlds.places')</h3>
                <small>@lang('otherworlds.total'): {{ $total }}</small>
            </div>
            <nav class="buttons">
                <i class="fa-solid fa-spinner"></i>
                <div>
                    <select id="select_category" name="category" required></select>
                </div>
                <div>
                    <select id="select_country" name="country" required></select>
                </div>
                <div class="search_bar">
                    <button class="search_button button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="text" placeholder="@lang('otherworlds.search_place')" name="search">
                    <button class="clear_button button"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="div_v div_gray m-2"></div>
                <button id="create_place" class="button info">
                    <i class="fa-regular fa-add"></i>@lang('otherworlds.create_place')
                </button>
            </nav>
        </div>

        <div class="table_container">
            <table class="results_table">
                <thead>
                    <tr>
                        <th class="small"></th>
                        <th class="small" title="@lang('otherworlds.category')">
                            <div class="aligner">
                                <i class="fa-regular fa-circle"></i>
                            </div>
                        </th>
                        <th class="small" title="@lang('otherworlds.country')">
                            <div class="aligner">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                        </th>
                        <th>@lang('otherworlds.name')</th>
                        <th class="medium" title="@lang('otherworlds.views')">
                            <div class="aligner">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                        </th>
                        <th class="medium" title="@lang('otherworlds.favorites')">
                            <div class="aligner gap">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </th>
                        <th class="medium" title="@lang('otherworlds.medias')">
                            <div class="aligner">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        </th>
                        <th class="medium" title="Checked">
                            <div class="aligner">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('script')
<script src="{{ asset('js/ajax.js') }}"></script>

<script>
    const logged = {!! json_encode($logged) !!};
    const locales = {!! json_encode(config('translatable.locales')) !!};
    const countries = organize_dic({!! json_encode($countries) !!});
    const categories = organize_dic({!! json_encode($categories) !!});

    /* EVENTS */
    document.addEventListener('DOMContentLoaded', function() {
        create_rows({!! json_encode($places) !!})
    });

    window.addEventListener('scroll', function() {
        const container = document.querySelector('.table_container');
        if (container.getBoundingClientRect().bottom < window.innerHeight*1.5){
            attempt_request();
        }
    });

    /* AJAX & SEARCH */
    const results = document.querySelector('.results_table tbody');
    const search_button = document.querySelector('.search_button');
    const clear_button = document.querySelector('.clear_button');
    const search_input = document.querySelector('.search_bar input');
    let country_input = null;
    let category_input = null;

    document.addEventListener('DOMContentLoaded', function(){
        country_input = document.querySelector('input[name="country"]');
        category_input = document.querySelector('input[name="category"]');
        const hidden_inputs = [country_input,category_input];

        //custom getter-setter for input, same purpose as change event but for input hiddens
        hidden_inputs.forEach(function(input) {
            let value = 0;
            Object.defineProperty(input, "value", {
                set(new_value) {
                    //console.log(input.name+" Value changed to", new_value);
                    value = new_value;
                    send_search()
                },
                get(){
                    return value;
                }
            });
        });
    });

    let counter = 1;
    let page = 1;
    let search = '';
    let requesting = false;
    let querying = false;

    clear_button.addEventListener('click', function(){
        search = ''
    })
    search_input.addEventListener('input', function(){
        if(search_input.value != ''){
            clear_button.style.display = 'flex';
        } else {
            clear_button.style.display = 'none';
        }
    });
    search_input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') { search_button.click(); }
    });

    search_button.addEventListener('click', send_search);
    clear_button.addEventListener('click', function(){
        search_input.value = '';
        clear_button.style.display = 'none';
        send_search();
    });

    function send_search(){
        wipe_rows();
        //reset ajax variables
        search = search_input.value;
        page = 0;
        counter = 1;
        attempt_request();
    }

    function attempt_request(){
        if (requesting == false && querying == false) {
            request();
        } else if (requesting == true) {
            querying = true;
        }
    }

    function wipe_rows(){
        results.innerHTML = '';
        counter = 1;
    }
    function create_rows(places) {
        places.forEach(place => {
            create_row(place);
        });
    }
    function create_row(place) {
        const country = countries[place.country_id];
        const cat = categories[place.category_id];
        const row = document.createElement('tr');
        row.setAttribute('place_id', place.id);
        row.innerHTML += `
            <td class="number text-end">${counter}</td>
            <td title="${cat.keyword} (${cat.name})">
                <div class="aligner"><i class="small_i fa-solid fa-${cat.img_name}"></i></div>
            </td>
            <td>
                <span class="flag-icon flag-icon-${country.code}" title="${country.name}"></span>
            </td>
            <td>${place.name}</td>
            <td class="number text-end">${format_number(place.views_count)}</td>
            <td class="number text-end">${format_number(place.favorites_count)}</td>
            <td class="number text-end">${place.medias.length}</td>
        `;
        if(place.checked){
            row.innerHTML += `
            <td>
                <div class="aligner"><i class="fa-solid fa-check" style="color:var(--green_light)"></i></div>
            </td>
            `;
        } else{
            row.innerHTML += `
            <td>
                <div class="aligner"><i class="fa-solid fa-xmark" style="color:red"></i></div>
            </td>
            `;
        }
        results.appendChild(row);
        row.addEventListener('click',function(){
            // show_edit_place_modal(place);
            const editor = show_place_editor(place);
        });
        counter++;
    }

    function request() {
        const country_id = country_input.value;
        const category_id = category_input.value;

        //means there are no more objects left for this query
        if (page == -1) { return; }

        const ajax_data = {
            method: 'POST',
            url: '{{ URL('/ajax/admin/places/request') }}',
            request_data: {
                _token: '{{ csrf_token() }}',
                locale: '{{ $locale }}',
                page: page,
                search: search,
                country_id: country_id,
                category_id: category_id
            },

            before_func: function() {
                requesting = true;
            },
            success_func: function(response_data) {
                console.log(response_data);
                page = response_data['next_page'];
                const places = response_data['places'];
                if(places.length == 0 && counter == 1){
                    //no results for query
                } else {
                    create_rows(response_data['places']);
                }

            },
            after_func: request_cooldown
        }

        ajax(ajax_data);
    }

    async function request_cooldown() {
        await sleep(1000);
        requesting = false;
        if (querying == true) {
            querying = false;
            request();
        }
    }
</script>

{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}?v=3"></script>
<script>
    const csrf_token = '{{ csrf_token() }}';
    const countries_select_data = create_country_select_data(Object.values(countries));

    countries_select_data.unshift({
        value: 0,
        keyword: '@lang('otherworlds.all')',
        html: `
            <div class="aligner gap-2">
                <i class="fa-solid fa-location-dot"></i>
                @lang('otherworlds.all')
            </div>
        `
    });

    const select = new DynamicSelect('#select_country', {
        placeholder: "@lang('otherworlds.select_country')",
        data: countries_select_data
    });
    select.select_option('0')
</script>
<script>
    const categories_select_data = create_categories_select_data(Object.values(categories));

    categories_select_data.unshift({
        value: 0,
        keyword: '@lang("otherworlds.all")',
        html: `
            <div class="aligner gap-2">
                <i class="fa-regular fa-circle"></i>
                @lang('otherworlds.all')
            </div>
        `
    });
    const select2 = new DynamicSelect('#select_category', {
        placeholder: "@lang('otherworlds.select_category')",
        data: categories_select_data
    });
    select2.select_option('0')
</script>

<!-- Modal Listeners -->
<script>
    const category_data = create_categories_select_data(Object.values(categories));
    const country_data = create_country_select_data(Object.values(countries));
    document.querySelector("#create_place").addEventListener('click', function(){
        const modal_data = {
            title: '@lang('otherworlds.create_place_options')'+' [{{$locale}}]'.toUpperCase(),
            body: '@lang('otherworlds.choose_option')',
            cancel: '@lang('otherworlds.from_scratch')',
            confirm: '@lang('otherworlds.from_wikipedia')',
            input_config: {
                type: "text",
                placeholder: '@lang('otherworlds.wikipedia_link')',
                label: '@lang('otherworlds.wikipedia_link')'
            },
            on_confirm: function(modal_object, input_value){
                place_wiki_create(modal_object, input_value);
            },
            on_cancel: show_create_place_modal
        }
        const modal = new Choice_Modal(modal_data);
    })

    function show_create_place_modal(){
        const create_modal = new Place_Create_Modal({
            title: 'Create Place '+'[{{$locale}}]'.toUpperCase(),
            thumbnail: "{{asset('places/_placeholders/t.png')}}",
            on_load: function(){
                const cselect = new DynamicSelect('#create_select_country',{
                    placeholder: "@lang('otherworlds.select_country')",
                    data: country_data
                });
                cselect.select_option('1');
                const cselect2 = new DynamicSelect('#create_select_category', {
                    placeholder: "@lang('otherworlds.select_category')",
                    data: category_data
                });
                cselect2.select_option('1');
            },
            on_submit: function(modal_object){
                create_place(modal_object);
            }
            }
        )
    }
    function place_wiki_create(modal_object, wikipedia_url){
        const ajax_data = {
            url: '{{ URL('/ajax/admin/places/wiki_create') }}',
            request_data: {
                _token: csrf_token,
                locale: '{{$locale}}',
                wikipedia_url: wikipedia_url
            },
            before_func: function(){
                modal_object._disable();
            },
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    send_search();
                    show_place_editor(response_data['place']);
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }
        ajax(ajax_data,'Creating Source');
    }
    function create_place(modal_object){
        modal_object._disable();
        const modal = modal_object.element;
        const thumbnail = modal.querySelector('input[name="thumbnail"]')
        let can_create = true;
        if(thumbnail.files.length == 0){
            can_create = false
            show_message({type: 'danger', icon: 'fa-exclamation', text: '@lang("otherworlds.thumbnail_required")'});
        }
        if(can_create == false){
            modal_object._enable();
            return;
        }
        const form_data = new FormData();
        form_data.append('_token', '{{ csrf_token() }}');
        form_data.append('current_locale', '{{$locale}}');
        form_data.append('user_id', {{$logged->id}});
        form_data.append('country_id', modal.querySelector('input[name="create_select_country"]').value);
        form_data.append('category_id', modal.querySelector('input[name="create_select_category"]').value);
        form_data.append('name', modal.querySelector('input[name="name"]').value);
        form_data.append('gallery_url', modal.querySelector('input[name="gallery_url"]').value);
        form_data.append('thumbnail_url', modal.querySelector('input[name="thumbnail_url"]').value);
        form_data.append('synopsis', modal.querySelector('textarea[name="synopsis"]').value);
        form_data.append('thumbnail', thumbnail.files[0]);

        const ajax_data = {
            url: '{{ URL('/ajax/admin/places/create') }}',
            request_data: form_data,
            success_func: function(response_data) {
                console.log(response_data);
                if(response_data['success'] && response_data['success'] == true){
                    send_search();
                    modal_object._close();
                    show_place_editor(response_data['place']);
                }
            },
            after_func: function(){
                modal_object._enable();
            }
        }

        ajax(ajax_data,'Creating place');
    }
</script>
{{-- Place Editor --}}
@include('modules.place_editor')

@endsection
