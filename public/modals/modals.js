

class Modal {
    constructor(data) {
        this.data = data;

        this._template();
        this._setup();

        setTimeout(() => {
            this._onload();
            this._listeners();
        }, 250);
        this._show();
    }

    _template() {
        const template = `
        <div class="modal">
            <div class="modal_header">
                <h4>${this.data.title}</h4>
                <nav class="buttons"></nav>
            </div>
            <div class="modal_body"></div>
        </div>
        `;
        const temp = document.createElement('div');
        temp.innerHTML = template;
        this.element = temp.firstElementChild;
    }
    _setup(){
        this.element.querySelector('.buttons').innerHTML += this._buttons();
        this.element.querySelector('.buttons').innerHTML += `<button class="modal_closer button red"><i class="fa-solid fa-xmark"></i></button>`;
        this.element.querySelector('.modal_body').innerHTML += this._body();
    }
    _buttons(){ throw new Error('Implement this method in child classes.'); }
    _body(){ throw new Error('Implement this method in child classes.'); }
    _onload(){
        if(this.data['on_load']){ this.data['on_load'](this)}
    }
    _listeners(){
        this.element.querySelector('.modal_closer').addEventListener('click', () => {
            this._close();
        });
    }
    _close(){
        this.element.style.scale = 0.3;
        this.element.style.opacity = 0;

        setTimeout(() => {
            this.element.parentElement.removeChild(this.element);
            if(document.querySelector('#modal_container').firstElementChild == null){
                document.querySelector('#modal_container').style.visibility = 'hidden';
            }
        }, 250);
    }
    _show(){
        const container = document.querySelector('#modal_container');
        container.style.visibility = 'visible';
        container.appendChild(this.element);

        setTimeout(() => {
            this.element.style.scale = 1;
            this.element.style.opacity = 1;
        }, 100);
    }
    query(selector){
        return this.element.querySelector(selector);
    }

}
class Confirm_Modal extends Modal {
    constructor(data) {
        super(data);
    }
    _buttons(){
        return ``;
    }
    _body(){
        return `
            <div class="flex_center mb-4 icon_container">
                <i class="modal_icon fa-solid fa-triangle-exclamation"></i>
            </div>

            <p class="text-center mb-2">${this.data.body}</p>
            <div class="w-100 modal_input_box flex-column gap-2 align-items-center">
                <label></label>
                <input class="w-100" type="text">
            </div>
            <div class="modal_options justify-content-around d-flex flex-row mt-4">
                <button class="modal_cancel">${this.data.cancel}</button>
                <button class="modal_confirm">${this.data.confirm}</button>
            </div>
        `;
    }
    _onload(){
        super._onload();
        this.element.className += " small_modal";

        const input_box = this.element.querySelector('.modal_input_box')
        const input = this.element.querySelector('input')

        if(this.data['input_config']){
            input_box.style.display = 'flex';

            input.setAttribute('type', this.data['input_config']['type'])
            input.setAttribute('placeholder', this.data['input_config']['placeholder'])
            this.element.querySelector('label').textContent = this.data['input_config']['label'];
        } else {
            input_box.style.display = 'none';
        }
    }
    _listeners(){
        super._listeners();

        const input = this.element.querySelector('input')
        this.element.querySelector('.modal_confirm').addEventListener('click', (event) => {
            super._close();
            if (this.data['on_confirm']) {
                this.data['on_confirm'](input.value);
            }
        });

        this.element.querySelector('.modal_cancel').addEventListener('click', (event) => {
            super._close();
            if(this.data['on_cancel']){
                this.data['on_cancel'](input.value);
            }
        });
    }
}
class Choice_Modal extends Modal {
    constructor(data) {
        super(data);
    }
    _buttons(){
        return ``;
    }
    _body(){
        return `
            <div class="flex_center mb-4 icon_container">
                <i class="modal_icon fa-solid fa-circle-info"></i>
            </div>

            <p class="text-center mb-2">${this.data.body}</p>
            <div class="w-100 modal_input_box flex-column gap-2 align-items-center">
                <label></label>
                <input class="w-100" type="text">
            </div>
            <div class="modal_options">
                <button class="modal_cancel modal_choice_2">${this.data.cancel}</button>
                <button class="modal_confirm modal_choice_1">${this.data.confirm}</button>
            </div>
        `;
    }
    _onload(){
        super._onload();
        this.element.className += " small_modal";
        const input_box = this.element.querySelector('.modal_input_box')
        const input = this.element.querySelector('input')

        if(this.data['input_config']){
            input_box.style.display = 'flex';

            input.setAttribute('type', this.data['input_config']['type'])
            input.setAttribute('placeholder', this.data['input_config']['placeholder'])
            this.element.querySelector('label').textContent = this.data['input_config']['label'];
        } else {
            input_box.style.display = 'none';
        }
    }
    _listeners(){
        super._listeners();

        const input = this.element.querySelector('input')
        this.element.querySelector('.modal_confirm').addEventListener('click', (event) => {
            super._close();
            if (this.data['on_confirm']) {
                this.data['on_confirm'](input.value);
            }
        });

        this.element.querySelector('.modal_cancel').addEventListener('click', (event) => {
            super._close();
            if(this.data['on_cancel']){
                this.data['on_cancel'](input.value);
            }
        });
    }
}

