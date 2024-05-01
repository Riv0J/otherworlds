@extends('layout.masterpage')

@section('title')
{{$place->name}} | Otherworlds
@endsection

@section('description')
@lang('otherworlds.learn_more_about') {{$place->name}}. @lang('otherworlds.category'): {{$place->category->keyword}}({{$place->category->name}}).{{$place->synopsis}}
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')
<section class="bg_black shadows_inline white col-12 col-lg-8 px-2 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center">
    <div class="spacer mt-4 pt-5"></div>

    {{-- title --}}
    <div class="d-flex justify-content-between app_border_bottom px-0 pb-2 flex-column flex-sm-row">
        <div class="flex_center gap-4">
            <span class="big_i flag-icon flag-icon-{{$place->country->code}}" title="{{$place->country->name}}"></span>
            <h3 id="pl_name" class="regular">{{$place->name}}</h3>
        </div>
        <div class="d-flex flex-row justify-content-end">
            {{-- #fav_button START--}}
            @if(Auth::check() === false || $place->is_favorite(Auth::user()) === false)
                <button title='@lang('otherworlds.fav_button')' id="fav_button" class="button">
                    <i class="fa-regular fa-star"></i>
                    <h5 class="short_number">{{$place->favorites_count}}</h5>
                </button>
            @else
                <button title='@lang('otherworlds.fav_button')' id="fav_button" class="button">
                    <i class="fa-solid fa-star"></i>
                    <h5 class="short_number">{{$place->favorites_count}}</h5>
                </button>
            @endif
            {{-- #fav_button END--}}

            <div class="div_v div_gray m-2"></div>

            {{-- #share_button START--}}
            <button title='@lang('otherworlds.share_button')' id="share_button" class="button">
                <input type="text" value="{{ route('place_view', ['locale' => $locale, 'section_slug' => trans('otherworlds.place_index_slug'), 'place_slug' => $place->slug]) }}" id="place_url" style="left: -200%; position:absolute">
                <i class="ri-share-line"></i>
            </button>
            {{-- #share_button END--}}

        </div>
    </div>

    {{-- content body START --}}
    <div class="my-4">

        {{-- img container START--}}
        <div class="border_gray bg_gray col-md-6 p-2 pb-4 mb-3" style="margin-right: 1.3em; float:left">
            <div class="img_gradient_bottom img_gradient_top">
                <img src="{{asset('places/'.$place->public_slug.'/t.png')}}" alt="@lang('otherworlds.thumbnail'): {{$place->name}}">
            </div>
            <p class="text-center m-2">{{$place->synopsis}}.</p>

            <div class="div_h div_gray m-3"></div>

            {{-- place stats START --}}
            <div class="d-flex gap-3">
                <div class="col-4 d-flex flex-column align-items-end gap-1 text-end">
                    <small>@lang('otherworlds.country'):</small>
                    <small>@lang('otherworlds.category'):</small>
                    <small>@lang('otherworlds.views'):</small>
                    <small>@lang('otherworlds.date_added'):</small>
                    <small>@lang('otherworlds.source'):</small>
                    <small>@lang('otherworlds.location'):</small>
                </div>
                <div class="col-8 d-flex flex-column align-items-start gap-1">
                    <small class="flex_center gap-2">
                        <span class="flag-icon flag-icon-{{$place->country->code}}"></span>{{$place->country->name}}
                    </small>
                    <small class="flex_center gap-2"><i class="small_i fa-solid fa-{{$place->category->img_name}}"></i>
                        {{$place->category->name}}
                    </small>
                    <small class="short_number">{{$place->views_count}}</small>
                    <small>{{$place->created_at->format('d-m-Y')}}</small>
                    <small>
                        @if($source != null)
                        <a  href="{{$source->url}}" target="_blank">
                            {{$source->title ?? $place->name}} <i class="ri-external-link-line"></i>
                        </a>
                        @else
                        -
                        @endif
                    </small>
                    <small>
                        <a href="https://www.google.com/maps?q={{$place->name}}&t=k" target="_blank">
                            <span>@lang('otherworlds.view_in_maps')</span>
                            <i class="ri-external-link-line"></i>
                        </a>
                    </small>
                </div>
            </div>
            {{-- place stats END--}}

        </div>
        {{-- img container END--}}

        <h4 class="mb-4 semibold">
            <i class="ri-arrow-right-s-line"></i>
            <span class="mx-1">@lang('otherworlds.place_overview')</span>
        </h4>

        <div class="mx-3 mx-md-2 light" id="overview">
        @if($source != null)
            {!! $source->content !!}
            <a href="{{$source->url}}" target="_blank">
                <span>@lang('otherworlds.learn_more', ['place_name' => $place->name])</span>
                <i class="ri-external-link-line"></i>
            </a>
        @else
            @lang('otherworlds.no_source').
        @endif
        </div>
    </div>
    {{-- content body END --}}

    <div class="spacer m-3" style="clear: both;"></div>

    {{-- location START --}}
    <div class="mb-5 mt-2 mt-md-5">
        <h4 class="semibold">
            <i class="ri-arrow-right-s-line"></i>
            <span class="mx-1">@lang('otherworlds.place_location')</span>
        </h4>
        <p class="m-4 mx-md-2">
            @lang('otherworlds.view_place_maps_description',['link' => "<a href='https://www.google.com/maps?q=".$place->name."&t=k' target='_blank'>".$place->name." Maps <i class='ri-external-link-line'></i></a>" ])
        </p>

        <div style="height: 300px; position: relative">
            <div id="place_location" class="h-100 w-100"></div>

            @if($place->latitude == 0 && $place->longitude == 0)
            <div class="flex_center flex-column no_location">
                <h3 class="mb-4 text-center">@lang('otherworlds.no_location').</h3>
                <a href="https://www.google.com/maps?q={{$place->name.' '.$place->country->name}}&t=k" target="_blank">
                    <span>@lang('otherworlds.view_in_maps')</span>
                    <i class="ri-external-link-line"></i>
                </a>
            </div>
            <style>
                .no_location{
                    position:absolute;
                    inset: 0;
                    background-color: var(--black_opacity);
                    z-index: 10000;
                }
            </style>
            @endif
            <script>
                var map;
                async function initMap() {
                    map = new google.maps.Map(document.getElementById('place_location'), {
                        center: {lat: {{$place->latitude}}, lng: {{$place->longitude}}},
                        zoom: 10
                    });
                }
            </script>
            <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKiPM_x2vbTQNx8tAc1vh-bRIPwfl3KYk&callback=initMap" async defer></script>
        </div>
    </div>
    {{-- location END --}}

    {{-- return START--}}
    <button title="@lang('otherworlds.return')" id="return" class="d-none d-lg-flex button info border" onclick="window.history.back()">
        <i class="fa-solid fa-angles-left"></i>
    </button>
    <style>
        #return{
            position: fixed;
            top: 50%;
            left: 5svh
        }
    </style>
    {{-- return END --}}

    <div class="div_h my-5"></div>

    {{-- gallery START --}}
    <div class="my-3">
        <h3 class="text-center">@lang('otherworlds.gallery')</h3>
        <p class="m-4 mx-md-2">
            @if($place->gallery_url != null)
                @lang('otherworlds.view_place_gallery',['link' => "<a href='$place->gallery_url' target='_blank'>".$place->name." Wikimedia <i class='ri-external-link-line'></i></a>" ])
            @else
                @lang('otherworlds.no_gallery').
            @endif
        </p>
        <div id="medias_container"></div>
    </div>
    <div class="flex_center">
        <button id="load_more" class="bold button info border my-3">
            <i class="fa-solid fa-chevron-down"></i>
        </button>
    </div>

    {{-- gallery END --}}

    <div class="div_h my-5"></div>

</section>

<div id="inspect_modal" class="flex_center">
    <button id="next" class="button border"><i class="fa-solid fa-chevron-right"></i></button>
    <button id="last" class="button border"><i class="fa-solid fa-chevron-left"></i></button>

    <div id="inspect_box" class="bg_black p-3 border">
        <div class="flex_center position-relative">
            <button id="modal_closer" class="button red"><i class="fa-solid fa-xmark"></i></button>
            <img>
        </div>

        <div class="mt-3">
            <p></p>
            <a class="mx-2" href="" target="_blank">
                <span>@lang('otherworlds.view_original')</span>
                <i class="ri-external-link-line"></i>
            </a>
        </div>

    </div>
</div>
<style>
    .button.info:hover{
        color: #00f3ff;
    }
    #next,#last{
        z-index: 1032;
    }
    #next{
        top: 50%;
        right: 5svh;
    }
    #last{
        top: 50%;
        left: 5svh;
    }
    #modal_closer{
        right: 0.5rem;
        top: 0.5rem;
    }
    #inspect_modal{
        position: fixed;
        inset: 0;
        background-color: var(--black_opacity);
        z-index: -1;

        transition: all 0.5s;
        opacity: 0;
    }
    #inspect_modal button{
        position: absolute;
    }
    #inspect_box{
        color: var(--white);
        max-width: 80%;

        transition: all 0.5s;
        scale: 0;
    }

    #inspect_box img {
        width: auto;
        max-width: 100%;
        max-height: 65svh;
    }
    #medias_container{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-auto-rows: minmax(100px, auto);
        grid-auto-flow: dense;
        gap: 10px;
    }
    .mediabox{
        position: relative;
        overflow: hidden;
        cursor: pointer;
        grid-column: span 1;
        grid-row: span 2;
    }
    .mediabox:hover>.bg{
        scale: 1.15;
    }
    .bg{
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: all 1s;
    }
    .mediabox:nth-child(7n + 1) { /*first and seventh */
        grid-column: span 2;
        grid-row: span 3
    }
    .mediabox:nth-child(11n + 5) { /*fifth and eleventh */
        grid-column: span 1;
        grid-row: span 3
    }
    @media screen and (min-width: 779px) {}
    @media screen and (max-width: 778px) {
        #medias_container{
            grid-template-columns: repeat(2, 1fr);
        }
        #inspect_box{
            max-width: 95%;
        }
        #next,#last{
            top: 90%;
            scale: 2
        }
    }
    b{ font-weight: 600; }
    #overview>*{
        font-size: 1.1rem;
    }
    #overview>p{
        text-align: justify;
        margin-bottom: 2rem;
    }
    p{
        font-size: 1.1rem;
    }
    .red:hover{
        background-color: var(--black);
        color: red;
    }
    #fav_button:hover{
        color: var(--yellow_bright);
    }
    #share_button{
        width: 35px;
    }
    #share_button:hover{
        color: var(--green_light);
    }
    #share_button>i{
        scale: 1.2;
    }
    .img_gradient_top{
        position: relative;
    }
    .img_gradient_top::before,.img_gradient_bottom::after{
        content: '';
        position: absolute;
        width: 100%;
        height: 12%;
        left: 0;
    }
    .img_gradient_top::before{
        top: 0;
        background: linear-gradient(180deg, rgb(46, 43, 52) 10%, rgba(46, 43, 52,0.5) 50%,  rgba(46, 43, 52,0) 70%);
    }
    .img_gradient_bottom::after{
        bottom: 0;
        background: linear-gradient(0deg, rgb(46, 43, 52) 10%, rgba(46, 43, 52,0.5) 50%,  rgba(46, 43, 52,0) 70%);
        z-index: 1000;
    }
    #pl_name{
        scale: 1 1.05;
        letter-spacing: 0.1rem;
    }
    .shadows_inline{
        box-shadow: 10px 0 10px rgba(0, 0, 0, 0.5), -10px 0 10px rgba(0, 0, 0, 0.5);
    }
    .img_icon{
        width: 2.5rem;
        aspect-ratio: 1;
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
        scale: 1.01 1;
    }
    .img_overlay{
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding: 1rem
    }
    .img_overlay>nav{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-end;
        width: 100%
    }
