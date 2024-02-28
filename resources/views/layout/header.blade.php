{{-- Responsive navbar --}}
<header class="fixed-top navbar bg_gradient_black">
    <div class="container py-1 py-lg-2 px-3 px-lg-5 white">
        {{-- home anchor --}}
        <a class="brand_anchor white gap-2" href="{{ route('home') }}">
            @include('icons.moon_white')
            <span>therworlds</span>
        </a>

        {{-- responsive button --}}
        </button>
        <button id="responsive_nav_toggler" class="d-md-block d-lg-none">
            <i class="ri-menu-line"></i>
        </button>

        {{-- nav --}}
        <nav id="responsive_nav"
            class="
            px-3 px-lg-0
            gap-2 gap-lg-4
            py-3 py-lg-0
            d-none d-lg-flex
            flex-column flex-lg-row">

            {{-- places link --}}
            <a class="nav_link
            p-3 p-lg-1
            px-4 px-lg-2
            regular @php if(isset($current_section) && 'Places' == $current_section){ echo('active_link'); } @endphp"
                href="{{ route('places') }}">
                @lang('otherworlds.places')
            </a>

            {{-- login button --}}
            @if (Route::has('login') && Auth::user() == null)
            <a class="nav_link
                p-3 p-lg-1
                px-4 px-lg-2
                regular"
                href="{{ route('login') }}">
                <i class="ri-user-3-fill"></i>
                <span class="mx-1">
                    @lang('otherworlds.sign_in')
                </span>
            </a>
            @endif

            {{-- user options --}}
            @if (Auth::user())
            <form id="logout_form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown_toggler gap-2
                p-3 p-lg-1
                px-4 px-lg-3
                regular">
                    {{ Auth::user()->name }}
                    <i class="fa-solid fa-angle-down"></i>
                </a>

                <div class="dropdown_options">
                    <a href="javascript:void(0)" class="p-2 px-4">
                        @lang('otherworlds.profile')[NYI]
                    </a>

                    <a href="javascript:void(0)" class="p-2 px-4">
                        @lang('otherworlds.favorites')[NYI]
                    </a>

                    <div class="dropdown_divider mt-1 mx-5 mx-md-2"></div>

                    <a href="{{ route('logout') }}" class="p-2 px-4"
                        onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                        @lang('otherworlds.logout')
                    </a>
                </div>
            </div>
            @endif

            {{-- lang dropdown --}}
            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown_toggler gap-2
                p-3 p-lg-1
                px-4 px-lg-3
                regular">
                    @lang('otherworlds.lang')
                    <i class="fa-solid fa-angle-down"></i>
                </a>

                <div class="dropdown_options">
                @foreach (config('translatable.locales') as $locale)
                    @if ($locale != app()->getLocale())
                        <a class="p-2 px-4" href="{{route('setLocale', ['locale' => $locale])}}">{{strtoupper($locale)}}</a>
                    @endif
                @endforeach
                </div>
            </div>

        </nav>
    </div>
</header>
<script>
    const responsive_nav_toggler = document.getElementById('responsive_nav_toggler');
    const responsive_nav = document.getElementById('responsive_nav');

    responsive_nav_toggler.addEventListener('click', function() {

        responsive_nav.classList.toggle('d-flex');
        responsive_nav.classList.toggle('d-none');
    });
</script>
<style>
    /* dropdown styles */
    .dropdown_toggler {
        width: 100%;
        position: relative;
        cursor: pointer;

        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        align-items: center;
    }

    .dropdown_options {
        overflow: hidden;
        visibility: hidden;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: stretch;

        position: absolute;
        top: 100%;
        left: 0;
        width: auto;

        background-color: var(--black);
        border-radius: 0.5rem;
        transition: all 0.5s;
    }

    .dropdown_options a {
        display: block;
        color: var(--white);
        z-index: 1000;
    }

    .dropdown_options a:hover {
        background-color: rgba(80, 80, 80, 0.45) !important;
    }

    .dropdown_divider {
        height: 1px;
        border-top: 0.1rem solid white;
    }

    @media screen and (max-width: 992px) {
        .dropdown_options {
            display: block;
            position: relative;
            background-color: unset;
        }
    }
</style>
<style>
    /* header - nav styles */
    #responsive_nav {
        border: none;
        color: white;
        overflow: visible;
    }

    #responsive_nav a {
        position: relative;
        font-size: 1.3rem;
        letter-spacing: 0.03rem;
        transition: all 0.5s;
    }

    #responsive_nav_toggler {
        background: none;
        border: none;
        color: white;
        transform: scale(1.25);
    }
    .nav_link::before {
        position: absolute;
        content: '';
        top: 0;
        left: 50%;
        width: 0;
        height: 100%;
        transition: all 0.5s;

        border-bottom: 0.2rem solid var(--main);
        z-index: 1000;
        pointer-events: none
    }

    .active_link {
        position: relative;
        padding-bottom: 0.2rem;
    }

    .active_link::after {
        position: absolute;
        content: '';
        inset: 0;
        width: 100%;
        height: 100%;
        border-bottom: 0.2rem solid var(--main);
    }

    /* mobile breakpoint */
    @media screen and (max-width: 992px) {
        header {
            position: relative;
            background: rgb(29, 29, 29) !important;
        }

        header a {
            font-size: 1.75rem !important;
            letter-spacing: 0.1rem !important;
            padding-right: 10% !important;
            text-align: right;
        }

        header a:hover{
            background-color: rgba(80, 80, 80, 0.45);
        }

        #responsive_nav {
            position: absolute;
            left: 0;
            top: 100%;
            right: 0;
            background: linear-gradient(180deg, rgb(29, 29, 29) 50%, rgba(29, 29, 29, 0.71) 95%, rgba(0, 0, 0, 0) 100%);
        }

        .active_link::after {
            position: absolute;
            content: '';
            inset: 0;
            width: 100%;
            height: 100%;
            border-bottom: none;
            border-right: 0.3rem solid var(--main);
        }
    }

    /* desktop */
    @media screen and (min-width: 993px) {
        .nav_link:hover::before {
            left: 0;
            width: 100%;
        }
    }
</style>
