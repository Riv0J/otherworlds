function init_dropdowns(){
    const togglers = document.getElementsByClassName('dropdown_toggler');

    Array.from(togglers).forEach(function(toggler) {
        const options = toggler.nextElementSibling;
        const max_height = options.offsetHeight; //get the options max height

        options.style.visibility = "visible";
        options.style.height = 0;

        toggler.addEventListener('click', function(){
            //get currently active .dropdown_options
            const active_options = document.querySelectorAll('.dropdown_options[active="true"]');

            //open the clicked options if height = 0px
            if(options.style.height == '0px'){

                //if max height === 0, aplicar auto, de lo contrario el height en px
                const new_height = (max_height === 0) ? 'auto' : max_height + 'px';

                options.style.height = new_height;
                options.setAttribute('active', true);
            }

            //close all other active_options
            Array.from(active_options).forEach(function(active_option) {
                active_option.style.height = '0px';
                active_option.setAttribute('active', false);
            });
        });
    });

}
document.addEventListener('DOMContentLoaded', init_dropdowns);