</style>
@endsection

@section('script')
{{-- number format script --}}
<script>
    document.querySelectorAll('.short_number').forEach(element => {
        element.textContent = formatNumber(element.textContent);
    });

    function formatNumber(number) {
        if (number < 1000) {
            return number.toString();
        } else {
            const formattedNumber = Math.abs(number) >= 1.0e+9 ? (Math.abs(number) / 1.0e+9).toFixed(1) + 'B' : (Math.abs(number) >= 1.0e+6 ? (Math.abs(number) / 1.0e+6).toFixed(1) + 'M' : (Math.abs(number) >= 1.0e+3 ? (Math.abs(number) / 1.0e+3).toFixed(1) + 'k' : Math.abs(number)));
            return formattedNumber;
        }
    }
</script>

{{-- favorite script --}}
<script src='{{asset('js/ajax.js')}}'></script>
<script>
    @if(Auth::check() === true)

    //on click #fav_button
    document.getElementById('fav_button').addEventListener('click', function(){
        ajax({
            method: 'POST',
            url: '{{ URL('/ajax/places/favorite') }}',
            request_data : {
                _token: '{{ csrf_token() }}',
                place_id: {{$place->id}}
            },
            success_func: flip_star
        });
    });

    function flip_star(response_data){
        const fav_button =  document.getElementById('fav_button');
        const i = fav_button.querySelector('i');

        if(response_data['is_fav'] === false){
            fav_button.classList.remove('yellow');
            i.className = 'fa-regular fa-star';
        }else{
            fav_button.classList.add('yellow')
            i.className = 'fa-solid fa-star';
        }

        const h5 = fav_button.querySelector('h5');
        h5.textContent = formatNumber(response_data['favorites_count']);
    }

    @else
    document.getElementById('fav_button').addEventListener('click', function(){
        window.location.href = "{{ route('login',['locale' => $locale]) }}";
    });
    @endif


