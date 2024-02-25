function init_dropdowns(){
    const togglers = document.getElementsByClassName('dropdown_toggler');

    Array.from(togglers).forEach(function(toggler) {
        const options = toggler.nextElementSibling;
        const max_height = options.scrollHeight; //get the options max height

        options.style.visibility = "visible";
        options.style.height = 0;

        toggler.addEventListener('click', function(){

            if(options.style.height == '0px'){
                const new_height = (max_height === 0) ? 'auto' : max_height + 'px';
                //if max height === 0, aplicar auto, de lo contrario el height en px
                options.style.height = new_height;
            } else {
                options.style.height = '0px';
            }

        });
    });

}
document.addEventListener('DOMContentLoaded', init_dropdowns);
