{{-- needs a collection of $places, $countries and $all_categories to function --}}
<script src='{{asset('js/ajax.js')}}'></script>
<div class="gap-2 gap-md-3 justify-content-center align-items-stretch" id="places_container">
    <div class="pl_card" id="no_places" style="display: none;">
        No favorite places for this user.<a href="{{route('place_index',['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug')])}}">Browse all places</a>
    </div>
</div>
<script>
    //on load event
    document.addEventListener('DOMContentLoaded', function(){
        const initial_places = {!! $places->values()->toJson() !!};
        if(initial_places.length == 0){
            document.querySelector('#no_places').style.display = "initial";
            return;
        }

        create_place_cards({!! $places->values()->toJson() !!});

        //format every .short_number
        document.querySelectorAll('.short_number').forEach(element => {
            element.textContent = formatNumber(element.textContent);
        });
    });

    const place_view_route = "{{ route('place_view', ['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug'), 'place_slug' => 'null']) }}".replace('/null', '');

    const loaded_countries = organize_dic({!! json_encode($countries) !!});
    const loaded_categories = organize_dic({!! json_encode($all_categories) !!});
    const favorite_ids = {!! json_encode($fav_places_ids) !!};

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

            card_top.innerHTML += `
                <div title="${category.keyword} (${category.name})" class="trait">
                    <i class='small_i fa-solid fa-${category.img_name}'></i>
                </div>
            `;

            //fav_button
            const fav_button = document.createElement('button');
            fav_button.className = 'button border-0 fav_button';
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

            const fav_count = document.createElement('h5');
            fav_count.textContent = formatNumber(place.favorites_count);

            //add fav_count and star_icon to fav_button
            fav_button.appendChild(fav_count);
            fav_button.appendChild(star_icon);

            const pl_info = document.createElement('div');
            pl_info.className = 'pl_info';

            const synopsis = document.createElement('div');
            synopsis.className = 'card_sinopsis';
            synopsis.innerHTML += `<p class="light col-12">${place.synopsis}</p>`;

            //add to pl_info
            pl_info.innerHTML += `<h3 class="regular mb-2">${place.name}</h3>`;
            pl_info.innerHTML += `<p class="flex_center gap-2">
                    <span class='flag-icon flag-icon-${country.code}'></span>
                    <span>${country.name}</span>
                </p>
            `;
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
