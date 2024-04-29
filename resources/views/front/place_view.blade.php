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
<div id="inspect_modal"></div>
<section class="bg_black shadows_inline white col-12 col-lg-8 px-2 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center">
    <div class="spacer mt-4 pt-5"></div>

    {{-- title --}}
    <div class="d-flex justify-content-between app_border_bottom px-0 pb-2">
        <div class="flex_center gap-4">
            <span class="big-icon flag-icon flag-icon-{{$place->country->code}}" title="{{$place->country->name}}"></span>
            <h3 id="pl_name" class="regular">{{$place->name}}</h3>
        </div>
        <div class="d-flex flex-row" id="interactions">
            {{-- #fav_button START--}}
            @if(Auth::check() === false || $place->is_favorite(Auth::user()) === false)
                <button title='@lang('otherworlds.fav_button')' id="fav_button">
                    <i class="fa-regular fa-star"></i>
                    <h5 class="short_number">{{$place->favorites_count}}</h5>
                </button>
            @else
                <button title='@lang('otherworlds.fav_button')' class="yellow" id="fav_button">
                    <i class="fa-solid fa-star"></i>
                    <h5 class="short_number">{{$place->favorites_count}}</h5>
                </button>
            @endif
            {{-- #fav_button END--}}

            <div class="div_v div_gray m-2"></div>

            {{-- #share_button START--}}
            <button title='@lang('otherworlds.share_button')' class="green" id="share_button">
                <input type="text" value="{{ route('place_view', ['locale' => $locale, 'section_slug' => trans('otherworlds.place_index_slug'), 'place_slug' => $place->slug]) }}" id="place_url" style="left: -200%; position:absolute">
                <i class="ri-share-line"></i>
            </button>
            {{-- #share_button END--}}

        </div>
    </div>

    {{-- content body START --}}
    <div class="my-4">

        {{-- img container START--}}
        <div class="border_gray bg_gray col-12 col-md-6 p-2 pb-4 mb-3" style="margin-right: 1.3em; float:left">
            <div class="img_container img_gradient_bottom img_gradient_top text-center">
                <img src="{{asset('img/places/'.$place->id.'/t.png')}}" alt="@lang('otherworlds.thumbnail'): {{$place->name}}">
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
                    <small class="flex_center gap-2"><span class="flag-icon flag-icon-{{$place->country->code}}"></span>{{$place->country->name}}</small>
                    <small>{{$place->category->keyword}} ({{$place->category->name}})</small>
                    <small class="short_number">{{$place->views_count}}</small>
                    <small>{{$place->created_at->format('d-m-Y')}}</small>
                    <small>
                        @if($source != null)
                        <a class="px-2" href="{{$source->url}}" target="_blank">
                            {{$source->title ?? $place->name}} <i class="ri-external-link-line" style="font-size: 1rem"></i>
                        </a>
                        @else
                        -
                        @endif
                    </small>
                    <small>
                        <a class="px-2" href="https://www.google.com/maps?q={{$place->name}}&t=k" target="_blank">
                            <span style="letter-spacing: 0.05rem">@lang('otherworlds.view_in_maps')</span>
                            <i class="ri-external-link-line" style="font-size: 1rem"></i>
                        </a>
                    </small>
                </div>
            </div>
            {{-- place stats END--}}

        </div>
        {{-- img container END--}}

        <h4 class="mb-4" style="font-weight: 600; letter-spacing:0.025rem">
            <i class="ri-arrow-right-s-line"></i>
            <span class="mx-1">@lang('otherworlds.place_overview')</span>
        </h4>

        <div class="mx-3 mx-md-2 light" id="overview">
        @if($source != null)
            {!! $source->content !!}
            <a class="px-2" href="{{$source->url}}" target="_blank">
                <span>@lang('otherworlds.learn_more', ['place_name' => $place->name])</span>
                <i class="ri-external-link-line" style="font-size: 1rem"></i>
            </a>
        @else
            @lang('otherworlds.no_source')
        @endif
        </div>
    </div>
    {{-- content body END --}}

    <div class="spacer m-3" style="clear: both;"></div>

    {{-- location START --}}
    <div class="mb-5 mt-2 mt-md-5">
        <h4 style="font-weight: 600; letter-spacing:0.025rem">
            <i class="ri-arrow-right-s-line"></i>
            <span class="mx-1">@lang('otherworlds.place_location')</span>
        </h4>
        <p class="m-4 mx-md-2">
            @lang('otherworlds.view_place_maps_description',['link' => "<a class='px-2' href='https://www.google.com/maps?q=".$place->name."&t=k' target='_blank'>".$place->name." Maps <i class='ri-external-link-line' style='font-size: 1rem'></i></a>" ])
        </p>

        <div style="height: 300px; position: relative">
            <div id="place_location" style="height: 100%; width: 100%"></div>

            @if($place->latitude == 0 && $place->longitude == 0)
            <div class="flex_center flex-column no_location">
                <h3 class="mb-4">@lang('otherworlds.no_location')</h3>
                <a class="px-2" href="https://www.google.com/maps?q={{$place->name}}&t=k" target="_blank">
                    <span style="letter-spacing: 0.05rem">@lang('otherworlds.view_in_maps')</span>
                    <i class="ri-external-link-line" style="font-size: 1rem"></i>
                </a>
            </div>
            <style>
                .no_location{
                    position:absolute;
                    inset: 0;
                    background-color: rgba(33, 33, 33, 0.75);
                    z-index: 10000;
                }
            </style>
            @endif
        </div>
    </div>
    {{-- location END --}}

    {{-- links START--}}
    <div class="my-3 d-flex flex-row gap-3 justify-content-center">
        <a class="px-2" href="{{route('place_index', ['locale' => $locale, 'section_slug' => trans('otherworlds.place_index_slug')])}}">@lang('otherworlds.return')</a>
    </div>
    {{-- links END --}}

    <div class="div_h my-5"></div>

    {{-- gallery START --}}
    <div class="my-3">
        <h3 class="text-center">@lang('otherworlds.gallery')</h3>
        <p class="m-4 mx-md-2">
            @lang('otherworlds.view_place_gallery',['link' => "<a class='px-2' href='$place->gallery_url' target='_blank'>".$place->name." Wikimedia <i class='ri-external-link-line' style='font-size: 1rem'></i></a>" ])
        </p>

        <div id="medias_container"></div>
    </div>
    {{-- gallery END --}}
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

</section>
<script>
    function generate_medias_divs(medias){
        const medias_container = document.getElementById('medias_container');

        for (let i = 0; i < medias.length; i++) {
            const media = medias[i];
            const mediabox = document.createElement('div');
            mediabox.className = 'mediabox';

            const bg = document.createElement('bg');
            bg.className = 'bg';
            bg.style.backgroundImage = 'url('+media.url+')';

            mediabox.appendChild(bg);
            medias_container.appendChild(mediabox);
        }
    }

    //on load event create media divs
    document.addEventListener('DOMContentLoaded', function(){
        generate_medias_divs({!! json_encode($place->medias) !!});
    });
</script>
<style>
    #inspect_modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(50, 255, 9, 0.801);
        z-index: 1000;
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
    @media screen and (min-width: 779px) {
    }
    @media screen and (max-width: 778px) {
        #medias_container{
            grid-template-columns: repeat(2, 1fr);
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
    #interactions>button{
        border: none;
        background-color: transparent;
        color: var(--white);
        display: flex;
        border-radius: 0.5rem;
        gap: 0.5rem;
        padding: 0.5rem;
        transition: all 0.15s;
        align-items: center;
        justify-content: center
    }
    #interactions>button>h5{
        margin: 0
    }
    .yellow{
        color: yellow;
    }
    #fav_button:hover{
        background-color: var(--gray_opacity);
        color: yellow;
    }
    .green{
        color: #58D68D;
    }
    #share_button{
        width: 35px;
        height: 35px;
    }
    #share_button:hover{
        background-color: var(--gray_opacity);
        color: #58D68D;
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
</style>
@endsection

@section('script')
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
@endsection
