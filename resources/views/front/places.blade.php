@extends('layout.masterpage')

@section('title')
Places | Otherworlds
@endsection

@section('content')
<!-- welcome -->
<section class="window col-12 home_window flex_center white">
    <div class="translucent py-2 px-4 rounded-3 overflow-hidden">
        <h2 class="text-center semibold display-6" id="home_window_title">Ever wondered why... ¡...¡ some places just feel magical...?</h2>
    </div>
</section>
<script>
    const home_window_title = document.getElementById('home_window_title');
    applyTextRevealEffect();
    function applyTextRevealEffect() {
        elementos = document.querySelectorAll('h2');

        elementos.forEach(elemento => {
            const text_reveal = elemento.textContent;
            elemento.textContent = '';
            escribirCodigo(text_reveal,elemento);
        });
    }

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
                        //wait x16, wipe current text
                        case '¡':
                            tiempoAleatorio *= 16;
                            elementoHTML.innerHTML = '';
                            break;
                        //wait x4
                        case '.':
                            tiempoAleatorio *= 4;
                            break;
                        default:
                            break;
                    }

                    setTimeout(() => {
                        last_char = texto.charAt(indice);
                        elementoHTML.innerHTML += last_char;

                        indice++;
                        escribirCaracter();
                    }, tiempoAleatorio);
                }
            }

        await escribirCaracter();
        console.log('finished');
    }
</script>
<div class=" px-lg-5 py-5">
    <h1 class="semibold text-center display-5">Otherworlds</h1>
</div>
<style>
    .home_window{
    background-image: url('{{asset('img/antelope.jpg')}}');
    background-size: cover;
    background-repeat: no-repeat;
    transition: all 0.25s;
}
</style>
<section class="pt-4">
    <div class="container px-lg-5">
        <!-- Page Features-->
        <div class="row gx-lg-5">
            <div class="col-lg-6 col-xxl-4 mb-5">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-collection"></i></div>
                        <h2 class="fs-4 fw-bold">Discover</h2>
                        <p class="mb-0">Places</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xxl-4 mb-5">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-cloud-download"></i></div>
                        <h2 class="fs-4 fw-bold">Explore</h2>
                        <p class="mb-0">Places</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xxl-4 mb-5">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-card-heading"></i></div>
                        <h2 class="fs-4 fw-bold">Request</h2>
                        <p class="mb-0">Places</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
