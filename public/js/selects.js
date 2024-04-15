/*
 * Created by David Adams
 * https://codeshack.io/dynamic-select-images-html-javascript/
 *
 * Released under the MIT license
 */

/*
 * Adapted by Rivo :)
 */

class DynamicSelect {

    constructor(element, options = {}) {
        let defaults = {
            placeholder: 'Select an option',
            columns: 1,
            name: '',
            width: '',
            height: '',
            data: [],
            onChange: function() {}
        };
        this.options = Object.assign(defaults, options);
        this.selectElement = typeof element === 'string' ? document.querySelector(element) : element;
        for(const prop in this.selectElement.dataset) {
            if (this.options[prop] !== undefined) {
                this.options[prop] = this.selectElement.dataset[prop];
            }
        }
        this.name = this.selectElement.getAttribute('name') ? this.selectElement.getAttribute('name') : 'dynamic-select-' + Math.floor(Math.random() * 1000000);
        if (!this.options.data.length) {
            let options = this.selectElement.querySelectorAll('option');
            for (let i = 0; i < options.length; i++) {
                this.options.data.push({
                    value: options[i].value,
                    text: options[i].innerHTML,
                    selected: options[i].selected,
                    html: options[i].getAttribute('data-html'),
                });
            }
        }
        this.element = this._template();
        this.selectElement.replaceWith(this.element);
        this._updateSelected();
        this._eventHandlers();
    }

    _template() {
        let template = `
            <div class="form-control dynamic-select ${this.name}"${this.selectElement.id ? ' id="' + this.selectElement.id + '"' : ''} style="${this.width ? 'width:' + this.width + ';' : ''}${this.height ? 'height:' + this.height + ';' : ''}">
                <input type="hidden" name="${this.name}" value="${this.selectedValue}">
                <div class="dynamic-select-header" style="${this.width ? 'width:' + this.width + ';' : ''}${this.height ? 'height:' + this.height + ';' : ''}">
                    <div class="dynamic-selected d-none">
                    </div>
                    <span class="dynamic-select-header-placeholder">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ${this.placeholder}
                    </span>
                    <span class="dynamic-select-header-input d-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input style="width:100%" type="text">
                        <i class="fa-solid fa-xmark dynamic-select-quit"></i>
                    </span>
                </div>
                <div class="dynamic-select-options" style="${this.options.dropdownWidth ? 'width:' + this.options.dropdownWidth + ';' : ''}${this.options.dropdownHeight ? 'height:' + this.options.dropdownHeight + ';' : ''}"></div>
                </div>
            </div>
        `;
        let element = document.createElement('div');
        element.innerHTML = template;
        return element;
    }

    _eventHandlers() {
        //onclick the header
        this.element.querySelector('.dynamic-select-header').onclick = () => {
            const select_header = this.element.querySelector('.dynamic-select-header');
            if(select_header.classList.contains('dynamic-select-header-active')){ return; }

            select_header.classList.add('dynamic-select-header-active'); //header add active
            this.toggleComponent('dynamic-select-header-placeholder', false); //placeholder off
            this.toggleSearch(true); //search on
            this.refresh_options(this.options.data); //generate the option divs
            this.scroll_to_options();
        };

        //onclick away, lose focus
        document.addEventListener('click', event => {
            if (!event.target.closest('.' + this.name) && !event.target.closest('label[for="' + this.selectElement.id + '"]')
                || event.target == this.element.querySelector('.dynamic-select-quit')) {
                this.element.querySelector('.dynamic-select-header').classList.remove('dynamic-select-header-active'); //header remove active

                this.toggleSearch(false); //search off
                const current_select_value = this.element.querySelector('input[name='+this.name+']').value;

                if(current_select_value == ''){
                    this.toggleComponent('dynamic-select-header-placeholder', true); //placeholder on
                    this.toggleComponent('dynamic-selected', false); //selected off
                } else {
                    this.toggleComponent('dynamic-selected', true); //selected on
                }
            }
        });

        //search input listener
        this.element.querySelector('input[type=text]').addEventListener('input', event => {
            const search = this.element.querySelector('input[type=text]').value.toLowerCase();
            const filtered_options = this.options.data.filter(function(option) {
                return option.keyword.toLowerCase().includes(search);
            });

            this.refresh_options(filtered_options);
            this.scroll_to_options();
        });
    }

