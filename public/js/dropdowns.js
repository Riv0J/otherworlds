function init_dropdowns(){
    const togglers = document.getElementsByClassName('dropdown_toggler');

    Array.from(togglers).forEach(function(toggler) {
        const options = toggler.nextElementSibling;
        const max_height = options.scrollHeight; //get the options max height

        options.style.visibility = "visible";
        options.style.height = 0;

        toggler.addEventListener('click', function(){
            //close all other togglers active

            const active_options = document.querySelectorAll('.dropdown_options[active="true"]');

            if(options.style.height == '0px'){
                const new_height = (max_height === 0) ? 'auto' : max_height + 'px';
                //if max height === 0, aplicar auto, de lo contrario el height en px
                options.style.height = new_height;
                options.setAttribute('active', true);
            }

            //close all active_options
            console.log(active_options);
            Array.from(active_options).forEach(function(active_option) {
                active_option.style.height = '0px';
                options.setAttribute('active', false);
            });

        });
    });

}
document.addEventListener('DOMContentLoaded', init_dropdowns);
