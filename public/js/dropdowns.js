function init_dropdowns(){
    const togglers = document.getElementsByClassName('dropdown_toggler');

    Array.from(togglers).forEach(function(toggler) {
        const options = toggler.nextElementSibling;
        const max_height = options.scrollHeight; //get the options max height
        console.log(max_height);
        options.style.visibility = "visible";
        options.style.height = 0;

        toggler.addEventListener('click', function(){

            if(options.style.height == '0px'){
                options.style.height = max_height+'px';
            } else {
                options.style.height = '0px';
            }

        });
    });

}
document.addEventListener('DOMContentLoaded', init_dropdowns);
