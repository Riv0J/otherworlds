@extends('layout.masterpage')

@section('title')
@lang('otherworlds.title_home')
@endsection

@section('description')
@lang('otherworlds.description_home')
@endsection

@section('canonical')
{{ url($locale.'/home') }}
@endsection

@section('content')
{{-- window welcome --}}
<section class="window col-12 my-3 flex_center flex-column white">

    <div class="app_bg_overlay" id=home_window_container>
        <img class="rounded-4" src="{{asset('places/'.$place->public_slug.'/t.png')}}" alt="">
        <div class="translucent rounded-3 px-4 py-2 overflow-hidden" id="home_window_title_container">
            <h2 class="text-center semibold display-6" id="home_window_title"></h2>
        </div>
    </div>
    <h2 class="sans medium mb-2">
        {{$place->name}}
    </h2>
    <h4 class="light mb-5 flex_center gap-2">
        <span class="flag-icon flag-icon-{{$place->country->code}}"></span>{{$place->country->name}}
    </h4>
    <p>
        <a class="py-1" href="{{places_url($locale).'/'.$place->slug}}">
            @lang('otherworlds.visit_place')
        </a>
    </p>
</section>
<style>
    #home_window_container img {
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
        background: radial-gradient(rgba(255, 255, 255, 0.01) 30%, var(--main_dark_bg_color) 65%);
        outline: 1px solid var(--main_dark_bg_color);
        scale: 1.05 1;
    }

    /* desktop */
    @media screen and (min-width: 993px) {
    }

    /* mobile */
    @media screen and (max-width: 992px) {
    }
</style>

