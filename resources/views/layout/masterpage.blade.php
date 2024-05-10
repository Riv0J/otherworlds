<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
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

        {{-- normalize CSS --}}
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}"/>

        {{-- flags CSS --}}
        <link rel="stylesheet" href="{{ asset('css/flag-icon.css') }}"/>

        {{-- bootstrap CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        {{-- bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        {{-- remixicon CDN --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css" integrity="sha512-i5VzKip7owqOGjb0YTF8MR2J9yBVO3FLHeazKzLp354XYTmKcqEU3UeFYUw82R8tV6JqxeATOfstCfpfPhbyEA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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


        {{-- custom CSS --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

    </head>
    <body class="d-flex flex-row">

        {{-- admin header --}}
        @php $logged_user = Auth::user(); @endphp
        @if($logged_user && ($logged_user->is_admin() || $logged_user->is_owner() ))
            @include('layout.admin_aside')
        @endif

        <div class="flex-grow-1" style="width: fit-content">
            @include('layout.header')
            <main class="flex_center flex-column justify-content-start">
                @yield('content')
            </main>
            @include('layout.footer')
        </div>

        <div id="popups" class="d-flex align-items-end justify-content-end m-3 mb-5 m-sm-5">
            <ul class="">
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
        <style>
            #popups{
                position: fixed;
                inset: 0;
                z-index: 1035;
                pointer-events: none;
            }
            #popups ul{
                list-style-type: none;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: flex-end;
                gap: 0.5rem;
            }
            #popups .alert{
                padding-inline: 1.5rem;
                padding-block: 0.75rem;
                display: inline-flex;
                gap: 0.5rem;
                color: black;
                pointer-events: all;
                animation: fade 10s;
                opacity: 0;
                margin: 0 0

            }
            #popups .alert>*{
                pointer-events: none
            }
            .alert i{
                align-self: flex-start;
            }
            .alert .fa-xmark{
                visibility: hidden;
            }
            .alert:hover .fa-xmark{
                visibility: visible
            }
            @keyframes fade {
                0% {
                    opacity: 1;
                }
                90% {
                    opacity: 0.9;
                }
                100% {
                    opacity: 0;
                }
            }


        </style>
        <script>
            document.querySelectorAll('.alert').forEach(element => {
                element.addEventListener('click', function(){
                    event.target.style.display = 'none';
                });
            });
        </script>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/dropdowns.js') }}"></script>

    @yield('script')
</html>
