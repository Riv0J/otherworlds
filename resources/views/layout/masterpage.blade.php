<!DOCTYPE html>
<html lang="{{ $locale }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- title, description, keywords, canonical href --}}
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@lang('otherworlds.keywords')">
        <link rel="canonical" href="@yield('canonical')">

        {{-- favicon --}}
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon-apple-180.png') }}">

        {{-- manifest --}}
        <link rel="manifest" href="{{ asset('manifest.json') }}">

        {{-- normalize CSS --}}
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}"/>

        {{-- flags CSS --}}
        <link rel="stylesheet" href="{{ asset('css/flag-icon.css') }}"/>

        {{-- bootstrap CSS & JS--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        {{-- font-awesome CDN --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        {{-- Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap" rel="stylesheet">

        {{-- custom CSS --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1"/>
        <link rel="stylesheet" href="{{ asset('css/alerts.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/search.css') }}"/>

    </head>
    <body class="d-flex flex-row">

        {{-- admin header --}}
        @php $logged_user = Auth::user(); @endphp
        @if($logged_user && ($logged_user->is_guest() || $logged_user->is_admin() || $logged_user->is_owner() ))
            @include('layout.admin_nav')
        @endif

        <div class="flex-grow-1" style="isolation: isolate">
            @include('layout.header')
            <main class="flex_center flex-column justify-content-start">
                @yield('content')
            </main>
            @include('layout.footer')
        </div>

        <div id="popups" class="d-flex align-items-end justify-content-end m-3 mb-5 m-sm-5">
            <ul>
                @if (Session::has('message'))
                    @php $message = Session::get('message') @endphp
                    <li class="alert alert-{{$message->type}}">
                        <i class="fa-solid {{$message->icon}}"></i>
                        {{ $message->text }}
                        <i class="fa-solid fa-xmark"></i>
                    </li>
                @endif

                @foreach ($errors->all() as $error)
                    <li class="alert alert-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ $error }}
                        <i class="fa-solid fa-xmark"></i>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="modal_container">
        </div>
    </body>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/dropdowns.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>

    @yield('script')
</html>
