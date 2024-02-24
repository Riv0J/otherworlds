@extends('layout.masterpage')

@section('title')
Otherworlds
@endsection

@section('content')
{{-- window welcome --}}
<section class="window col-12 home_window flex_center white">
    <div class="translucent py-2 px-4 rounded-3 overflow-hidden">
        <h2 class="text-center semibold display-6" id="home_window_title"></h2>
    </div>
</section>

<style>
    .home_window{
        background-image: url('{{asset('img/antelope.jpg')}}');
        background-size: cover;
        background-repeat: no-repeat;
        transition: all 0.25s;
    }
</style>

<script>
    const home_window_title = document.getElementById('home_window_title');
    const phrases = {!! json_encode($phrases) !!};
    console.log(phrases);
    const random_phrase = phrases[Math.floor(Math.random() * phrases.length)];
    escribirCodigo(random_phrase, home_window_title);

    async function escribirCodigo(texto, elementoHTML) {
        let indice = 0;
        let velocidadMinima = 45; // Tiempo mínimo entre cada letra (en milisegundos)
        let velocidadMaxima = 100; // Tiempo máximo entre cada letra (en milisegundos)
        let last_char;

        // Verificar si el texto es un título (menos de 15 caracteres)
        if (texto.length < 15) {
            velocidadMaxima = velocidadMaxima / 2; // Reducir la velocidad máxima a la mitad
        }

        async function escribirCaracter() {
                if (indice < texto.length) {
                    let tiempoAleatorio = Math.random() * (velocidadMaxima - velocidadMinima) + velocidadMinima;

                    switch (last_char) {
                        //wipe current text
                        case '|':
                            elementoHTML.innerHTML = '';
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

                        if(last_char != '*' ){
                            elementoHTML.innerHTML += last_char;
                        }

                        indice++;
                        escribirCaracter();
                    }, tiempoAleatorio);
                }
            }

        escribirCaracter();
    }
</script>

<section class="bg_light px-md-5 py-5">

    <h1 class="semibold text-center display-5 flex_center gap-2 col-12 py-4">
        @include('icons.moon_black')
        therworlds
    </h1>

    <!-- Page Features-->
    <div class="row gap-2 gap-xl-5 flex-lg-nowrap flex-wrap justify-content-center align-items-stretch">

        <div class="rounded-3 col-12 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/antelope.jpg')}}');
            background-size: cover;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100">
                <h3 class="regular d-flex align-items-center gap-2 ">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.explore')
                </h3>
                <p class="light">@lang('otherworlds.explore_body')</p>
            </div>
        </div>

        <div class="rounded-3 col-12 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/antelope.jpg')}}');
            background-size: cover;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100">
                <h3 class="regular d-flex align-items-center gap-2 ">
                    <i class="ri-compass-3-line"></i>
                    @lang('otherworlds.discover')
                </h3>
                <p class="light">@lang('otherworlds.discover_body')</p>
            </div>
        </div>

        <div class="rounded-3 col-12 col-lg-4 align-items-end white justify-content-start text-left px-3 pt-5"
        style="
            background-image: url('{{asset('img/antelope.jpg')}}');
            background-size: cover;
        ">
            <div class="d-flex flex-column align-items-start justify-content-end text-left h-100">
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
