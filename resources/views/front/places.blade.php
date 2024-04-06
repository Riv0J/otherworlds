@extends('layout.masterpage')

@section('title')
@lang('otherworlds.title_places') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.description_places')
@endsection

@section('canonical')
{{ route('places') }}
@endsection

@section('content')
<div class="spacer mt-4 pt-5"></div>

<section class="col-12 px-lg-5 pb-2 header_offset app_bg">
    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2 white">
        @lang('otherworlds.unique_places')
    </h2>
</section>

<section class="col-12 px-1 px-lg-2 py-3">

    <div class="gap-2 gap-md-3 justify-content-center align-items-stretch" id="places_container">

        {{-- @foreach ($all_places as $place)
        <a href="{{route('view_place', ['place_name' => $place->name])}}"
            class="places_card d-flex flex-column align-items-between justify-content-between p-0 rounded-4 white text-left">
            <div class="image_background" image_path="{{asset('img/places/'.$place->id.'/t.png')}}"></div>

            <div class="card_stats gap-2 d-flex justify-content-between align-items-center p-2">
                <div>
                    <img class="img_icon" title="{{$place->category->keyword}} ({{$place->category->name}})" src="{{asset('img/categories/'.strtolower($place->category->translate('en')->keyword)).'.png'}}" alt="">
                </div>
                <div class="d-flex flex-row gap-2 align-items-center pr-3">
                    <p>{{$place->favorites_count}}</p> <i class="fa-regular fa-star"></i>
                </div>

            </div>

            <div class="places_card_info d-flex flex-column align-items-start text-left px-3 py-2 pt-5 w-100">
                <h3 class="regular mb-2">
                    {{$place->name}}
                </h3>

                <p class="flex_center gap-2">
                    <span class="flag-icon flag-icon-{{$place->country->code}}"></span>{{$place->country->name}}
                </p>
                <div class="card_sinopsis flex_center row p-0">
                    <p class="light col-12">
                        {{$place->synopsis}}
                    </p>
                </div>

            </div>
        </a>
        @endforeach --}}
        <div class="places_card flex-column align-items-between justify-content-between p-0 rounded-4 white text-left" id="ajax_loading" style="order: 10000; display: flex;">
            <div class="image_background" style="background-image: url('{{asset('img/loading.gif')}}'); background-size: contain; background-repeat: no-repeat;"></div>
        </div>
    </div>
</section>

@endsection


@section('script')

