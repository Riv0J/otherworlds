@extends('layout.masterpage')

@section('title')
Otherworlds
@endsection

@section('content')

<script src="
https://cdn.jsdelivr.net/npm/flag-icon-css@4.1.7/svgo.config.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/flag-icon-css@4.1.7/css/flag-icons.min.css
" rel="stylesheet">

<div class="spacer mt-3 pt-5"></div>
<div class="gradient">

</div>
{{-- window welcome --}}
<section class="window col-12 mt-2 mt-md-5 py-3 py-md-0 d-flex flex-column align-items-center justify-content-center white">
    <h4 class="medium pb-1">
        {{$place->name}}
    </h4>
    <h5 class="light pb-3 flex_center gap-2">
        <span class="flag-icon flag-icon-{{$place->country->code ?? 'us'}}"></span>{{$place->country->name}}
    </h5>
    <div class="app_bg_overlay" id=home_window_container>
        <img class="rounded-4" src="{{asset('img/places/'.$place->id.'/t.png')}}" alt="">
        <div class="translucent rounded-3 px-4 py-2 overflow-hidden" id="home_window_title_container">
            <h2 class="text-center semibold display-6" id="home_window_title"></h2>
        </div>
    </div>
    <a class="mt-4 px-2 py-1" href="{{route('view_place', $place->name)}}">
        @lang('otherworlds.what_is_this_place')
    </a>
</section>
<style>
    #home_window_container img {
        /* max-width: 60svh; */
        max-height: 60svh;
        width: auto;
        height: auto;
    }
    #home_window_title_container{
        position: absolute;
        /* center */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-wrap: nowrap;
    }
    .window{
        position: relative;

    }
    .app_bg_overlay{
        position: relative;
    }
    .app_bg_overlay::before{
        content: '';
        display: block;
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(255, 255, 255, 0.01) 30%, var(--main_dark_bg_color) 70%);
        outline: 1px solid var(--main_dark_bg_color);

    }
    .app_bg{
        background: var(--test2);
        box-shadow: 0 0 25px var(--test2);

        scale: 1.05 1;
    }

    /* desktop */
    @media screen and (min-width: 993px) {

    }

    /* mobile */
    @media screen and (max-width: 992px) {
        .window{

        }
    }
</style>

<script>
    const home_window_title = document.getElementById('home_window_title');

    let phrases = {
        'en': [
            'Otherworldy places... *| on earth.',
            'Ever visited places... *| that just look out of this world?',
            'We have places to be... *| and people to meet.',
            'AI generated?... *| No, these are actually real.',
            'Discover the unknown beauty... *| in the same planet we call home.'
        ],
        'es': [
            'Lugares de otros mundos... *| en la tierra.',
            'Alguna vez has visitado... *| algún lugar que parezca de otro mundo?',
            'Tenemos lugares en los que estar... *| y personas que conocer.',
            'Generados por IA?... *| No, estos son reales.',
            'Descubre la belleza escondida... *| en el mismo planeta que llamamos hogar.'
        ]
    };
    const lang = `{{app()->getLocale()}}`;
    let lang_phrases = phrases[lang];

    escribirCodigo(pickPhrase(), home_window_title);

    async function escribirCodigo(texto, elementoHTML) {
        elementoHTML.innerHTML = '';
        let indice = 0;
        let velocidadMinima = 40; // Tiempo mínimo entre cada letra (en milisegundos)
        let velocidadMaxima = 95; // Tiempo máximo entre cada letra (en milisegundos)
        let last_char;

        // Verificar si el texto es un título (menos de 15 caracteres)
        if (texto.length < 15) {
            velocidadMaxima = velocidadMaxima / 2; // Reducir la velocidad máxima a la mitad
        }

        async function escribirCaracter() {
                if (indice < texto.length) {
                    let tiempoAleatorio = Math.random() * (velocidadMaxima - velocidadMinima) + velocidadMinima;

                    switch (last_char) {
                        //add a break
                        case '|':
                            elementoHTML.innerHTML += '<br>';
                            break;

                        //wait x16
                        case '*':
                            tiempoAleatorio *= 16;
                            break;

                        //wait x4
                        case '.':
                            tiempoAleatorio *= 4;
                            break;
                        default:
                            break;
                    }

                    await setTimeout(() => {
                        last_char = texto.charAt(indice);

                        if(last_char != '*' && last_char != '|'){
                            elementoHTML.innerHTML += last_char;
                        }

                        indice++;
                        escribirCaracter();
                    }, tiempoAleatorio);
                }
            }

        escribirCaracter();
    }
    function pickPhrase(){
        return lang_phrases[Math.floor(Math.random() * lang_phrases.length)];
    }
    function pickBackground(){
        return img_urls[Math.floor(Math.random() * img_urls.length)];
    }
