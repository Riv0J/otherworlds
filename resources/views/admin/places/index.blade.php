@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.places') | Admin {{config('app.name')}}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}"/>

    <section class="wrapper col-12 col-lg-10">
        <div class="title">
            <div class="text">
                <i class="fa-solid fa-panorama"></i>
                <h3>@lang('otherworlds.places')</h3>
                <small>@lang('otherworlds.total'): {{ $total }}</small>
            </div>
            <nav class="buttons">
                <i class="fa-solid fa-spinner"></i>
                <div class="search_bar">
                    <button class="search_button button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="text" placeholder="@lang('otherworlds.search_place')" name="search">
                    <button class="clear_button button"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <a href="" class="button info">
                    <i class="fa-regular fa-add"></i>@lang('otherworlds.create_place')
                </a>
            </nav>
        </div>

        <div class="table_container">
            <table class="results_table">
                <thead>
                    <tr>
                        <th class="small"></th>
                        <th class="small" title="@lang('otherworlds.category')">
                            <div class="aligner">
                                <i class="fa-regular fa-circle"></i>
                            </div>
                        </th>
                        <th class="small" title="@lang('otherworlds.country')">
                            <div class="aligner">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                        </th>
                        <th>@lang('otherworlds.name')</th>
                        <th class="medium" title="@lang('otherworlds.views')">
                            <div class="aligner">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                        </th>
                        <th class="medium" title="@lang('otherworlds.favorites')">
                            <div class="aligner gap">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </th>
                        <th class="medium" title="@lang('otherworlds.medias')">
                            <div class="aligner">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('script')
<script src="{{ asset('js/ajax.js') }}"></script>
<script>
    let counter = 1;
    const results = document.querySelector('.results_table tbody');
    const logged = {!! json_encode($logged) !!};

    /* EVENTS */
    document.addEventListener('DOMContentLoaded', function() {
        create_rows({!! json_encode($places) !!})
    });

    document.querySelector('.table_container').addEventListener('scroll', function() {
        // on scroll event, when user has reached 50% of the cointainer's height
        if (this.scrollTop >= (this.scrollHeight - this.offsetHeight) * 0.5) {
            attempt_request();
        }
    });
    const search_button = document.querySelector('.search_button');
    const clear_button = document.querySelector('.clear_button');
    const search_input = document.querySelector('.search_bar input');

    clear_button.addEventListener('click', function(){
        search = ''
    })
    search_input.addEventListener('input', function(){
        if(search_input.value != ''){
            clear_button.style.display = 'flex';
        } else {
            clear_button.style.display = 'none';
        }
    });
    search_input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') { search_button.click(); }
    });

    search_button.addEventListener('click', send_search);
    clear_button.addEventListener('click', function(){
        search_input.value = '';
        clear_button.style.display = 'none';
        send_search();
    });

    function send_search(){
        //reset ajax variables
        wipe_rows();
        search = search_input.value;
        page = 0;
        counter = 1;
        attempt_request();
    }

    function attempt_request(){
        if (requesting == false && querying == false) {
            request();
        } else if (requesting == true) {
            querying = true;
        }
    }

    function wipe_rows(){
        results.innerHTML = '';
        counter = 1;
    }

    function create_rows(places) {
        places.forEach(place => {
            create_row(place);
        });
    }
    function create_row(place) {
        console.log(place);
        const country = place.country;
        const cat = place.category;
        const row = document.createElement('tr');

        row.innerHTML += `
            <td class="number text-end">${counter}</td>
            <td title="${cat.keyword} (${cat.name})">
                <div class="aligner"><i class="small_i fa-solid fa-${cat.img_name}"></i></div>
            </td>
            <td>
                <span class="flag-icon flag-icon-${country.code}" title="${country.name}"></span>
            </td>
            <td>${place.name}</td>
            <td class="number text-end">${format_number(place.views_count)}</td>
            <td class="number text-end">${format_number(place.favorites_count)}</td>
            <td class="number text-end">${place.medias.length}</td>
        `;

        results.appendChild(row);
        row.addEventListener('click',function(){
            window.location.href = `{{places_url($locale)}}/${place.slug}`;
        });
        counter++;
    }

    let page = 1;
    let search = '';
    let requesting = false;
    let querying = false;

    function request() {
        //means there are no more users for this query
        if (page == -1) { return; }

        const ajax_data = {
            method: 'POST',
            url: '{{ URL('/ajax/admin/places/request') }}',
            request_data: {
                _token: '{{ csrf_token() }}',
                locale: '{{ $locale }}',
                page: page,
                search: search
            },

            before_func: function() {
                requesting = true;
            },
            success_func: function(response_data) {
                console.log(response_data);
                page = response_data['next_page'];
                create_rows(response_data['places']);
            },
            after_func: request_cooldown
        }

        ajax(ajax_data);
    }

    async function request_cooldown() {
        await sleep(1000);
        requesting = false;
        if (querying == true) {
            querying = false;
            request();
        }
    }
    function format_number(number) {
        if (number < 1000) {
            return number.toString();
        } else {
            const formattedNumber = Math.abs(number) >= 1.0e+9 ? (Math.abs(number) / 1.0e+9).toFixed(1) + 'B' : (Math.abs(number) >= 1.0e+6 ? (Math.abs(number) / 1.0e+6).toFixed(1) + 'M' : (Math.abs(number) >= 1.0e+3 ? (Math.abs(number) / 1.0e+3).toFixed(1) + 'k' : Math.abs(number)));
            return formattedNumber;
        }
    }
</script>
@endsection