</script>
<script>
    //on click #share_button
    document.getElementById('share_button').addEventListener('click', function(){
        const url_input = document.getElementById('place_url');
        url_input.select();
        document.execCommand("copy");
        alert("@lang('otherworlds.copy_link')");
    });
</script>

{{-- media gallery script --}}
<script>
    const loaded_medias = {!! json_encode($place->medias) !!};
    const organized_medias = [];
    const modal = document.getElementById('inspect_modal');
    const box = document.getElementById('inspect_box');
    let index = 0;

    function generate_medias_divs(medias){
        const medias_container = document.getElementById('medias_container');

        let counter = organized_medias.length;
        medias.forEach(function(media) {
            organized_medias[counter] = media;
            const id = counter; //dont ask
            const mediabox = document.createElement('div');
            mediabox.className = 'mediabox';

            mediabox.innerHTML += `
                <div class="bg" style="background-image: url('${media.url}')"></div>
            `;

            mediabox.addEventListener('click', function(){
                index = id;
                set_media(media);
                open_modal();
            });

            medias_container.appendChild(mediabox);
            counter++;
        });
    }
    //set a media in the inspect box
    function set_media(media){
        box.querySelector('img').src = media.url;
        box.querySelector('p').textContent = media.description;
        box.querySelector('a').href = media.page_url;
    }

    //on load event create media divs
    document.addEventListener('DOMContentLoaded', function(){
        const load_more = document.querySelector('#load_more');
        if(loaded_medias.length > 6){
            generate_medias_divs(loaded_medias.slice(0, 6)); //generate the first 6

            load_more.addEventListener('click',function(){
                generate_medias_divs(loaded_medias.slice(6, loaded_medias.length));
                load_more.style.display = 'none';
            });

        } else {
            generate_medias_divs(loaded_medias);
            load_more.style.display = 'none';
        }
    });

    //onclick when modal is beign shown, close
    document.addEventListener('click', function(){
        if(event.target === modal){ close_modal() }
    })

    //onclick #modal_closer
    modal.querySelector('#modal_closer').addEventListener('click', close_modal);

    //onclicks
    modal.querySelector('#next').addEventListener('click', function(){
        if(index + 1 >= loaded_medias.length){
            index = 0;
        } else {
            index++;
        }
        set_media(loaded_medias[index]);
    });
    modal.querySelector('#last').addEventListener('click', function(){
        if(index - 1 <= 0){
            index = loaded_medias.length-1;
        } else {
            index--;
        }
        set_media(loaded_medias[index]);
    });

    function close_modal() {
        modal.style.opacity = 0;
        modal.style.zIndex = -1;
        box.style.scale = 0;
    }
    function open_modal(){
        modal.style.opacity = 1;
        modal.style.zIndex = 1031;
        box.style.scale = 1;
    }
</script>
@endsection
