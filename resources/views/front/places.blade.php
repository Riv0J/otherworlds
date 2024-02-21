@extends('layout.masterpage')

@section('title')
@lang('otherworlds.places') | Otherworlds
@endsection

@section('content')
<section class="bg_light px-lg-5 pb-2">
    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2">
        @lang('otherworlds.unique_places')
    </h2>
</section>

<div class="divider col-9 col-md-6 col-lg-4 my-md-3"></div>

<section class="bg_light px-lg-2 py-3">

    <div class="row gap-1 gap-sm-2 gap-md-3 justify-content-center align-items-stretch">

        @foreach ($all_places as $place)

        <a href="{{route('view_place', ['place_name' => $place->name])}}" class="places_card rounded-3 col-12 col-sm-5 col-md-5 col-lg-3 col-xl-2 align-items-end white justify-content-start text-left">
            <div class="image_background" image_path="{{asset('img/places/'.$place->id.'/t.png')}}"></div>

            <div class="places_card_info d-flex flex-column align-items-start justify-content-end text-left h-100 p-5 p-sm-2">
                <h3 class=" regular mb-2">
                    {{$place->name}}
                </h3>
                <p class="flex_center gap-2" ><i class="ri-map-pin-line"></i>
                    {{$place->country->name}}
                </p>
                <p class="light" style="
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;

                ">
                    {{$place->synopsis}}
                </p>
            </div>

        </a>

        @endforeach
    </div>
</section>

@endsection

@section('script')
<script>
function set_header_offset(){
    let header_element = document.getElementsByTagName('header')[0];
    const offset_height = header_element.offsetHeight * 0.8;

    //apply offset to main element
    document.querySelector('main').style.marginTop = `${offset_height}px`;
    console.log(offset_height);
}

function apply_bg_images() {
    const places_images = document.querySelectorAll('div[image_path]');

    for (let i = 0; i < places_images.length; i++) {
        const element = places_images[i];
        element.style.backgroundImage = 'url('+element.getAttribute('image_path')+')';
        console.log(element);
    }
}

document.addEventListener('DOMContentLoaded', apply_bg_images);
document.addEventListener('DOMContentLoaded', set_header_offset);
</script>
<style>
    .places_card{
        position: relative;
        aspect-ratio: 0.75;
        overflow: hidden;
        color: white;
    }

    .places_card::before{
        position: absolute;
        content: '';
        inset: 0;
        background: rgb(29, 29, 29);
        background: linear-gradient(0deg, rgb(29, 29, 29) 25%, rgba(0,212,255,0) 45%);
        color: white;
        z-index: 1000;
    }
    .places_card_info{
        position: relative;
        z-index: 1000;
    }
    .places_card p{
        overflow: hidden;
    }
    .places_card::after{
        transition: all
    }
    .places_card:hover>.image_background{
        scale: 1.1;
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
