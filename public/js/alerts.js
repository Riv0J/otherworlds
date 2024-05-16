const modal = document.querySelector('#modal_confirm');
const box = modal.querySelector('article');
function modal_confirm(modal_data){
    modal_open();
    modal.querySelector('.modal_title').textContent = modal_data.title;
    modal.querySelector('.modal_text').textContent = modal_data.body;
    modal.querySelector('.modal_cancel').textContent = modal_data.cancel;
    modal.querySelector('.modal_confirm').textContent = modal_data.confirm;

    modal.querySelector('.modal_cancel').addEventListener('click', function(){
        modal_close();
    });

    modal.querySelector('.modal_confirm').addEventListener('click', function(){
        modal_close();
        modal_data['on_confirm']();
    });
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
