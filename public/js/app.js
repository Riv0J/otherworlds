// aplicar un header offset con el margin, cuando el main tiene la clase 'header_offset'
function set_header_offset(){
    let header_element = document.getElementsByTagName('header')[0];
    const offset_height = header_element.offsetHeight;

    //apply offset to main element
    if(document.querySelector('main.header_offset')){
        document.querySelector('main.header_offset').style.marginTop = `${offset_height}px`;
    }

}

document.addEventListener('DOMContentLoaded', set_header_offset);


document.addEventListener('scroll', function() {

    const header = document.getElementsByTagName('header')[0];
    if(header && window.innerWidth > 768){
        if (window.scrollY === 0) {
            console.log('El scroll está en la posición inicial');
            // Si el scroll está en la posición inicial, restaura el gradiente original
            header.style.background = 'linear-gradient(180deg, rgb(29, 29, 29) 1%, rgba(0,212,255,0) 100%)';
        } else {
            console.log(window.scrollY);
            // Calcula el valor del porcentaje basado en el desplazamiento, limitado a un máximo del 30%
            const percentage = Math.min((window.scrollY*2 / 10), 90);
            // Construye el gradiente dinámicamente con el porcentaje calculado
            header.style.background = `linear-gradient(180deg, rgb(29, 29, 29) ${percentage}%, rgba(0,212,255,0) 100%)`;
            console.log('El documento ha sido desplazado');
        }
    }
});
