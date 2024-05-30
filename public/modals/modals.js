class Modal {
    constructor(type, data, options = {}) {
        let defaults = {
            type: 'confirm',
            title: 'Modal title',
            align: 'center',
        };
        //asign the options passed in the constructor
        this.options = Object.assign(defaults, options);
        this._template();
        this._content();
        this._listeners();
        this._show();
    }

    _template() {
        let template = `
        <div class="modal">
            <div class="modal_title">
                <h3>${this.options.title}</h3>
                <nav class="buttons">
                    <button class="modal_closer button red"><i class="fa-solid fa-xmark"></i></button>
                </nav>
            </div>
            <div class="modal_body">
                    Modal Content
            </div>
        </div>
        `;

        const temp = document.createElement('div');
        temp.innerHTML = template;
        this.element = temp.firstElementChild;
    }

    _listeners(){
        this.element.querySelector('.modal_closer').addEventListener('click', () => {
            this._close();
        });
    }
    _content(){
        let content = '';
        switch (this.options.type) {
            case 'confirm':
                content = `
                <div class="flex_center mb-4 icon_container">
                        <i class="modal_icon"></i>
                    </div>

                    <p class="modal_text"></p>
                    <div class="w-100 modal_input_box flex-column gap-2 align-items-center">
                        <label></label>
                        <input class="w-100" type="text">
                    </div>
                </div>
                <div class="modal_options justify-content-around d-flex flex-row gap-5">
                    <button class="modal_cancel"></button>
                    <button class="modal_confirm"></button>
                </div>
                `;
                break;

            default:
                content = 'No content'
                break;
        }
        this.element.querySelector('.modal_body').innerHTML += content;
    }
    _close(){
        this.element.style.scale = 0.3;
        this.element.style.opacity = 0;

        setTimeout(() => {
            this.element.parentElement.removeChild(this.element);
            document.querySelector('#modal_container').style.visibility = 'hidden';
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