class Place_Create_Modal extends Modal {
    constructor(data) {
        super(data);
    }
    _buttons(){
        return `
        <div class="working d-inline-flex align-items-center gap-2" style="display: none; visibility: hidden">
            <i class="fa-solid fa-spinner"></i>Please wait
        </div>
        <button class="modal_save button info"><i class="fa-solid fa-floppy-disk"></i></button>
        `;
    }
    _body(){
        return `
        <div class="d-inline-flex gap-3 w-100">
            <div class="thumbnail_preview" style="background-image: url('${this.data.thumbnail}');">
                <input type="file" class="d-none custom-file-input" id="thumbnail" name="thumbnail">
                <label class="button border" for="thumbnail">
                    <i class="fa-solid fa-file-arrow-up"></i>
                </label>
            </div>
            <div class="flex-grow-1">
                <div class="form_row">
                    <div class="form_line">
                        <label>Country</label>
                        <select id="create_select_country" name="create_select_country"></select>
                    </div>
                    <div class="form_line">
                        <label>Category</label>
                        <select id="create_select_category" name="create_select_category"></select>
                    </div>
                </div>

                <div class="form_line">
                    <label for="name">Thumbnail URL</label>
                    <input type="text" name="thumbnail_url"
                    value="https://commons.wikimedia.org/wiki/File:Capilla_de_Marmol_2017.jpg">
                </div>

                <div class="form_line">
                    <label for="name">Name</label>
                    <input type="text" name="name"
                    value="Marble Cathedral">
                </div>

                <div class="form_line">
                    <label for="synopsis">Synopsis</label>
                    <textarea name="synopsis">Caves of carbonate mineral formations, carved in the middle of Lake General Carrera</textarea>
                </div>

                <div class="form_line">
                    <label for="name">Gallery URL</label>
                    <input type="text" name="gallery_url" placeholder="Wikimedia URL"
                    value="https://commons.wikimedia.org/wiki/Category:Catedral_de_M%C3%A1rmol">
                </div>

                <div class="aligner modal_options">
                    <button type="submit" class="modal_choice_1">Submit</button>
                </div>
            </div>
        </div>
        `;
    }
    _onload(){
        super._onload();
        this.element.className += ' scroll_modal';
        auto_resize(this.element.querySelector('textarea'));
    }
    _listeners(){
        super._listeners();
        this.element.querySelector('button[type="submit"]').addEventListener('click', (event) => {
            this.data['on_submit'](this);
        });
        this.element.querySelector('#thumbnail').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.thumbnail_preview').style.backgroundImage = `url(${e.target.result})`;
                }
                reader.readAsDataURL(file);
            }
        });
    }
    _disable(){
        this.element.querySelector('button[type="submit"]').disabled = true;
    }
    _enable(){
        this.element.querySelector('button[type="submit"]').disabled = false;
    }
}
class Place_Edit_Modal extends Modal {
    constructor(data) {
        super(data);
    }
    _template() {
        const template = `
        <div class="modal">
            <ul class="modal_tabs">
                <li for="edit_place">Edit Place</li>
                <li for="medias">Medias</li>
                <li for="sources">Sources</li>
                <li fill class="flex-grow-1"></li>
            </ul>
            <div class="modal_content">
                <div class="modal_header">
                    <h4>${this.data.title}</h4>
                    <nav class="buttons"></nav>
                </div>
                <div class="modal_body"></div>
            </div>
        </div>
        `;
        const temp = document.createElement('div');
        temp.innerHTML = template;
        this.element = temp.firstElementChild;
    }
    _buttons() {
        return `
        <div class="working d-inline-flex align-items-center gap-2" style="display: none; visibility: hidden">
            <i class="fa-solid fa-spinner"></i>Please wait
        </div>
        <button class="modal_save button info"><i class="fa-solid fa-floppy-disk"></i></button>
        `;
    }