    refresh_options(options_array){
        let optionsHTML = '';
        for (let i = 0; i < options_array.length; i++) {
            let optionWidth = 100 / this.columns;
            let optionContent = '';
            if (options_array[i].html) {
                optionContent = options_array[i].html;
            } else {
                optionContent = `
                    ${options_array[i].img ? `<img src="${options_array[i].img}" alt="${options_array[i].text}" class="${options_array[i].imgWidth && options_array[i].imgHeight ? 'dynamic-size' : ''}" style="${options_array[i].imgWidth ? 'width:' + options_array[i].imgWidth + ';' : ''}${options_array[i].imgHeight ? 'height:' + options_array[i].imgHeight + ';' : ''}">` : ''}
                    ${options_array[i].text ? '<span class="dynamic-select-option-text">' + options_array[i].text + '</span>' : ''}
                `;
            }
            optionsHTML += `
                <div class="dynamic-select-option${options_array[i].value == this.selectedValue ? ' dynamic-select-selected' : ''}${options_array[i].text || options_array[i].html ? '' : ' dynamic-select-no-text'}" data-value="${options_array[i].value}" style="width:${optionWidth}%;${this.height ? 'height:' + this.height + ';' : ''}">
                    ${optionContent}
                </div>
            `;

        }
        console.log(options_array.length);
        this.element.querySelector('.dynamic-select-options').innerHTML = optionsHTML
        this.refresh_options_listeners();
    }

    refresh_options_listeners(){
        this.element.querySelectorAll('.dynamic-select-option').forEach(option => {
            option.onclick = () => {
                this.element.querySelectorAll('.dynamic-select-selected').forEach(selected => selected.classList.remove('dynamic-select-selected'));
                option.classList.add('dynamic-select-selected');
                this.element.querySelector('.dynamic-selected').classList.remove('d-none');
                this.element.querySelector('.dynamic-selected').innerHTML = option.innerHTML;

                this.toggleComponent('dynamic-select-header-placeholder', false);
                this.toggleSearch(false);

                this.element.querySelector('input[name='+this.name+']').value = option.getAttribute('data-value');
                console.log(this.element.querySelector('input[name='+this.name+']').value);
                this.data.forEach(data => data.selected = false);
                this.data.filter(data => data.value == option.getAttribute('data-value'))[0].selected = true;
                this.element.querySelector('.dynamic-select-header').classList.remove('dynamic-select-header-active');
                this.options.onChange(option.getAttribute('data-value'), option.querySelector('.dynamic-select-option-text') ? option.querySelector('.dynamic-select-option-text').innerHTML : '', option);
            };
        });
    }

    toggleComponent(element_class, show){
        const element = this.element.querySelector('.'+element_class);
        if(!element){ console.error('Didnt find element.'); return}
        if(show == true){
            element.classList.remove('d-none');
        } else {
            element.classList.add('d-none');
        }
    }

    toggleSearch(show){
        const text_input_container = this.element.querySelector('.dynamic-select-header-input');
        const dynamic_selected = this.element.querySelector('.dynamic-selected');

        const text_input = this.element.querySelector('input[type=text]');
        text_input.value = '';
        if(show == true){
            text_input_container.classList.remove('d-none');
            text_input.focus();
            dynamic_selected.classList.add('d-none');
        } else {
            text_input_container.classList.add('d-none');
            dynamic_selected.classList.remove('d-none');
        }
    }
    scroll_to_options(){
        scrollToElement(this.element.querySelector('.dynamic-select-options'));
    }
    _updateSelected() {
        if (this.selectedValue) {
            this.element.querySelector('.dynamic-selected').innerHTML = this.element.querySelector('.dynamic-select-selected').innerHTML;
        }
    }

    get selectedValue() {
        let selected = this.data.filter(option => option.selected);
        selected = selected.length ? selected[0].value : '';
        return selected;
    }

    set data(value) {
        this.options.data = value;
    }

    get data() {
        return this.options.data;
    }

    set selectElement(value) {
        this.options.selectElement = value;
    }

    get selectElement() {
        return this.options.selectElement;
    }

    set element(value) {
        this.options.element = value;
    }

    get element() {
        return this.options.element;
    }

    set placeholder(value) {
        this.options.placeholder = value;
    }

    get placeholder() {
        return this.options.placeholder;
    }

    set columns(value) {
        this.options.columns = value;
    }

    get columns() {
        return this.options.columns;
    }

    set name(value) {
        this.options.name = value;
    }

    get name() {
        return this.options.name;
    }

    set width(value) {
        this.options.width = value;
    }

    get width() {
        return this.options.width;
    }

    set height(value) {
        this.options.height = value;
    }

    get height() {
        return this.options.height;
    }

}
document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));

function scrollToElement(element) {
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      console.error("Elemento no encontrado");
    }
  }

