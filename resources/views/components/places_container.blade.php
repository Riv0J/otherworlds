{{-- needs a collection of $places, $countries and $categories to function --}}
<script src='{{asset('js/ajax.js')}}'></script>
<div class="" id="places_container">
    <div class="pl_card" id="no_places" style="display: none;">
        @lang('otherworlds.no_favorites_user').
        <a href="{{ url($locale.'/'.trans('places_slug',[],$locale)) }}">
            @lang('otherworlds.browse_places')
        </a>
    </div>
</div>
<template>
<div class="pl_card">
    <a href="">
        <div class="img_bg"></div>

        <div class="card_top">
            <div class="trait" title="">
                <i class="small_i fa-solid"></i>
            </div>
            <div class="views" title="@lang('otherworlds.views')">
                <span class="short_number"></span>
                <i class="small_i fa-solid fa-eye"></i>
            </div>
        </div>
        
        <div class="card_bot">
            <div class="pl_info">
                <h2 class="regular mb-2"></h2>
                <p class="flex_center gap-2">
                    <span class="flag-icon"></span>
                    <span class="country"></span>
                </p>
                <div class="card_sinopsis" style="height: 0px;">
                    <p class="light"></p>
                </div>
            </div>
        </div>
    </a>
</div>
</template>
<script>
    const place_ids = [];
    //on load event
    document.addEventListener('DOMContentLoaded', function(){
        const initial_places = {!! $places->values()->toJson() !!};
        if(initial_places.length == 0){
            document.querySelector('#no_places').style.display = "initial";
            return;
        }

        create_place_cards({!! $places->values()->toJson() !!});
    });

    const places_route = "{{places_url($locale)}}"
    const countries = organize_dic({!! json_encode($countries) !!});
    const categories = organize_dic({!! json_encode($categories) !!});
    const card_container = document.querySelector('#places_container');
    
    async function create_place_cards(places_json) {
        for (let i = 0; i < Object.keys(places_json).length; i++) {
            const place = places_json[i];
            if (place_ids.includes(place.id)) {
                console.log("Already in: "+place);
                continue;
            }
            place_ids.push(place.id);
            console.log("Places: "+place_ids.length+". Added"+place.id);
            
            const anchor = create_card(place);
            anchor.style.animationDelay = i * 0.2 + 's';
            anchor.classList.add('appear');
        }
    }
    function create_card(place){
        const card = document.querySelector('template').content.cloneNode(true);
        const category = categories[place.category_id];
        const country = countries[place.country_id];

        const anchor = card.querySelector('a');
        anchor.setAttribute('href',places_route + '/' + place.slug);
        
        const trait = card.querySelector('.trait')
        trait.title = `${category.keyword} (${category.name})`;
        trait.querySelector('i').className += ` fa-${category.img_name}`;

        const views = card.querySelector('.views span')
        views.textContent = format_number(place.views_count);

        const bg = card.querySelector('.img_bg');
        const url = '{{asset('places/')}}' + '/' + place.public_slug + '/'+ place.thumbnail;
        bg.style.backgroundImage = `url(${url})`;

        card.querySelector('h2').textContent = place.name;
        card.querySelector('.flag-icon').className += ` flag-icon-${country.code}`;
        card.querySelector('.country').textContent = country.name;

        const synopsis = card.querySelector('.card_sinopsis');
        synopsis.querySelector('p').textContent = place.synopsis;

        //add listeners on hover
        anchor.addEventListener('mouseover', function(){
            synopsis.style.height = synopsis.scrollHeight+'px';
        });
        anchor.addEventListener('mouseout', function(){
            synopsis.style.height = 0;
        });

        card_container.appendChild(card);
        return anchor;
    }
    function organize_dic(dic) {
        const organized_dic = {};
        for (let i = 0; i < Object.keys(dic).length; i++) {
            const obj = dic[i];
            organized_dic[obj.id] = obj;
        }
        return organized_dic;
    }
</script>

