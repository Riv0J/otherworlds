function init_dropdowns(){
    const togglers = document.getElementsByClassName('dropdown_toggler');

    Array.from(togglers).forEach(function(toggler) {
        const options = toggler.nextElementSibling;
        const max_height = options.offsetHeight;

        options.style.visibility = "visible";
        options.style.height = '0px';
        console.log(max_height);

        toggler.addEventListener('click', function(){
            console.log(options.style.height);
            if(options.style.height == '0px'){
                options.style.height = max_height+'px';
            } else {
                options.style.height = '0px';
            }

        });
    });

}
document.addEventListener('DOMContentLoaded', init_dropdowns);
