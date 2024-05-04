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
    @include('components.places_container')
</section>
@endsection

@section('script')
<script>
document.querySelector('#places_container').innerHTML += `
    <div class="pl_card" id="ajax_loading" style="order: 10000; display: none;">
        <div class="img_bg" style="background-image: url('{{asset('img/loading.gif')}}'); background-size: contain; background-repeat: no-repeat;"></div>
    </div>
`;
</script>
<script>
    //ajax variables
    let current_page = 1;
    let requesting = false;
    let querying = false;

    //on scroll event check if the end of the places container is visible
    window.addEventListener('scroll', function() {
        var container = document.getElementById('places_container');

        //check if scroll is not low enough return
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
</script>
@endsection