<script>
    const view_place_route = "{{ route('view_place', ['place_name' => 'null']) }}".replace('/null', '');

    const loaded_countries = organize_dic({!! json_encode($countries) !!})
    const loaded_categories = organize_dic({!! json_encode($all_categories) !!});

    const favorite_ids = {!! json_encode($fav_places_ids) !!};

    //on load event create place divs
    document.addEventListener('DOMContentLoaded', function(){
        create_places_divs({!! $places->values()->toJson() !!});
    });

    function organize_dic(dic){
        const organized_dic = {};
        for (let i = 0; i < Object.keys(dic).length; i++) {
            const obj = dic[i];
            organized_dic[obj.id] = obj;
        }
        return organized_dic;
    }

    async function create_places_divs(places_json) {
        for (let i = 0; i < Object.keys(places_json).length; i++) {
            const place = places_json[i];
            const category = loaded_categories[place.category_id];
            const country = loaded_countries[place.country_id];

            const placeLink = document.createElement('a');
            placeLink.href = view_place_route + '/' + place.name;
            placeLink.classList.add('places_card', 'd-flex', 'flex-column', 'align-items-between', 'justify-content-between', 'p-0', 'rounded-4', 'white', 'text-left');
            placeLink.id = place.id;

            const imageBackground = document.createElement('div');
            imageBackground.classList.add('image_background');

            /* set the backgroundImage */
            const url = '{{asset('img/places/')}}' + '/' + place.id + '/t.png';
            imageBackground.style.backgroundImage = 'url('+url+')';

            placeLink.appendChild(imageBackground);

            const card_stats = document.createElement('div');
            card_stats.classList.add('card_stats', 'gap-2', 'd-flex', 'justify-content-between', 'align-items-center', 'p-2');

            const categoryIcon = document.createElement('div');
            card_stats.appendChild(categoryIcon);

            const iconImage = document.createElement('img');
            iconImage.classList.add('img_icon');
            iconImage.title = category.keyword + ' (' + category.name + ')';
            iconImage.src = "{{asset('img/categories/')}}" + '/' + category.img_name.toLowerCase() + '.png';
            categoryIcon.appendChild(iconImage);

            const fav_button = document.createElement('button');
            fav_button.className = "d-flex flex-row gap-2 align-items-center pr-3 interaction_button fav_button";
            card_stats.appendChild(fav_button);

            const favorites_count = document.createElement('h5');
            favorites_count.className = "m-0";
            favorites_count.textContent = formatNumber(place.favorites_count);
            fav_button.appendChild(favorites_count);

            const star_icon = document.createElement('i');
            if(favorite_ids.includes(place.id) == false){
                star_icon.classList.add('fa-regular', 'fa-star');
            }else{
                star_icon.classList.add('fa-solid', 'fa-star');
                fav_button.classList.add('yellow');
            }
            fav_button.appendChild(star_icon);

            placeLink.appendChild(card_stats);

            const placesCardInfo = document.createElement('div');
            placesCardInfo.classList.add('places_card_info', 'd-flex', 'flex-column', 'align-items-start', 'text-left', 'px-3', 'py-2', 'pt-5', 'w-100');

            const placeName = document.createElement('h3');
            placeName.classList.add('regular', 'mb-2');
            placeName.textContent = place.name;

            const countryInfo = document.createElement('p');
            countryInfo.className = "flex_center gap-2";

            const countryFlag = document.createElement('span');
            countryFlag.classList.add('flag-icon', 'flag-icon-' + country.code);
            countryInfo.appendChild(countryFlag);

            const countryName = document.createElement('span');
            countryName.textContent = country.name;
            countryInfo.appendChild(countryName);

            const cardSinopsis = document.createElement('div');
            cardSinopsis.classList.add('card_sinopsis', 'flex_center', 'row', 'p-0');

            const sinopsisText = document.createElement('p');
            sinopsisText.classList.add('light', 'col-12');
            sinopsisText.textContent = place.synopsis;
            cardSinopsis.appendChild(sinopsisText);

            placesCardInfo.appendChild(placeName);
            placesCardInfo.appendChild(countryInfo);
            placesCardInfo.appendChild(cardSinopsis);
            placeLink.appendChild(placesCardInfo);

            document.getElementById('places_container').appendChild(placeLink);
        }
    }

    //AJAX START
    //ajax variables
    let current_page = 1;
    let requesting = false;

    //on scroll event check if the end of the places container is visible
    window.addEventListener('scroll', function() {
        var container = document.getElementById('places_container');
        if (current_page == -1){
            //means there are no more places for this query
            return;
        } else if (container.getBoundingClientRect().bottom <= window.innerHeight*1.25 && requesting == false) {
            request_places();
        }
    });

    function request_places(){
        requesting = true;

        //show the #ajax_loading div
        const ajax_loading = document.getElementById('ajax_loading');
        ajax_loading.style.display = 'flex';

        // AJAX with fetch
        const request_data = {
            _token: '{{ csrf_token() }}',
            current_page: current_page,
        };
        fetch("{{ URL('/ajax/places/request') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': request_data['_token']
            },
            body: JSON.stringify(request_data),
        })
        // fetch response
        .then(response => {
            // if response is ok (status 200-299)
            if (response.ok) {
                return response.json();
            }
            // error request
            else {
                throw new Error('Error ' + response.statusText);
            }
        })
        // fetch handle data
        .then(response_data => {
            current_page = response_data['current_page'];

            response_data['countries'].forEach(function(country) {
                if(loaded_countries[country.id] == null){
                    loaded_countries[country.id] = country;
                }
            });

            create_places_divs(response_data['places']);
        })
        // fetch error
        .catch(error => {
            console.error('Request Error:', error);
        })
        // fetch complete
        .finally(() => {
            console.log('Fetched');
            ajax_loading.style.display = 'none';
            request_cooldown();
        });
    }
    //AJAX END

    async function request_cooldown(){
        await sleep(2000);
        requesting = false;
    }
    async function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function formatNumber(number) {
        if (number < 1000) {
            return number.toString();
        } else {
            const formattedNumber = Math.abs(number) >= 1.0e+9 ? (Math.abs(number) / 1.0e+9).toFixed(1) + 'B' : (Math.abs(number) >= 1.0e+6 ? (Math.abs(number) / 1.0e+6).toFixed(1) + 'M' : (Math.abs(number) >= 1.0e+3 ? (Math.abs(number) / 1.0e+3).toFixed(1) + 'k' : Math.abs(number)));
            return formattedNumber;
        }
    }
