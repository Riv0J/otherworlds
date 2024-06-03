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
    setTimeout(() => {
        if(ul.children.length >= 1){
            ul.children[0].parentElement.removeChild(ul.children[0])
        }
    }, 5000);
}

// make alerts dismissable
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.alert').forEach(element => {
        element.addEventListener('click', function(){
            event.target.style.display = 'none';
        });
    });
});
