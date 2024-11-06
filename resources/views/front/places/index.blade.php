@extends('layout.masterpage')

@section('title')
@lang('otherworlds.title_places') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.description_places')
@endsection

@section('canonical')
{{ places_url($locale)}}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}?{{now()}}"/>

<section class="col-12 py-2 px-3 px-lg-5 app_bg d-inline-flex justify-content-between">
    <h1 class="semibold display-5">
        @lang('otherworlds.unique_places')
    </h1>
    {{-- <nav class="buttons">
        <i class="fa-solid fa-spinner"></i>
        <div class="search_bar">
            <button class="search_button button"><i class="fa-solid fa-magnifying-glass"></i></button>
            <input type="text" placeholder="@lang('otherworlds.search_user')" name="search">
            <button class="clear_button button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <a href="{{ route('user_create', ['locale' => $locale]) }}" class="button info">
            <i class="fa-regular fa-add"></i>@lang('otherworlds.create_user')
        </a>
    </nav> --}}
</section>
<section class="col-12 px-1 px-lg-2 py-3">
    @include('components.places_container')
</section>
@endsection

@section('script')
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
</script>
@endsection

