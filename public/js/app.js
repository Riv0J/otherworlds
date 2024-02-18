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
