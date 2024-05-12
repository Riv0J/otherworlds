// aplicar un offset con el margin, a la primer section con la clase 'header_offset'
function set_header_offset(){
    let header_element = document.getElementsByTagName('header')[0];
    const offset_height = header_element.offsetHeight * 0.8;

    //apply offset to element
    // const element = document.querySelector('.header_offset');
    // element.style.marginTop = `${offset_height}px`;
    // console.log(offset_height);
}

document.addEventListener('DOMContentLoaded', set_header_offset);

//header effect on scroll
document.addEventListener('scroll', function() {

    const header = document.getElementsByTagName('header')[0];
    if(header && window.innerWidth > 768){
        if (window.scrollY === 0) {
            // console.log('El scroll está en la posición inicial');
            // Si el scroll está en la posición inicial, restaura el gradiente original
            header.style.background = 'linear-gradient(180deg, rgb(29, 29, 29) 1%, rgba(0,212,255,0) 100%)';
        } else {
            // Calcula el valor del porcentaje basado en el desplazamiento, limitado a un máximo del 30%
            const percentage = Math.min((window.scrollY*2 / 10), 90);
            // Construye el gradiente dinámicamente con el porcentaje calculado

            header.style.background = `linear-gradient(180deg, rgb(29, 29, 29) ${percentage}%, rgba(0,212,255,0) 100%)`;
            // console.log(window.scrollY+ '. El documento ha sido desplazado');
        }
    }
});

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
