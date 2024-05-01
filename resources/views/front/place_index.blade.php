@extends('layout.masterpage')

@section('title')
@lang('otherworlds.title_places') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.description_places')
@endsection

@section('canonical')
{{ route('place_index',['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug')]) }}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}"/>
<div class="spacer mt-4 pt-5"></div>

<section class="col-12 px-lg-5 pb-2 header_offset app_bg">
    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2 white">
        @lang('otherworlds.unique_places')
    </h2>
</section>

<section class="col-12 px-1 px-lg-2 py-3">

    <div class="gap-2 gap-md-3 justify-content-center align-items-stretch" id="places_container">
        <div class="pl_card" id="ajax_loading" style="order: 10000; display: none;">
            <div class="img_bg" style="background-image: url('{{asset('img/loading.gif')}}'); background-size: contain; background-repeat: no-repeat;"></div>
        </div>
    </div>
</section>

@endsection


@section('script')
<script src='{{asset('js/ajax.js')}}'></script>
<script>
    const place_view_route = "{{ route('place_view', ['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug'), 'place_slug' => 'null']) }}".replace('/null', '');

    const loaded_countries = organize_dic({!! json_encode($countries) !!})
    const loaded_categories = organize_dic({!! json_encode($all_categories) !!});

    const favorite_ids = {!! json_encode($fav_places_ids) !!};

    //on load event create place divs
    document.addEventListener('DOMContentLoaded', function(){
        create_place_cards({!! $places->values()->toJson() !!});
    });

    function organize_dic(dic){
        const organized_dic = {};
        for (let i = 0; i < Object.keys(dic).length; i++) {
            const obj = dic[i];
            organized_dic[obj.id] = obj;
        }
        return organized_dic;
    }

    async function create_place_cards(places_json) {
        for (let i = 0; i < Object.keys(places_json).length; i++) {
            const place = places_json[i];
            const category = loaded_categories[place.category_id];
            const country = loaded_countries[place.country_id];

            const pl_card = document.createElement('div');
            pl_card.className = "pl_card";

            const pl_link = document.createElement('a');
            pl_link.className = "border-0";
            pl_link.href = place_view_route + '/' + place.slug;

            const card_top = document.createElement('div');
            card_top.className = 'card_top';

            const cat_icon = `
                <div title="${category.keyword} (${category.name})" class="trait">
                    <i class='small_i fa-solid fa-${category.img_name}'></i>
                </div>
            `;
            card_top.innerHTML += cat_icon;

            //fav_button
            const fav_button = document.createElement('button');
            fav_button.className = 'd-flex gap-2 button fav_button';
            fav_button.id = place.id;
            card_top.appendChild(fav_button);

            const star_icon = document.createElement('i');
            star_icon.className = 'fa-star';
            if(favorite_ids.includes(place.id) == false){
                star_icon.className += ' fa-regular';
            }else{
                star_icon.className += ' fa-solid';
                fav_button.className += ' yellow';
            }

            //add fav_count and star_icon to fav_button
            fav_button.innerHTML += `<h5>${formatNumber(place.favorites_count)}</h5>`;
            fav_button.appendChild(star_icon);

            const pl_info = document.createElement('div');
            pl_info.className = 'pl_info';

            const cy_info =`
                <p class="flex_center gap-2">
                    <span class='flag-icon flag-icon-${country.code}'></span>
                    <span>${country.name}</span>
                </p>
            `;

            const synopsis = document.createElement('div');
            synopsis.className = 'card_sinopsis';
            synopsis.innerHTML += `<p class="light col-12">${place.synopsis}</p>`;

            //add to pl_info
            pl_info.innerHTML += `<h3 class="regular mb-2">${place.name}</h3>`;
            pl_info.innerHTML += cy_info;
            pl_info.appendChild(synopsis);

            //add to pl_link
            const url = '{{asset('places/')}}' + '/' + place.public_slug + '/t.png';
            pl_link.innerHTML += `<div class='img_bg' style='background-image:url(${url})'></div>`;
            pl_link.appendChild(pl_info);

            //add to pl_card
            pl_card.appendChild(card_top);
            pl_card.appendChild(pl_link);

            @if(Auth::check() === true)
            const ajax_data = {
                method: 'POST',
                url: '{{ URL('/ajax/places/favorite') }}',
                request_data : {
                    _token: '{{ csrf_token() }}',
                    place_id: place.id
                },
                success_func: function (response_data){
                    if(response_data['is_fav'] == false){
                        star_icon.className = 'fa-regular fa-star';
                        fav_button.classList.remove('yellow');
                    }else{
                        star_icon.className = 'fa-solid fa-star';
                        fav_button.classList.add('yellow');
                    }
                    fav_count.textContent = formatNumber(response_data['favorites_count']);
                }
            }
            //on click fav_button when logged in
            fav_button.addEventListener('click', function(){
                ajax(ajax_data);
            });

            @else
            //on click fav_button when not logged in
            fav_button.addEventListener('click', function(){
                window.location.href = '{{ route("login", ["locale" => $locale]) }}';
            });
            @endif

            //add listeners on hover
            pl_card.addEventListener('mouseover', function(){
                synopsis.style.height = synopsis.scrollHeight+'px';
            });
            pl_card.addEventListener('mouseout', function(){
                synopsis.style.height = 0;
            });
            document.getElementById('places_container').appendChild(pl_card);
        }
    }

    //ajax variables
    let current_page = 1;
    let requesting = false;
    let querying = false;

    //on scroll event check if the end of the places container is visible
    window.addEventListener('scroll', function() {
        var container = document.getElementById('places_container');

        //check if the scroll is not low enough
        if (container.getBoundingClientRect().bottom > window.innerHeight*1.25){
            return;
        }

        if (requesting == false && querying == false) {
            request_places();
        } else if (requesting == true){
            querying = true;
        }
    });

    function request_places(){
        if (current_page == -1){
            //means there are no more places for this query
            return;
        }
        const ajax_data = {
            method: 'POST',
            url: '{{ URL('/ajax/places/request') }}',
            request_data : {
                _token: '{{ csrf_token() }}',
                locale: '{{$locale}}',
                current_page: current_page,
            },
            before_func: function(){
                requesting = true;
                const ajax_loading = document.getElementById('ajax_loading'); //show #ajax_loading
                ajax_loading.style.display = 'flex';
            },
            success_func: function (response_data){
                current_page = response_data['current_page'];

                //add the countries to loaded_countries
                response_data['countries'].forEach(function(country) {
                    if(loaded_countries[country.id] == null){
                        loaded_countries[country.id] = country;
                    }
                });

                create_place_cards(response_data['places']); //create the place cards
            },
            after_func: function(){
                ajax_loading.style.display = 'none'; //hide #ajax_loading
                request_cooldown();
            }
        }

        ajax(ajax_data);
    }

    async function request_cooldown(){
        await sleep(1000);
        requesting = false;
        if(querying == true){
            querying = false;
            request_places();
        }
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
@endsection
