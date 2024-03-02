@extends('layout.masterpage')

@section('title')
Otherworlds
@endsection

@section('content')
{{-- window welcome --}}
<section class="window col-12 home_window flex_center white" id="home_window">
    <div class="translucent py-2 px-4 rounded-3 overflow-hidden">
        <h2 class="text-center semibold display-6" id="home_window_title"></h2>
    </div>
    {{-- asset('img/places/'.$place->id.'/t.png') --}}
</section>

<style>
    .home_window{
        background-image: url('{{asset('img/home/antelope.jpg')}}');
        background-size: cover;
        background-repeat: no-repeat;
        transition: all 0.25s;
    }
</style>

<script>
    const home_window_title = document.getElementById('home_window_title');

    const home_window = document.getElementById('home_window');
    home_window.style.backgroundImage = 'url(img/places/{{$place->id}}/t.png)';

    let phrases = {
        'en': [
            'Ever wondered why... *| some places just feel out of this world...?',
            'We have places to be... *| and people to meet.',
            'Discover the unknown beauty... *| in the same planet we call home.'
        ],
        'es': [
            'Alguna vez te has preguntado... *| sobre los lugares que parecen de otro mundo...?',
            'Tenemos lugares en los que estar... *| y personas que conocer.',
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

<section class="col-12 px-md-5 py-5">

    <h1 class="semibold text-center display-5 flex_center gap-2 col-12 py-4">
        @include('icons.moon_black')
        therworlds
    </h1>

    <!-- Page Features-->
    <div class="row gap-2 flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-center align-items-stretch mx-lg-5">

        <div class="rounded-3 col-12 col-md-4 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
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

        <div class="rounded-3 col-12 col-md-4 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/antelope.jpg')}}');
            background-size: cover;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100 p-2">
                <h3 class="regular d-flex align-items-center gap-2 ">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.discover')
                </h3>
                <p class="light">@lang('otherworlds.discover_body')</p>
            </div>
        </div>

        <div class="rounded-3 col-12 col-md-4 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
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

<section class="bg_light text-justify px-3 px-lg-5 py-5 row flex-column flex-md-row">
    <div class="d-flex align-items-center justify-content-center col-12 col-md-3">
        <img src="{{asset('img/antelope.jpg')}}" alt="">
    </div>
    <h3 class="text-left py-5 col-12 col-md-9">
        @lang('otherworlds.quote_1')
    </h3>
</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-5"></div>

<section class="bg_light text-justify px-3 px-lg-5 py-5 row flex-column flex-md-row">
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
