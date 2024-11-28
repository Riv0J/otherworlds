@extends('layout.masterpage')

@section('title')
@if(isset($selected_country))
    @lang('otherworlds.title_country', ['country' => $selected_country->name])
@else
    @lang('otherworlds.title_places') | Otherworlds
}
@endsection

@section('description')
@if(isset($selected_country))
    @lang('otherworlds.description_country', ['country' => $selected_country->name])
@else
    @lang('otherworlds.description_places')

@endsection

@section('canonical')
{{ url()->current() }}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}?v=5"/>

<section class="col-12 py-2 px-3 px-lg-5 app_bg d-inline-flex justify-content-between">
    <h1 class="semibold display-5">
        @lang('otherworlds.unique_places')
    </h1>
    <nav class="buttons align-items-center">
    <select id="select_country" name="country" required></select>
    </nav>
</section>
<section class="col-12 px-1 px-lg-2 py-3">
    @include('components.places_container')
</section>
@endsection

@section('script')
{{-- select country --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}?v=2"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}?v=8"></script>
<style>
    .dynamic-select a{
        border: none;
    }
    .dynamic-select, .dynamic-select-options, .dynamic-select input{
        background-color:var(--black) !important;
    }
    .dynamic-select-option:hover{
        background-color:var(--gray_opacity) !important;
    }
    .dynamic-select *{
        color: white !important;
    }
</style>
<script>
    const countries_select_data = [];
    Object.values(countries).forEach(function(country){
        countries_select_data.push({
            value: country.id,
            keyword: country.name,
            html: `
            <a href="{{countries_url($locale)}}/${country.name}">
                <span class="big-icon flag-icon flag-icon-${country.code}"></span>
                ${country.name}
            </a>
            `
        });
    });
    
    countries_select_data.unshift({
        value: 0,
        keyword: '@lang('otherworlds.all')',
        html: `
            <a href="{{places_url($locale)}}">
                <i class="fa-solid fa-location-dot small_i"></i>
                @lang('otherworlds.all_countries')
            </a>
        `
    });
    const selected_country = {{$selected_country->id ?? 0}};
    const select = new DynamicSelect('#select_country', {
        placeholder: "@lang('otherworlds.select_country')",
        data: countries_select_data
    });
    select.select_option(selected_country);
</script>

{{-- ajax on scroll --}}
<script>
    //ajax variables
    let current_page = 1;
    let requesting = false;
    let querying = false;

    //on scroll event check if the end of the places container is visible
    window.addEventListener('scroll', function() {
        if(selected_country != 0){ return; }
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
            console.log("Requests done");
            //means there are no more places for this query
            return;
        }
        console.log("Requesting page: "+current_page);
        
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
                create_place_cards(response_data['places']);
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

