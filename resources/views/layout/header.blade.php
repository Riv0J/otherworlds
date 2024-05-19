@php $logged_user = Auth::user(); @endphp
{{-- Responsive navbar --}}
<header class="bg_gradient_black">
    <div class="py-1 py-lg-2 px-3 px-lg-5 white">
        {{-- home anchor --}}
        <a class="brand_anchor white gap-2" href="{{ route('home',['locale' => $locale]) }}">
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

            {{-- development link --}}
            <a class="nav_link regular
                @php if(isset($slug_key) && $slug_key == 'dev_slug'){ echo('active_link'); } @endphp"
                href="{{ route('development',['locale' => $locale]) }}">
                [Development]
            </a>

            {{-- places link --}}
            <a class="nav_link regular
                @php if(isset($slug_key) && $slug_key == 'places_slug'){ echo('active_link'); } @endphp"
                href="{{places_url($locale)}}">
                @lang('otherworlds.places')
            </a>

            {{-- login button --}}
            @if (Route::has('login') && $logged_user == null)
            <a class="nav_link regular
                @php if(isset($slug_key) && $slug_key == 'login_slug'){ echo('active_link'); } @endphp"
                href="{{ get_url($locale, 'login_slug')}}">
                <i class="ri-user-3-fill"></i>
                <span class="mx-1">
                    @lang('otherworlds.sign_in')
                </span>
            </a>
            @endif

            {{-- user options --}}
            @if ($logged_user != null)
            <form id="logout_form" action="{{ route('logout', ['locale' => $locale]) }}" method="POST" class="d-none">
                @csrf
            </form>

            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown_toggler gap-2 regular">
                    {{ $logged_user->name }}
                    <i class="fa-solid fa-angle-down"></i>
                </a>

                <div class="dropdown_options">
                    <a href="{{ get_url($locale,'profile_slug').'/'.$logged_user->name }}">
                        @lang('otherworlds.profile')
                    </a>

                    <div class="dropdown_divider mt-1 mx-5 mx-md-2"></div>

                    <a href="javascript:void(0)" onclick="document.getElementById('logout_form').submit();">
                        @lang('otherworlds.logout')
                    </a>
                </div>
            </div>
            @endif

            {{-- lang dropdown START--}}
            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown_toggler gap-2 regular">
                    @lang('otherworlds.lang')
                    <i class="fa-solid fa-angle-down"></i>
                </a>

                <div class="dropdown_options">
                @foreach (config('translatable.locales') as $loc)
                    @if ($loc != $locale)
                        <a href="{{route('setLocale', ['locale' => $locale, 'new_locale' => $loc, 'slug_key' => $slug_key ?? 'home_slug'])}}">{{strtoupper($loc)}}</a>
                    @endif
                @endforeach
                </div>
            </div>
            {{-- lang dropdown END--}}
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
    header{
        position: sticky;
        top: 0;
        z-index: 1030;
    }
    header>div{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
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

        min-width:100%;
        width: auto;

        background-color: var(--black);
        border-radius: 0.5rem;
        transition: all 0.5s;
    }

    .dropdown_options a {
        padding: 0.5rem;
        padding-inline: 1rem;
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
        transition: all 0.5s;
        padding-bottom: 0.5rem;
        font-family: 'Quicksand'
    }

    #responsive_nav_toggler {
        background: none;
        border: none;
        color: white;
        transform: scale(1.25);
    }
    .nav_link{
        padding-inline: 0.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
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
            text-align: right;
        }

        header nav a:hover{
            background-color: rgba(80, 80, 80, 0.75);
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
        .nav_link{
            justify-content: flex-end;
            padding: 1.25rem;
            padding-bottom: 1.25rem !important;
        }
        #responsive_nav a{
            padding: 1.25rem;
            padding-bottom: 1.25rem !important;
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