</script>
<style>
    .interaction_button{
        border: none;
        background-color: transparent;
        color: var(--white);
        display: flex;
        border-radius: 0.5rem;
        gap: 0.5rem;
        padding: 0.5rem;
        transition: all 0.15s;
    }
    .interaction_button>h5{
        margin: 0
    }
    .yellow{
        color: yellow;
    }
    .fav_button:hover{
        background-color: var(--gray_opacity);
        color: yellow;
    }
    .img_icon{
        width: 2.5rem;
        aspect-ratio: 1;
    }
    #places_container{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))
    }
    @media screen and (min-width: 1921px) {
        #places_container {
            grid-template-columns: repeat(6, 1fr); /* Máximo de 6 elementos por fila */
        }
    }

    .card_stats{
        padding-right: 1rem !important;
        position: relative;
        z-index: 500;
        background: linear-gradient(180deg, rgb(29, 29, 29) 0%, rgba(255, 255, 255, 0) 100%);
    }
    .card_stats i{
        color: yellow;
        transition: all 1s;
    }
    .card_stats:hover{
        /* background-color: gray; */
    }
    .card_sinopsis{
        height: 0;
    }
    .places_card, #ajax_loading{
        min-height: 500px;
        position: relative;
        overflow: hidden;
        color: white;
        border-width: 2px;
        border-color: gray;
    }
    @media screen and (min-width: 1921px) {
        .places_card {
            min-height: 700px;
        }
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
    #ajax_loading:hover>.image_background{
        scale: 1;
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
<script>
    @if(Auth::check() === true)

    document.getElementById('fav_button').addEventListener('click', function(){
        event.stopPropagation();
        console.log('a');
    });
    function fav_ajax(){
        // AJAX with fetch: favorite a place
        const request_data = {
            _token: '{{ csrf_token() }}',
            place_id: 99,
        };

        fetch("{{ URL('/ajax/places/favorite') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': request_data['_token']
            },
            body: JSON.stringify(request_data),
        })
        // fetch response
        .then(response => {
            // if response is ok (status 200-299)
            if (response.ok) {
                return response.json();
            }
            // error request
            else {
                throw new Error('Error ' + response.statusText);
            }
        })
        // fetch handle data
        .then(response_data => {
            const fav_button =  document.getElementById('fav_button');
            const i = fav_button.querySelector('i');

            if(response_data === false){
                fav_button.classList.remove('yellow');
                i.className = 'fa-regular fa-star';
            }else{
                fav_button.classList.add('yellow')
                i.className = 'fa-solid fa-star';
            }
        })
        // fetch error
        .catch(error => {
            console.error('Request Error:', error);
        })
        // fetch complete
        .finally(() => {
            console.log('Fetched');
        });
        //AJAX END
    }

    @else
    document.getElementById('fav_button').addEventListener('click', function(){
        event.stopPropagation();
        window.location.href = '{{ route("login") }}';
    });
    @endif
</script>
@endsection
