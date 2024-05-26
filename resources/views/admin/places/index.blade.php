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
                <div>
                    <select id="select_category" name="category" required></select>
                </div>
                <div>
                    <select id="select_country" name="country" required></select>
                </div>
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
    const logged = {!! json_encode($logged) !!};
    const countries = organize_dic({!! json_encode($countries) !!});
    const categories = organize_dic({!! json_encode($categories) !!});

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

    /* AJAX & SEARCH */
    const results = document.querySelector('.results_table tbody');
    const search_button = document.querySelector('.search_button');
    const clear_button = document.querySelector('.clear_button');
    const search_input = document.querySelector('.search_bar input');
    let country_input = null;
    let category_input = null;

    document.addEventListener('DOMContentLoaded', function(){
        country_input = document.querySelector('input[name="country"]');
        category_input = document.querySelector('input[name="category"]');
        const hidden_inputs = [country_input,category_input];

        //custom getter-setter for input, same purpose as change event but for input hiddens
        hidden_inputs.forEach(function(input) {
            let value = 0;
            Object.defineProperty(input, "value", {
                set(new_value) {
                    //console.log(input.name+" Value changed to", new_value);
                    value = new_value;
                    send_search()
                },
                get(){
                    return value;
                }
            });
        });
    });

    let counter = 1;
    let page = 1;
    let search = '';
    let requesting = false;
    let querying = false;

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
        wipe_rows();
        //reset ajax variables
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
        const country = countries[place.country_id];
        const cat = categories[place.category_id];
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

    function request() {
        const country_id = country_input.value;
        const category_id = category_input.value;

        //means there are no more objects left for this query
        if (page == -1) { return; }

        const ajax_data = {
            method: 'POST',
            url: '{{ URL('/ajax/admin/places/request') }}',
            request_data: {
                _token: '{{ csrf_token() }}',
                locale: '{{ $locale }}',
                page: page,
                search: search,
                country_id: country_id,
                category_id: category_id
            },

            before_func: function() {
                requesting = true;
            },
            success_func: function(response_data) {
                console.log(response_data);
                page = response_data['next_page'];
                const places = response_data['places'];
                if(places.length == 0 && counter == 1){
                    //no results for query
                } else {
                    create_rows(response_data['places']);
                }

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
</script>

{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}"></script>
<script>
    const countries_select_data = [
        {
            value: 0,
            keyword: '@lang('otherworlds.all')',
            html: `
                <div class="aligner gap-2">
                    <i class="fa-solid fa-location-dot"></i>
                    @lang('otherworlds.all')
                </div>
            `
        }
    ];

    Object.values(countries).forEach(function(country){
        countries_select_data.push({
            value: country.id,
            keyword: country.name,
            html: `
                <span class="big-icon flag-icon flag-icon-${country.code}"></span>
                ${country.name}
            `
        });
    })

    const select = new DynamicSelect('#select_country', {
        placeholder: "@lang('otherworlds.select_country')",
        data: countries_select_data
    });

    select.select_option('0')
</script>
<script>
    console.log();
    const categories_select_data = [
        {
            value: 0,
            keyword: '@lang('otherworlds.all')',
            html: `
                <div class="aligner gap-2">
                    <i class="fa-regular fa-circle"></i>
                    @lang('otherworlds.all')
                </div>
            `
        }
    ];

    Object.values(categories).forEach(function(cat){
        categories_select_data.push({
            value: cat.id,
            keyword: cat.keyword,
            html: `
                <div class="aligner gap-2">
                    <i class="small_i fa-solid fa-${cat.img_name}"></i>
                        ${cat.keyword}
                </div>
            `
        });
    });
    const select2 = new DynamicSelect('#select_category', {
        placeholder: "@lang('otherworlds.select_category')",
        data: categories_select_data
    });

    select2.select_option('0')
</script>
<style>
    .dynamic-select{
        background-color: unset;
        border: 1px solid var(--gray_light);
        height: 3rem;
        justify-content: center;
        border-radius: 0.5rem;
    }
    .dynamic-select i{
        width: 1rem;
        font-size: 1rem;
    }
    .dynamic-selected, .dynamic-select-option, .dynamic-select-header-input input, .dynamic-select i{
        color: white !important;
        border: unset;
        background-color: unset;
    }
    .dynamic-select-header-input input:focus{
        outline: none;
    }
    .dynamic-select-options{
        background-color: var(--black) !important;
        border: 1px solid var(--gray_light);
    }
    .dynamic-select-option:hover{
        background-color: var(--gray_light) !important;
    }
</style>
@endsection
