function SetHeaderOffSet(){
    let header_element = document.getElementsByTagName('header')[0];
    const alturaHeader = header_element.offsetHeight;

    //apply offset to main element
    document.querySelector('main').style.marginTop = `${alturaHeader}px`;

}
// document.addEventListener('DOMContentLoaded', SetHeaderOffSet);
