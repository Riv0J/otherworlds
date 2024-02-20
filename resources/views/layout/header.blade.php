<!-- Responsive navbar-->
<header class="fixed-top navbar bg_gradient_black">
    <div class="container py-2 py-lg-3 px-3 px-lg-5 white">
        {{-- home anchor --}}
        <a class="brand_anchor white gap-2" href="{{route('home')}}">
            @include('icons.moon_white')
            <span>therworlds</span>
        </a>

        {{-- responsive button --}}
        </button>
        <button id="responsive_nav_toggler" class="d-md-block d-lg-none">
            <i class="ri-menu-line"></i>
        </button>

        {{-- nav --}}
        <nav id="responsive_nav" class="
            px-3 px-lg-0
            gap-2 gap-lg-4
            py-3 py-lg-0
            d-none d-lg-flex
            flex-md-row flex-column">

            <a class="
            p-3 p-lg-1
            px-4 px-lg-2
            regular @php if('Places' == $current_section){ echo('active_link'); } @endphp" href="{{route('places')}}">
                @lang('otherworlds.places')
            </a>
            <div class="flex_center gap-2">
                @foreach ( config('translatable.locales') as $locale)
                    @if($locale != app()->getLocale())
                        <a href="{{route('setLocale', ['locale' => $locale])}}">{{strtoupper($locale)}}</a>

                        @endif
                @endforeach



            </div>
        </nav>
    </div>
</header>
<div id="mask" class="d-none bg_gradient_black"></div>
<script>
    const responsive_nav_toggler = document.getElementById('responsive_nav_toggler');
    const responsive_nav = document.getElementById('responsive_nav');
    const mask = document.getElementById('mask');

    responsive_nav_toggler.addEventListener('click', function(){

        responsive_nav.classList.toggle('d-flex');
        responsive_nav.classList.toggle('d-none');
        mask.classList.toggle('d-none');
    });

</script>

<style>
    #mask{
        position: fixed;
        width: 100vw;
        height: 100svh;
    }
    header a{
    color: white;
    text-decoration: none;
    }
    #responsive_nav_toggler{
        background: none;
        border: none;
        color: white;
        transform: scale(1.25);
    }
    #responsive_nav{
        background: none;
        border: none;
        color: white;
        overflow: hidden;
        -webkit-transition: height 1s ease;
        -moz-transition: height 1s ease;
        -o-transition: height 1s ease;
        transition: height 1s ease;
    }
    #responsive_nav a{
        font-size: 1.3rem;
        letter-spacing: 0.03rem;
    }
</style>

{{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="#!">
            <img class="app_icon" src="{{asset('img/moon.svg')}}" alt="">
            Otherworlds
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
            </ul>
        </div>
    </div>
</nav> --}}