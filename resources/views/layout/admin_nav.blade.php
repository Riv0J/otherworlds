<nav id="admin_aside">
    @php $logged = auth()->user() @endphp
    <div>
        <a href="javascript:void(0)" class="minimizer">
            <i class="fa-solid fa-arrow-left"></i>
            <h5></h5>
        </a>
        <div class="div_h"></div>
        <a id="home_anchor" href="{{route('home', ['locale' => $locale])}}" class="flex_center">
            <img src="{{asset('img/logo.png')}}">
            <h5 class="regular quicksand text-center">therworlds</h5>
        </a>
        <div class="div_h"></div>
        @php $current_url = url()->current(); @endphp

        <!-- <a href="#"
            @php if(str_ends_with($current_url,'admin/dashboard')){ echo('active'); } @endphp>
            <i class="fa-solid fa-house-chimney"></i>
            <h5 class="light">Dashboard</h5>
        </a> -->

        <a href="{{route('user_index', ['locale' => $locale])}}"
            @php if(str_ends_with($current_url,'admin/users')){ echo('active'); } @endphp>
            <i class="fa-solid fa-users"></i>
            <h5 class="light">
                @lang('otherworlds.users')
                @if($logged->is_guest())<i class="fa-solid fa-ban"></i>@endif
            </h5>
        </a>

        <a href="{{route('place_index', ['locale' => $locale])}}"
            @php if(str_ends_with($current_url,'admin/places')){ echo('active'); } @endphp>
            <i class="fa-solid fa-panorama"></i>
            <h5 class="light">@lang('otherworlds.places')</h5>
        </a>

        <a href="{{route('visit_index', ['locale' => $locale])}}"
            @php if(str_ends_with($current_url,'admin/visits')){ echo('active'); } @endphp>
            <i class="fa-solid fa-chart-line"></i>
            <h5 class="light">@lang('otherworlds.visits')
                @if($logged->is_guest())<i class="fa-solid fa-ban"></i>@endif
            </h5>
        </a>

    </div>
    <div>
        <a href="{{ route('development',['locale' => $locale]) }}">
            @php if(str_ends_with($current_url,'admin/development')){ echo('active'); } @endphp
            <i class="fa-solid fa-laptop-code"></i>
            <h5 class="light">Development</h5>
        </a>

        <a href="{{route('server')}}"
            @php if(str_ends_with($current_url,'admin/server')){ echo('active'); } @endphp>
            <i class="fa-solid fa-server"></i>
            <h5 class="light">@lang('otherworlds.server')
                @if($logged->is_guest())<i class="fa-solid fa-ban"></i>@endif
            </h5>
        </a>
        {{-- <a href="#"
            @php if(str_ends_with($current_url,'admin/config')){ echo('active'); } @endphp>
            <i class="fa-solid fa-gear"></i>
            <h5 class="light">@lang('otherworlds.config')[NYI]</h5>
        </a> --}}
        <a href="{{route('commands')}}"
            @php if(str_ends_with($current_url,'admin/commands')){ echo('active'); } @endphp>
            <i class="fa-solid fa-terminal"></i>
            <h5 class="light">@lang('otherworlds.commands')
                @if($logged->is_guest())<i class="fa-solid fa-ban"></i>@endif
            </h5>
        </a>
        <a href="javascript:void(0)" class="minimizer">
            <i class="fa-solid fa-arrow-left"></i>
            <h5></h5>
        </a>
    </div>
</nav>
<style>
    #admin_aside{
        position: sticky; top: 0;
        background-color: var(--black);
        height: 100svh;
        border-right: 2px solid var(--gray);

        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    #admin_aside a{
        position: relative;
        display: flex;
        padding-inline: 1.5rem !important;
        gap: 0.5rem;
    }
    #admin_aside a[active]:not(#home_anchor)::after{
        content: '';
        position: absolute;
        inset: 0;
        border-left: 3px solid var(--cyan_light);
        background-color: var(--gray_opacity);
        z-index: -1;
    }
    #admin_aside a:not(#home_anchor){
        padding-block: 0.5rem !important;
        border-bottom: 2px solid var(--gray);
    }
    #home_anchor{
        padding-block: 1rem !important;
        border: 0;
        font-size: 1.5rem;
    }
    #admin_aside a:hover{
        background: var(--gray_opacity)
    }
    #admin_aside h5{
        display: inline-flex;
        overflow: hidden;
    }
    #admin_aside i{
        font-size: 1rem;
        min-width: 18px;
    }
    #admin_aside h5 i{
        font-size: 0.75rem;
        margin-left: 0.25rem
    }
    #admin_aside img{
        width: 1.25rem;
        scale: 1.75;
    }
    #admin_aside .div_h{
        transform: scaleX(0.85);
        padding: 0 !important;
    }
    .minimizer{
        justify-content: center;
        border-bottom: none !important;
    }
    .minimizer i{
        transition: all 0.5s;
    }
</style>
<script src="{{asset('js/cookies.js')}}"></script>
<script>
    let minimized = false;

    // if open is false, close the aside
    const open = get_cookie("otherworlds_admin_nav");
    if(open == "false"){ toggle_admin_aside(); }

    // event listeners
    document.querySelectorAll('.minimizer').forEach(minimizer => {
        minimizer.addEventListener('click', function(){
            create_cookie("otherworlds_admin_nav", minimized, 31);
            toggle_admin_aside()
        });
    });

    function toggle_admin_aside(){
        // toggle minimized
        minimized = !minimized;

        // change each anchor
        const anchors = document.querySelector('#admin_aside').querySelectorAll('a');
        anchors.forEach(anchor => {

            const h5 = anchor.querySelector('h5');
            let new_width = 0;
            if(minimized == false){
                anchor.style.gap = '0.5rem';
                new_width = h5.scrollWidth+'px';
            } else {
                anchor.style.gap = 0;
            }

            h5.style.width = new_width;
        });

        // flip all minimizers
        document.querySelectorAll('.minimizer').forEach(minimizer => {
            const i = minimizer.querySelector('i');
            if(minimized == false){
                i.style.rotate = '0deg';
            } else {
                i.style.rotate = '180deg';
            }
        });
    }
</script>