<script>
    const home_window_title = document.getElementById('home_window_title');

    let phrases = {
        'en': [
            'Otherworldy places... *| on earth.',
            'Ever visited places... *| that just look out of this world?',
            'We have places to be... *| and people to meet.',
            'AI generated?... *| Nope, these are actually real.',
            'Discover the unknown beauty... *| in the same planet we call home.',
            'Small humans... *| gigantic universe.'
        ],
        'es': [
            'Lugares de otros mundos... *| en la tierra.',
            'Alguna vez has visitado... *| algún lugar que parezca de otro mundo?',
            'Tenemos lugares en los que estar... *| y personas que conocer.',
            'Generados por IA?... *| No, estos son reales.',
            'Descubre la belleza escondida... *| en el mismo planeta que llamamos hogar.',
            'Humanos pequeños... *| universo gigantesco.'
        ],
        'eu': [
            'Beste munduetako tokiak... *| lurrean.',
            'Inoiz bisitatu al duzu... *| beste mundu batekoa dirudien tokiren bat?',
            'Baditugu egoteko tokiak... *| eta ezagutzeko pertsonak.',
            'IAk sortuak?... *| Ez, hauek benetakoak dira.',
            'Ezagut ezazu ezkutuko edertasuna... *| gure etxea deitzen dugun planeta berean.',
            'Gizaki txikiak... *| unibertso erraldoia.'
        ]
    };
    const lang = `{{app()->getLocale()}}`;
    let lang_phrases = phrases[lang];

    escribirCodigo(pickPhrase(), home_window_title);

    async function escribirCodigo(texto, elementoHTML) {
        elementoHTML.innerHTML = '';
        let indice = 0;
        let velocidadMinima = 40;
        let velocidadMaxima = 95;
        let last_char;

        if (texto.length < 15) {
            velocidadMaxima = velocidadMaxima / 2;
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

<section class="col-12 px-md-5 py-5 flex_center flex-column gap-5 light white">

    <h1 class="semibold text-center flex_center gap-3 col-12 py-4 app_bg">
        <span class="spin_anim">
            @include('icons.moon_white')
        </span>
        therworlds
    </h1>

    <div class="px-4 d-flex flex-column gap-5 col-12 col-lg-8">
        <p>@lang('otherworlds.about_1')</p>
        <p>@lang('otherworlds.about_2')</p>
        <p class="text-center">
            <a class="anchor py-1" href="https://www.un.org/sustainabledevelopment/" target="_blank">
                @lang('otherworlds.about_3')
            </a>
        </p>
    </div>

    <style>
        .spin_anim {
            display: flex;
            animation: spin 40s linear alternate;
            scale: 1.25;
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

<div class="div col-9 col-md-6 col-lg-4 my-md-5 mb-5"></div>

<section class="col-12 col-xl-10 white">
    <h2 class="text-center my-5">
        @lang('otherworlds.features')
    </h2>
    <div id="features_grid" class="gap-3 mx-3 mx-md-5">

        <div class="features_card">
            <div class="img_container" style="
            background-image: url('{{asset('img/home/antelope.jpg')}}');
            ">

            </div>
            <div class="body_container p-3">
                <h3 class="regular d-flex align-items-center gap-2">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.explore')
                </h3>
                <p class="light">@lang('otherworlds.explore_body')</p>
            </div>
        </div>

        <div class="features_card">
            <div class="img_container" style="
            background-image: url('{{asset('img/home/socotra.png')}}');
            ">

            </div>
            <div class="body_container p-3">
                <h3 class="regular d-flex align-items-center gap-2">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.discover')
                </h3>
                <p class="light">@lang('otherworlds.discover_body')</p>
            </div>
        </div>

        <div class="features_card">
            <div class="img_container" style="
            background-image: url('{{asset('img/home/uyuni.png')}}');
            ">

            </div>
            <div class="body_container p-3">
                <h3 class="regular d-flex align-items-center gap-2">
                    <i class="ri-profile-line"></i>
                    @lang('otherworlds.request')
                </h3>
                <p class="light">@lang('otherworlds.request_body')</p>
            </div>
        </div>

    </div>

    <style>
        #features_grid{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))
        }
        .features_card{
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
        }
        .img_container{
            width: 100%;
            aspect-ratio: 1.5;
            background-size: cover;
            background-position: center;
        }
        .img_container::before{
            content: '';
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(5deg, rgb(29, 29, 29) 20%, rgba(0,212,255,0) 40%);
        }
        .body_container{
            width: 100%;
            z-index: 1000;
            position: absolute;
            bottom: 0;
        }

        /* desktop */
        @media screen and (min-width: 993px) {
        }

        /* mobile */
        @media screen and (max-width: 992px) {
            #features_grid{
                display: grid;
                grid-template-columns: repeat(1, 1fr); /* Máximo de 1 elementos por fila */
            }
            .img_container{
                aspect-ratio: 3;
            }
        }
    </style>

    <div class="mx-5 px-4 my-5 d-flex flex-column gap-5">
        <p class="light white">@lang('otherworlds.features_1')</p>
    </div>

</section>

<section class="col-12 px-md-5 py-5 flex_center flex-column gap-5 mt-5">
    <h2 class="semibold text-center flex_center gap-3 col-12 py-4 white app_bg">
        @lang('otherworlds.hype_up')
    </h2>
</section>

<section class="quote_section col-xl-8 px-3 px-lg-5 flex-md-row">
    <div class="d-flex align-items-center justify-content-center col-12 col-md-3">
        <img src="{{asset('img/home/spring.png')}}" alt="">
    </div>
    <h3 class="text-left py-5 col-12 col-md-9 light">
        @lang('otherworlds.quote_1')
    </h3>
</section>

<div class="div col-9 col-md-6 col-lg-4 my-md-5"></div>

<section class="quote_section col-xl-8 px-3 px-lg-5 flex-md-row">
    <h3 class="text-left py-5 col-12 col-md-9 light">
        @lang('otherworlds.quote_2')
    </h3>
    <div class="d-flex align-items-center justify-content-center col-12 col-md-3">
        <img src="{{asset('img/home/death_valley.png')}}" alt="">
    </div>

</section>

<div class="div col-9 col-md-6 col-lg-4 my-md-5"></div>

<p class="text-center py-5 px-3 px-md-5 col-md-10 col-xl-8 white">
    @lang('otherworlds.quote_3')
</p>
<style>
    .quote_section{
        display: flex;
        flex-direction: column;
        gap: 1rem;
        color: var(--white);
        padding-block: 3rem;
    }
</style>
@endsection
