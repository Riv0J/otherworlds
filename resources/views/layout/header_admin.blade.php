<aside id="admin_header">
    <div>
        <button id="minimizer">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <a href="#">
            <i class="fa-solid fa-house-chimney"></i>
            <h5>Dashboard</h5>
        </a>
        <a href="{{route('users_index', ['locale' => $locale])}}">
            <i class="fa-solid fa-users"></i>
            <h5>Users</h5>
        </a>
        <a href="{{route('place_index', ['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug')])}}">
            <i class="fa-solid fa-panorama"></i>
            <h5>Places</h5>
        </a>
    </div>

</aside>
<style>
    #admin_header{
        position: relative;
        background-color: var(--black);
        min-height: 100svh;
        border-right: 2px solid var(--gray);
        z-index: 1032;
    }
    #admin_header>div{
        position: sticky;
    }
    #admin_header a{
        transition: all 0.25s;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        text-align: left !important;
        margin: 0 !important;
        padding: 0.5rem !important;
        padding-inline: 1rem !important;
        gap: 1rem;
        border: none;
    }
    #admin_header a:hover{
        background: var(--gray_opacity)
    }
    #admin_header h5{
        transition: all 0.5s;
        overflow: hidden;
    }
    #admin_header i{
        font-size: 1rem;
    }
    #minimizer{
        position: absolute;
        top: 0;
        left: 100%;
        background-color: var(--black);
        border: 2px solid var(--gray);
        aspect-ratio: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: .5rem;
    }
    #minimizer i{
        transition: all 0.5s;
    }
</style>
<script>
    const menu = document.querySelector('#admin_header');
    const minimizer = document.querySelector('#minimizer');
    let minimized = false;

    // event listeners
    document.addEventListener('DOMContentLoaded', function(){
        // set each original_width
        menu.querySelectorAll('h5').forEach(element => {
            element.setAttribute('original_width', element.offsetWidth);
        });
    });

    minimizer.addEventListener('click', toggle_admin_header);

    function toggle_admin_header(){
        const anchors = menu.querySelectorAll('a');

        // change each anchor
        anchors.forEach(anchor => {
            const h5 = anchor.querySelector('h5');

            if(minimized == true){
                anchor.style.gap = '1rem';
                h5.style.width = h5.getAttribute('original_width')+'px';
            } else {
                anchor.style.gap = 0;
                h5.style.width = 0;
            }
        });

        // flip the arrow
        const i = minimizer.querySelector('i');
        if(minimized == true){
            i.style.rotate = '0deg';
        } else {
            i.style.rotate = '180deg';
        }

        // toggle minimized
        minimized = !minimized;
    }
</script>
