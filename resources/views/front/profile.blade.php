@extends('layout.masterpage')

@section('title')
@lang('otherworlds.profile') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.visit_user_profile',['username' => $user->name]) | Otherworlds
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}"/>

<section class="wrapper col-12 col-lg-8">
    <div class="spacer mt-4 pt-5"></div>

    <div class="mb-4 title">
        <div class="d-flex flex-row align-items-end gap-4">
            <div class="profile_img" style="background-color: gray;">
                <img src="{{asset('img/users/'.$user->img)}}" style="width: 5rem;" alt="@lang('otherworlds.user_image')">
            </div>
            <div class="d-flex flex-column justify-content-between">
                <h3 class="regular pb-2">{{$user->name}}</h3>
                <h5>
                    <span class="flag-icon flag-icon-{{$user->country->code}}" title="{{$user->country->name}}"></span>
                    {{$user->country->name}}
                </h5>
            </div>
        </div>

        <nav class="buttons d-flex flex-row">

            {{-- #edit_button START--}}
            @if($owner == true)
                <button title='@lang('otherworlds.edit')' id="edit_button" class="button info">
                    <i class="fa-regular fa-pen-to-square" style="translate: 2% -5%"></i>
                </button>
            @endif
            {{-- #edit_button END--}}
        </nav>
    </div>

    <h4 class="mb-4 semibold">
        <i class="ri-arrow-right-s-line"></i>
        <span class="mx-1">@lang('otherworlds.favorite_places')</span>
    </h4>
    <div class="gap-2 gap-md-3 justify-content-center align-items-stretch" id="places_container">

    </div>
</section>
<style>

</style>
@endsection

@section('script')
{{-- #edit_button onclick --}}
@if($owner == true)
<script>
    document.querySelector('#edit_button').addEventListener('click',function(){
    });
</script>
@endif

{{-- generate the favorite places divs --}}
<script>
    const place_view_route = "{{ route('place_view', ['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug'), 'place_slug' => 'null']) }}".replace('/null', '');

    const places = {!! $places->values()->toJson() !!};

    const loaded_countries = organize_dic({!! json_encode($countries) !!})
    const loaded_categories = organize_dic({!! json_encode($all_categories) !!});

    document.addEventListener('DOMContentLoaded', function(){
        create_place_cards(places);
    });

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
            star_icon.className = 'fa-star fa-solid yellow';

            const fav_count = document.createElement('h5');
            fav_count.textContent = formatNumber(place.favorites_count);

            //add fav_count and star_icon to fav_button
            fav_button.appendChild(fav_count);
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

    function organize_dic(dic){
        const organized_dic = {};
        for (let i = 0; i < Object.keys(dic).length; i++) {
            const obj = dic[i];
            organized_dic[obj.id] = obj;
        }
        return organized_dic;
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
