<footer class="bg_gradient_black mt-5">

    {{-- container --}}
    <div class="container p-4 flex_center align-items-lg-start flex-column flex-lg-row gap-3">

        {{-- brand --}}
        <a class="brand_anchor white gap-2 p-3" href="{{ route('home') }}">
            @include('icons.moon_white')
            <span>therworlds</span>
        </a>

        <div class="div_light col-9 col-md-6 col-lg-4 my-2 mt-4 d-lg-none"></div>
        <div class="div_vertical_light col-1 d-none d-lg-inline"></div>

        {{-- sections --}}
        <nav class="text-center flex_center flex-column flex-lg-row align-items-center align-items-lg-start justify-content-around mt-lg-4 gap-5 gap-lg-1">

            <div class="flex_center flex-column gap-2">
                <h5 class="my-2 my-lg-0">@lang('otherworlds.sections')</h5>

                {{-- places link --}}
                <a class="regular p-2"
                    href="{{ route('home') }}">
                    Home
                </a>

                <a class="regular p-2"
                    href="{{ route('places') }}">
                    @lang('otherworlds.places')
                </a>

            </div>

            <div class="flex_center flex-column gap-2">
                <h5 class="my-2 my-lg-0">@lang('otherworlds.resources')</h5>

                <a class="regular p-2"
                    href="https://{{app()->getLocale()}}.wikipedia.org/">
                    Wikipedia
                </a>

                <a class="regular p-2"
                    href="https://commons.wikimedia.org/wiki/Main_Page?uselang={{app()->getLocale()}}">
                    Commons
                </a>


            </div>

            <div class="flex_center flex-column gap-2">
                <h5 class="my-2 mt-lg-0">@lang('otherworlds.development')</h5>

                <div class="d-flex flex-row gap-5 gap-lg-3">
                    <a class="regular p-2 icon_button" title="Laravel"
                        href="https://laravel.com" target="_blank">
                        {{-- <i class="fa-brands fa-laravel"></i> --}}
                        @include('icons.laravel')
                    </a>

                    <a class="p-2 icon_button" title="Bootstrap"
                        href="https://getbootstrap.com/" target="_blank">
                        {{-- <i class="ri-bootstrap-line"></i> --}}
                        @include('icons.bootstrap')
                    </a>

                    <a class="p-2 icon_button" title="Github Repository"
                        href="https://github.com/Riv0J/otherworlds" target="_blank">
                        {{-- <i class="ri-github-line"></i> --}}
                        @include('icons.github')
                    </a>
                </div>

            </div>
        </nav>

    </div>
    <p class="m-3 small text-center white">@lang('otherworlds.special_thanks')</p>
    <p class="m-3 small text-center white">Otherworlds 2024. Developed by Rovani</p>
</footer>

<style>
    .div_vertical_light {
        position: relative;
        width: 10px;
        align-self: stretch;
    }
    .div_vertical_light::before {
        content: '';
        position: absolute;
        height: 100%;
        width: 100%;
        left: 50%;
        top: 0;
        border-radius: 0.1rem;
        border-left: 0.15rem solid var(--alt_dark);
        align-self: stretch;
    }

    /* icon button start */
    .icon_button{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        scale: 1.25;
    }
    .icon_button:hover{
        color: var(--main);
        fill: var(--main);
    }
    .icon_button:hover svg, .icon_button:hover path{
        stroke: var(--main);
    }
    /* icon button end */

    footer{
        box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.5);
    }
    footer nav{
        list-style-type: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }
    footer nav a{
        position: relative;
        font-size: 1.75rem !important;
        letter-spacing: 0.1rem !important;
    }
    footer nav a:not(.icon_button)::after{
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: gray;
        opacity: 0;
        inset: 0;
        transition: all 0.25s;
    }
    footer nav a:not(.icon_button):hover::after{
        opacity: 0.25;
    }


    /* desktop */
    @media screen and (min-width: 993px) {

    }

    /* mobile */
    @media screen and (max-width: 992px){
        .icon_button{
            scale: 1.75;
        }
    }
</style>
