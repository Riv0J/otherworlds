@extends('layout.masterpage')

@section('title')
@lang('otherworlds.places') | Otherworlds
@endsection

@section('content')
<div class="spacer mt-3 pt-5"></div>

<section class="px-lg-5 pb-2 header_offset">
    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2">
        @lang('otherworlds.unique_places')
    </h2>
</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-3"></div>

<section class="col-12 px-1 px-lg-2 py-3">

    <div class="gap-2 gap-md-3 justify-content-center align-items-stretch" id="places_container">

        @foreach ($all_places as $place)
        <a href="{{route('view_place', ['place_name' => $place->name])}}"
            class="places_card d-flex flex-column align-items-between justify-content-between p-0 rounded-3 white text-left">
            <div class="image_background" image_path="{{asset('img/places/'.$place->id.'/t.png')}}"></div>

            <div class="card_stats gap-2 d-flex justify-content-end align-items-center px-3 py-2 w-100">
                <p>{{$place->favorites_count}}</p> <i class="fa-regular fa-star"></i>

            </div>

            <div class="places_card_info d-flex flex-column align-items-start text-left px-3 py-2 pt-5 w-100">
                <h3 class="regular mb-2">
                    {{$place->name}}
                </h3>

                <p class="flex_center gap-2">
                    <i class="ri-map-pin-line"></i>{{$place->country->name}}
                </p>
                <div class="card_sinopsis flex_center row p-0">
                    {{-- <div class="divider col-6 my-1"></div> --}}
                    <p class="light col-12">
                        {{$place->synopsis}}
                    </p>
                </div>

            </div>

        </a>
        @endforeach

    </div>
</section>

@endsection

@section('script')
<script>
function apply_bg_images() {
    const places_images = document.querySelectorAll('div[image_path]');

    for (let i = 0; i < places_images.length; i++) {
        const element = places_images[i];
        element.style.backgroundImage = 'url('+element.getAttribute('image_path')+')';
        console.log(element);
    }
}

document.addEventListener('DOMContentLoaded', apply_bg_images);

</script>
<style>
    #places_container{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))
    }
    .card_stats{
        z-index: 500;
    }
    .card_stats i{
        color: yellow;
        transition: all 1s;
    }
    .card_stats:hover{
        background-color: gray;
    }
    .card_sinopsis{
        height: 0;
    }
    .places_card{
        min-height: 500px;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .places_card_info::before{
        position: absolute;
        content: '';
        inset: 0;
        background: rgb(29, 29, 29);
        background: linear-gradient(0deg, rgb(29, 29, 29) 75%, rgba(255, 255, 255, 0) 100%);
        color: white;
        z-index: -1;
    }
    .places_card_info{
        position: relative;
        z-index: 500;
    }
    .places_card::after{
        transition: all
    }
    .places_card:hover>.image_background{
        scale: 1.1;
    }
    .card_sinopsis{
        overflow: hidden;
        transition: all 1s;
    }
    .places_card:hover .card_sinopsis{
        height: 75px;
    }
    .image_background{
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;

        background-size: cover;
        background-position: center;
        transition: all 0.5s;
    }
</style>
@endsection