</script>

<section class="col-12 px-md-5 py-5 flex_center flex-column gap-5">

    <h1 class="semibold text-center flex_center gap-3 col-12 py-4 white app_bg">
        <span class="spin_anim">
            @include('icons.moon_white')
        </span>
        therworlds
    </h1>

    <div class="px-4 d-flex flex-column gap-5 col-12 col-lg-8">
        <p class="light white">@lang('otherworlds.about_1')</p>
        <p class="light white">@lang('otherworlds.about_2')</p>
        <p class="light white text-center">
            <a class="anchor px-2 py-1" href="https://www.un.org/sustainabledevelopment/" target="_blank">
                @lang('otherworlds.about_3')
            </a>
        </p>
    </div>


    <style>
        .spin_anim {
            display: flex;
            animation: spin 40s linear alternate;
            scale: 1.15;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>

</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-5"></div>

<section class="white">
    <h2 class="text-center my-5">
        @lang('otherworlds.features')
    </h2>

    <div class="row gap-2 gap-md-4 flex-wrap flex-md-wrap flex-lg-nowrap justify-content-center align-items-stretch mx-lg-5 white">
        <div class="rounded-3 col-12 col-md-8 col-lg-4 text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/antelope.jpg')}}');
            background-size: cover;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100 p-2">
                <h3 class="regular d-flex align-items-center gap-2 ">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.explore')
                </h3>
                <p class="light">@lang('otherworlds.explore_body')</p>
            </div>
        </div>

        <div class="rounded-3 col-12 col-md-8 col-lg-4 text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/socotra.png')}}');
            background-size: cover;
            background-position: center;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100 p-2">
                <h3 class="regular d-flex align-items-center gap-2 ">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.discover')
                </h3>
                <p class="light">@lang('otherworlds.discover_body')</p>
            </div>
        </div>

        <div class="rounded-3 col-12 col-md-8 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/antelope.jpg')}}');
            background-size: cover;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100 p-2">
                <h3 class="regular d-flex align-items-center gap-2 ">
                    <i class="ri-profile-line"></i>
                    @lang('otherworlds.request')
                </h3>
                <p class="light">@lang('otherworlds.request_body')</p>
            </div>
        </div>
    </div>

</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-5"></div>

<section class="bg_light text-justify px-3 px-lg-5 py-5 row flex-column flex-md-row white">
    <div class="d-flex align-items-center justify-content-center col-12 col-md-3">
        <img src="{{asset('img/antelope.jpg')}}" alt="">
    </div>
    <h3 class="text-left py-5 col-12 col-md-9">
        @lang('otherworlds.quote_1')
    </h3>
</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-5"></div>

<section class="bg_light text-justify px-3 px-lg-5 py-5 row flex-column flex-md-row white">
    <h3 class="text-left py-5 col-12 col-md-9">
        @lang('otherworlds.quote_2')
    </h3>
    <div class="d-flex align-items-center justify-content-center col-12 col-md-3">
        <img src="{{asset('img/antelope.jpg')}}" alt="">
    </div>

</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-5"></div>

<p class="text-center py-5 px-3 px-md-5 col-12 col-md-8">
    @lang('otherworlds.quote_3')
</p>

@endsection
