

class Modal {
    constructor(data) {
        this.data = data;

        this._template();
        this._setup();
        this._listeners();
        this._show();
    }

    _template() {
        let template = `
        <div class="modal">
            <div class="modal_header">
                <h4>${this.data.title}</h4>
                <nav class="buttons">
                    <div class="working d-inline-flex d-none align-items-center gap-2" style="display: none; visibility: hidden">
                        <i class="fa-solid fa-spinner"></i>Please wait
                    </div>

                    <button class="modal_closer button red"><i class="fa-solid fa-xmark"></i></button>
                </nav>
            </div>
            <div class="modal_body"></div>
        </div>
        `;

        const temp = document.createElement('div');
        temp.innerHTML = template;
        this.element = temp.firstElementChild;
    }
    _setup(){
        throw new Error('Implement this method in child classes.');
    }
    _listeners(){
        this.element.querySelector('.modal_closer').addEventListener('click', () => {
            this._close();
        });
    }
    _working(bool){
        const working = this.element.querySelector('.working');
        if(bool){
            working.style.visibility = 'visible';
        } else {
            working.style.visibility = 'hidden';
        }
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

}
class Confirm_Modal extends Modal {
    constructor(data) {
        super(data);
    }

    _setup(){
        this.element.className += " small_modal";
        this.element.querySelector('.modal_body').innerHTML += `
            <div class="flex_center mb-4 icon_container">
                <i class="modal_icon"></i>
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

        let icon_class = 'fa-regular fa-circle-question';
        switch (this.data.icon) {
            case "info":
                icon_class = 'fa-solid fa-circle-info';
                break;
            case "danger":
                icon_class = 'fa-solid fa-triangle-exclamation';
                break;
            default:
                break;
        }
        this.element.querySelector('.modal_icon').className = "modal_icon "+icon_class;

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

    _setup(){
        const modal_data = this.data;
        this.element.className += " small_modal";
        this.element.querySelector('.modal_body').innerHTML += `
            <div class="flex_center mb-4 icon_container">
                <i class="modal_icon"></i>
            </div>

            <p class="text-center mb-2">${modal_data.body}</p>
            <div class="w-100 modal_input_box flex-column gap-2 align-items-center">
                <label></label>
                <input class="w-100" type="text">
            </div>
            <div class="modal_options">
                <button class="modal_cancel modal_choice_2">${modal_data.cancel}</button>
                <button class="modal_confirm modal_choice_1">${modal_data.confirm}</button>
            </div>
        `;

        let icon_class = 'fa-regular fa-circle-question';
        switch (modal_data.icon) {
            case "info":
                icon_class = 'fa-solid fa-circle-info';
                break;
            case "danger":
                icon_class = 'fa-solid fa-triangle-exclamation';
                break;
            default:
                break;
        }
        this.element.querySelector('.modal_icon').className = "modal_icon "+icon_class;

        const input_box = this.element.querySelector('.modal_input_box')
        const input = this.element.querySelector('input')

        if(modal_data['input_config']){
            input_box.style.display = 'flex';

            input.setAttribute('type', modal_data['input_config']['type'])
            input.setAttribute('placeholder', modal_data['input_config']['placeholder'])
            this.element.querySelector('label').textContent = modal_data['input_config']['label'];
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

    _setup(){
        this.element.querySelector('.modal_body').innerHTML += `
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
                        <label>${this.data.labels.country}</label>
                        <select id="create_select_country" name="create_select_country"></select>
                    </div>
                    <div class="form_line">
                        <label>${this.data.labels.category}</label>
                        <select id="create_select_category" name="create_select_category"></select>
                    </div>
                </div>

                <div class="form_line">
                    <label for="name">${this.data.labels.thumbnail_url}</label>
                    <input type="text" name="thumbnail_url"
                    value="https://commons.wikimedia.org/wiki/File:Capilla_de_Marmol_2017.jpg">
                </div>

                <div class="form_line">
                    <label for="name">${this.data.labels.name}</label>
                    <input type="text" name="name"
                    value="Marble Cathedral">
                </div>

                <div class="form_line">
                    <label for="name">${this.data.labels.gallery_url}</label>
                    <input type="text" name="gallery_url" placeholder="${this.data.labels.gallery_url_ph}"
                    value="https://commons.wikimedia.org/wiki/Category:Catedral_de_M%C3%A1rmol">
                </div>

                <div class="form_line">
                    <label for="synopsis">${this.data.labels.synopsis}</label>
                    <textarea name="synopsis">Caves of carbonate mineral formations, carved in the middle of Lake General Carrera</textarea>
                </div>

                <div class="aligner modal_options">
                    <button type="submit" class="modal_choice_1">${this.data.labels.submit}</button>
                </div>
            </div>
        </div>
        `;
        setTimeout(() => {
            this.data['on_load']();
            auto_resize(this.element.querySelector('textarea'));
            this.element.querySelector('.working').classList.remove('d-none');
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
        }, 250);
    }

    _listeners(){
        super._listeners();
        this.element.querySelector('button[type="submit"]').addEventListener('click', (event) => {
            this.data['on_submit'](this);
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
        let template = `
        <div class="modal scroll_modal">
            <div class="modal_header">
                <h4>${this.data.title}</h4>
                <nav class="buttons">
                    <div class="working d-inline-flex align-items-center gap-2" style="display: none; visibility: hidden">
                        <i class="fa-solid fa-spinner"></i>Please wait
                    </div>

                    <button class="modal_save button info"><i class="fa-solid fa-floppy-disk"></i></button>
                    <button class="modal_closer button red"><i class="fa-solid fa-xmark"></i></button>
                </nav>
            </div>
            <div class="modal_body"></div>
        </div>
        `;

        const temp = document.createElement('div');
        temp.innerHTML = template;
        this.element = temp.firstElementChild;
    }

    _setup(){
        const place = this.data.place;
        this.element.querySelector('.modal_body').innerHTML += `
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
                    <label for="name">Name</label>
                    <input type="text" name="name"
                    value="${place.name}">
                </div>

                <div class="form_line">
                    <label for="name">Gallery URL</label>
                    <div class="form_row">
                        <input class="flex-grow-1" type="text" name="gallery_url" placeholder="Wikimedia URL"
                        value="${place.gallery_url}">
                        <a href="${place.gallery_url}" target="_blank" class="button">
                            <i class="small_i fa-solid fa-up-right-from-square"></i>
                        </a>
                    </div>
                </div>

                <div class="form_line">
                    <label for="synopsis">Synopsis</label>
                    <textarea name="synopsis">${place.synopsis}</textarea>
                </div>
            </div>
        </div>
        <h4 class="my-3 pb-3 app_border_bottom w-100">Medias</h4>
        <div class="medias"></div>
        `;

        setTimeout(() => {
            this.data['on_load']();
            const select_locale = this.element.querySelector('#edit_select_locale');
            this.data.locales.forEach(function(locale){
                select_locale.innerHTML += `<option value="${locale}">${locale.toUpperCase()}</option>`;
            });
            auto_resize(this.element.querySelector('textarea'));

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
            const medias_container = document.querySelector('.medias');
            place.medias.forEach(media => {
                medias_container.innerHTML += `
                <div class="media" style="background-image: url('${media.url}')">
                <button class="button delete_button red"><i class="small_i fa-solid fa-trash"></i></button>
                </div>
                `;
            });
        }, 250);
    }

    _listeners(){
        super._listeners();
        this.element.querySelector('.modal_save').addEventListener('click', (event) => {
            console.log('on submit');
            this.data['on_submit'](this);
        });

    }
}
