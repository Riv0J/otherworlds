

class Modal {
    constructor(options = {}, data) {
        let defaults = {
            title: 'Modal title',
        };

        //asign the defaults passed in the constructor
        this.options = Object.assign(defaults, options);
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
                <h4>${this.options.title}</h4>
                <nav>
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
        console.log('Adding base listeners')
        this.element.querySelector('.modal_closer').addEventListener('click', () => {
            this._close();
        });
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
class Confirm_Modal extends Modal {
    constructor(options, data) {
        super(options, data);
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
            <div class="modal_options justify-content-around d-flex flex-row mt-4">
                <button class="modal_cancel">${modal_data.cancel}</button>
                <button class="modal_confirm">${modal_data.confirm}</button>
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
            console.log(this.data);
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
