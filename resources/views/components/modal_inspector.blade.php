<div id="inspect_modal" class="flex_center">
    <div id="inspect_box" class="bg_black p-3 border pt-4">
        <div class="flex_center position-relative">
            <button id="inspect_closer" class="button red"><i class="fa-solid fa-xmark"></i></button>
            <button id="next" class="button border"><i class="fa-solid fa-chevron-right"></i></button>
            <button id="last" class="button border"><i class="fa-solid fa-chevron-left"></i></button>
            <img>
        </div>

        <div class="mt-2">
            <p></p>
            <a class="mx-2" href="" target="_blank">
                <span>@lang('otherworlds.view_image_source')</span>
                <i class="small_i fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </div>

    </div>
</div>
<style>
    #next,#last{
        z-index: 1030;
    }
    #next{
        right: 0.5rem;
    }
    #last{
        left: 0.5rem;
    }
    #inspect_closer{
        right: 0.5rem;
        top: 0.5rem;
    }
    #inspect_modal{
        position: fixed;
        inset: 0;
        background-color: var(--black_opacity);
        z-index: -1;

        transition: all 0.5s;
        opacity: 0;
    }
    #inspect_modal button{
        position: absolute;
    }
    #inspect_box{
        color: var(--white);
        width: 90%;

        transition: all 0.5s;
        scale: 0;
    }

    #inspect_box img {
        width: auto;
        max-width: 100%;
        max-height: 65svh;
    }
    @media screen and (max-width: 778px) {
        #next,#last{
            scale: 1.25
        }
    }
</style>
<script>
    const inspect_modal = document.getElementById('inspect_modal');
    const inspect_box = document.getElementById('inspect_box');

    //set a media in the inspect inspect_box
    function set_media(media){
        const img =  inspect_box.querySelector('img');
        img.src = media.url;

        const a =  inspect_box.querySelector('a');
        const p = inspect_box.querySelector('p');

        if(media.page_url != null){
            a.href = media.page_url;
            a.style.display = 'inline-flex';
        } else {
            a.style.display = 'none';
        }

        if(media.description != null){
            p.textContent = media.description;
            p.style.display = 'initial';
        } else {
            p.style.display = 'none';
        }
        if(media.page_url == null && media.description == null){
            img.className = '';
        } else {
            img.className = 'mb-2';
        }
    }
    //onclick when inspect_modal is beign shown, close
    document.addEventListener('click', function(){
        if(event.target === inspect_modal){ close_modal() }
    })

    //onclick #inspect_closer
    inspect_modal.querySelector('#inspect_closer').addEventListener('click', close_modal);

    //onclicks
    inspect_modal.querySelector('#next').addEventListener('click', function(){
        if(index + 1 >= loaded_medias.length){
            index = 0;
        } else {
            index++;
        }
        set_media(loaded_medias[index]);
    });
    inspect_modal.querySelector('#last').addEventListener('click', function(){
        if(index - 1 <= 0){
            index = loaded_medias.length-1;
        } else {
            index--;
        }
        set_media(loaded_medias[index]);
    });

    function close_modal() {
        inspect_modal.style.opacity = 0;
        inspect_modal.style.zIndex = -1;
        inspect_box.style.scale = 0.3;
    }
    function open_modal(){
        inspect_modal.style.opacity = 1;
        inspect_modal.style.zIndex = 1031;
        inspect_box.style.scale = 1;
    }
</script>
