const modal = document.querySelector('#modal');
const box = modal.querySelector('article');
function show_modal(modal_type, modal_data){
    modal_open();
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
    modal.querySelector('.modal_icon').className = "modal_icon "+icon_class;

    modal.querySelector('.modal_title').textContent = modal_data.title;
    modal.querySelector('.modal_text').textContent = modal_data.body;

    const modal_confirm = clone(modal.querySelector('.modal_confirm'))
    const modal_cancel = clone(modal.querySelector('.modal_cancel'))

    modal_confirm.textContent = modal_data.confirm;
    modal_cancel.textContent = modal_data.cancel;

    modal_confirm.className="modal_confirm"
    modal_cancel.className="modal_cancel"

    switch (modal_type) {
        case 'choice':
            modal_confirm.className +=" modal_choice_1"
            modal_cancel.className +=" modal_choice_2"
            break;
    }

    const input_box = modal.querySelector('.modal_input_box')
    const input = modal.querySelector('input')

    if(modal_data['input_config']){
        input_box.style.display = 'flex';

        input.setAttribute('type', modal_data['input_config']['type'])
        input.setAttribute('placeholder', modal_data['input_config']['placeholder'])
        modal.querySelector('label').textContent = modal_data['input_config']['label'];
    } else {
        input_box.style.display = 'none';
    }

    //add listeners
    modal_confirm.addEventListener('click', function(){
        modal_close();
        if(modal_data['on_confirm']){
            modal_data['on_confirm'](input.value);
        }
    });
    modal_cancel.addEventListener('click', function(){
        modal_close();
        if(modal_data['on_cancel']){
            modal_data['on_cancel'](input.value);
        }
    });
    modal.querySelector('.modal_closer').addEventListener('click', modal_close)
}

function modal_close(){
    box.style.scale = 0.5;
    modal.style.zIndex = -1;
        modal.style.visibility = 'hidden';

}
function modal_open(){
    box.style.scale = 1;
    modal.style.zIndex = 10035;
    modal.style.visibility = 'visible';

}

// show a Message object from the model
function show_message(message){
    const ul = document.querySelector('#popups ul');
    ul.innerHTML += `
    <li class="alert alert-${message.type}" onclick="event.target.style.display = 'none'">
        <i class="fa-solid ${message.icon}"></i>
        ${message.text}
        <i class="fa-solid fa-xmark"></i>
    </li>
    `;
    if(ul.children.length >= 5){
        ul.children[0].parentElement.removeChild(ul.children[0])
    }
}

// make alerts dismissable
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.alert').forEach(element => {
        element.addEventListener('click', function(){
            event.target.style.display = 'none';
        });
    });
});

// copy and replace an element, wipes listeners
function clone(element){
    let new_element = element.cloneNode(true);
    element.parentNode.replaceChild(new_element, element);
    return new_element;
}
