<footer class="bg_gradient_black mt-5">

    {{-- container --}}
    <div class="container p-4 flex_center align-md-start flex-column flex-lg-row">

        {{-- brand --}}
        <a class="brand_anchor white gap-2 p-3" href="{{ route('home') }}">
            @include('icons.moon_white')
            <span>therworlds</span>
        </a>
        <div class="divider_light col-9 col-md-6 col-lg-4 my-2 mt-4 d-lg-none"></div>

        {{-- sections --}}
        <nav class="text-center flex_center flex-column flex-lg-row align-items-start justify-content-around mt-lg-4">
            <div class="flex_center flex-column mt-5 m-lg-0">
                <h5>@lang('otherworlds.sections')</h5>

                {{-- places link --}}
                <a class="regular py-3"
                    href="{{ route('places') }}">
                    @lang('otherworlds.places')
                </a>

                <a class="regular py-3"
                    href="{{ route('places') }}">
                    @lang('otherworlds.places')
                </a>
            </a>
            </div>

            <div class="mt-5 m-lg-0">
                <h5>@lang('otherworlds.sources')</h5>

                <a class="regular py-3"
                    href="{{ route('places') }}">
                    @lang('otherworlds.places')
                </a>

            </a>
            </div>

            <div class="mt-5 m-lg-0">
                <h5>@lang('otherworlds.contact')</h5>

                <a class="regular py-3"
                    href="{{ route('places') }}">
                    @lang('otherworlds.places')
                </a>

            </a>
            </div>
        </nav>

    </div>
    <p class="m-3 small text-center white">Copyright &copy; Otherworlds 2024</p>
</footer>

<style>
    footer .brand_anchor {

    }
    footer nav a{
        font-size: 1.75rem !important;
        letter-spacing: 0.1rem !important;
    }
    footer nav{
        list-style-type: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }

    @media screen and (min-width: 993px) {
        .align-md-start {
            align-items: start;
        }
    }

</style>