    _body(){
        return `
        <div class="modal_tab_content" id="content_medias">
            medias
        </div>
        <div class="modal_tab_content" id="content_sources">
            Sources
        </div>
        <div class="modal_tab_content" id="content_edit_place">
            <div class="d-inline-flex gap-3 w-100">
                <div class="thumbnail_preview">
                    <input type="file" class="d-none custom-file-input" id="thumbnail" name="thumbnail">
                    <label class="button border" for="thumbnail">
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </label>
                </div>
                <div class="flex-grow-1">
                    <div class="form_row">
                        <div class="form_line">
                            <label>Locale</label>
                            <select id="edit_select_locale" name="edit_select_locale"></select>
                        </div>
                        <div class="form_line">
                            <label>Country</label>
                            <select id="edit_select_country" name="edit_select_country"></select>
                        </div>
                        <div class="form_line">
                            <label>Category</label>
                            <select id="edit_select_category" name="edit_select_category"></select>
                        </div>
                    </div>
                    <div class="form_line">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" readonly>
                    </div>
                    <div class="form_line">
                        <label for="name">Name</label>
                        <input type="text" name="name">
                    </div>
                    <div class="form_line">
                        <label for="synopsis">Synopsis</label>
                        <textarea name="synopsis"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal_header mt-3">
                <div class="flex_center gap-2">
                    <h4>Medias</h4>
                    <a href='javascript:void(0)' class='gallery_link app_link'>View current gallery</a>
                </div>
                <nav class="buttons">
                    <button class="button" class="button">
                        <i class="small_i fa-solid fa-plus"></i><i class="fa-solid fa-image"></i>Add Media
                    </button>
                    <button class="button" class="button">
                        <i class="small_i fa-solid fa-plus"></i><i class="fa-solid fa-images"></i></i>Add medias from wikimedia [NYI]
                    </button>
                </nav>
            </div>
            <div class="form_line">
                <label for="name">Gallery URL</label>
                <input class="flex-grow-1" type="text" name="gallery_url" placeholder="Wikimedia URL">
            </div>
            <div class="medias"></div>
        </div>
        `;
    }
    _setplace(place){
        this.query('.thumbnail_preview').style.backgroundImage = `url('${this.data.thumbnail_prefix}/${place.public_slug}/${place.thumbnail}?_=${new Date().getTime()}')`;
        this.query('[name="slug"]').value = place.slug;
        this.query('[name="name"]').value = place.name;
        this.query('[name="synopsis"]').value = place.synopsis;
        this.query('[name="gallery_url"]').value = place.gallery_url;
    }
    _onload(){
        super._onload();
        // this.query('.modal').className += ' scroll_modal';
        this.element.className += ' scroll_modal';
        this._setplace(this.data.place);
        auto_resize(this.element.querySelector('textarea'));

        const select_locale = this.element.querySelector('#edit_select_locale');
        const current_locale = this.data.locale;
        this.data.locales.forEach(function(locale){
            if(locale == current_locale){
                select_locale.innerHTML += `<option selected value="${locale}">${locale.toUpperCase()}</option>`;
            } else {
                select_locale.innerHTML += `<option value="${locale}">${locale.toUpperCase()}</option>`;
            }
        });

        const medias_container = document.querySelector('.medias');
        this.data.place.medias.forEach(media => {
            medias_container.innerHTML += `
            <div class="media" style="background-image: url('${media.url}')">
            <button class="button delete_button red"><i class="small_i fa-solid fa-trash"></i></button>
            </div>
            `;
        });


        const tabs = this.element.querySelectorAll('.modal_tabs li');
        this._tab(tabs[0].getAttribute('for'))
        tabs.forEach(element=>{
            element.addEventListener('click', () => {
                console.log('click');
                this._tab(element.getAttribute('for'))

            });
        });

    }
    _tab(tab_name){
        console.log('activating '+tab_name);
        //hide current tab
        const active_tab = this.query('.modal_tabs li[active="true"]')
        if(active_tab){
            active_tab.setAttribute('active', false)
            this.query('#content_'+active_tab.getAttribute('for')).style.display = 'none'
        }

        //show new tab
        const new_tab = this.query(`.modal_tabs li[for='${tab_name}']`);
        new_tab.setAttribute('active', true);
        const content = this.query('#content_'+new_tab.getAttribute('for'))
        console.log(content);
        content.style.display = 'block';
        this.query('h4').textContent = new_tab.textContent;
    }
    _listeners(){
        super._listeners();
        this.query('.modal_save').addEventListener('click', (event) => {
            console.log('on submit');
            this.data['on_submit'](this);
        });
        this.query('#thumbnail').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.thumbnail_preview').style.backgroundImage = `url(${e.target.result})`;
                }
                reader.readAsDataURL(file);
            }
        });
        this.query('#edit_select_locale').addEventListener('change', (event) =>{
            this.data['on_locale_change'](this, event.target.value);
        });
        this.query('.gallery_link').addEventListener('click', (event) =>{
            window.open(this.query('[name="gallery_url"]').value, '_blank');
        });
    }
    _disable(){
        this.query('.modal_save').disabled = true;
    }
    _enable(){
        this.query('.modal_save').disabled = false;
    }
}
