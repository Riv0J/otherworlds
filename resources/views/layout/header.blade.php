{{-- Responsive navbar --}}
<header class="fixed-top navbar bg_gradient_black">
    <div class="container py-1 py-lg-2 px-3 px-lg-5 white">
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
            flex-column flex-lg-row">

            {{-- places link --}}
            <a class="nav_link
            p-3 p-lg-1
            px-4 px-lg-2
            regular @php if(isset($current_section) && 'Places' == $current_section){ echo('active_link'); } @endphp" href="{{route('places')}}">
                @lang('otherworlds.places')
            </a>

            {{-- login button --}}
            @if (Route::has('login') && Auth::user() == null)
            <a class="nav_link
            p-3 p-lg-1
            px-4 px-lg-2
            regular"
            href="{{ route('login') }}">Login</a>
            @endif

            {{-- user options --}}
            @if(Auth::user())
            <form id="logout_form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            <div class="dropdown
            p-3 p-lg-1
            px-4 px-lg-3
            regular">
                <a href="javascript:void(0)" class="flex_center gap-2 dropdown_toggler">
                    <i class="ri-user-3-fill d-block d-lg-none"></i>
                    {{Auth::user()->name}}
                    <i class="fa-solid fa-angle-down"></i>
                </a>

                <div class="dropdown_options">

                    <a href="{{ route('logout') }}" class="p-2 px-4"
                    onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                    @lang('Logout')
                    </a>

                    <div class="dropdown_divider mt-1"></div>

                    <a href="{{ route('logout') }}" class="p-2 px-4"
                        onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                        @lang('Logout')
                    </a>
                </div>
            </div>
            @endif

                        {{-- places link --}}
                        <a class="nav_link
                        p-3 p-lg-1
                        px-4 px-lg-2
                        regular @php if(isset($current_section) && 'Places' == $current_section){ echo('active_link'); } @endphp" href="{{route('places')}}">
                            Requests
                        </a>
            {{-- lang buttons --}}
            {{-- <div class="flex_center flex-column gap-2">
                <div class="divider col-6 col-md-4 my-4 d-block d-lg-none"></div>
                @foreach ( config('translatable.locales') as $locale)
                    @if($locale != app()->getLocale())
                        <a class="nav_link" href="{{route('setLocale', ['locale' => $locale])}}">{{strtoupper($locale)}}</a>
                    @endif
                @endforeach
            </div> --}}

        </nav>
    </div>
</header>
<div id="mask" class="d-none"></div>
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
                .dropdown {
                    position: relative;
                }

                .dropdown_toggler {
                    cursor: pointer;
                    position: relative;
                    cursor: pointer;
                }

                .dropdown_options {
                    overflow: hidden;
                    visibility: hidden;

                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;

                    position: absolute;
                    top: 100%;
                    left: 0;
                    width: 100%;

                    background-color: var(--black);
                    border-radius: 0.5rem;
                    transition: all 0.5s ease;
                }

                .dropdown_options a {
                    display: block;
                    color: var(--white);
                    transition: all 0.3s ease;
                    z-index: 1000;
                    min-height: 40px;
                }
                .dropdown_options a:hover{
                    background-color: var(--gray);
                }
                .dropdown_divider{
                    width: 90%;
                    height: 1px;
                    border-top: 0.1rem solid white;
                }

                @media screen and (max-width: 992px) {
                    .dropdown_options{
                        display: block;
                        position: relative;
                        background-color: none;
                    }
                }

    /* esta mask se muestra cuando se abre el menu responsive */
    #mask{
        inset: 0;
        position: fixed;
        width: 100vw;
        height: 100svh;
        z-index: 1000;
        background: rgb(29, 29, 29);
        background: linear-gradient(180deg, rgb(29, 29, 29) 50%, rgba(0,212,255,0) 100%);
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
        overflow: visible;
        -webkit-transition: height 1s ease;
        -moz-transition: height 1s ease;
        -o-transition: height 1s ease;
        transition: height 1s ease;
    }
    #responsive_nav a{
        position: relative;
        font-size: 1.3rem;
        letter-spacing: 0.03rem;
    }
    .nav_link::before{
        position: absolute;
        content: '';
        top: 0;
        left: 50%;
        width: 0;
        height: 100%;
        transition: all 0.5s;

        border-bottom: 0.2rem solid var(--main);
        z-index: 1000;
    }
    .nav_link:hover::before{
        left: 0;
        width: 100%;
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
