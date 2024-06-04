// show a Message object from the model
function show_message(message){
    const ul = document.querySelector('#popups ul');
    const li = document.createElement('li');
    li.className = `alert alert-${message.type}`;
    li.setAttribute('onclick','event.target.style.display = "none"');
    li.innerHTML = `
        <i class="fa-solid ${message.icon}"></i>
        ${message.text}
        <i class="fa-solid fa-xmark"></i>
    `;
    ul.appendChild(li);

    if(ul.children.length > 3){
        ul.removeChild(ul.children[0])
    }
    setTimeout(() => {
        ul.removeChild(li);
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
