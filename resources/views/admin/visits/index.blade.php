@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.visits') | Admin {{ config('app.name') }}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}"/>

    <section class="wrapper col-12 col-lg-10">
        <div class="title">
            <div class="text">
                <i class="fa-solid fa-chart-line"></i>
                <h3>@lang('otherworlds.visits')</h3>
                <small>@lang('otherworlds.total'): {{ $total }}</small>
            </div>
            <nav class="buttons">
                <i class="fa-solid fa-spinner"></i>
            </nav>
        </div>

        <div class="table_container">
            <table class="results_table">
                <thead>
                    <tr>
                        <th class="small"></th>
                        <th class="small" title="@lang('otherworlds.country')">
                            <div class="aligner">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                        </th>
                        <th class="text-center">IP</th>

                        <th>@lang('otherworlds.browser')</th>
                        <th>@lang('otherworlds.platform')</th>
                        <th>@lang('otherworlds.route')</th>
                        <th class="text-end">@lang('otherworlds.date')</th>
                        @if($logged->is_owner())
                        <th class="small"></th>
                        @endif
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
        create_rows({!! json_encode($visits) !!})
    });

    window.addEventListener('scroll', function() {
        const container = document.querySelector('.table_container');
        if (container.getBoundingClientRect().bottom < window.innerHeight*1.5){
            attempt_request();
        }
    });

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

    function create_rows(visits) {
        visits.forEach(visit => {
            create_row(visit);
        });
    }
    function create_row(visit) {
        const country = visit.country;
        const row = document.createElement('tr');
        row.setAttribute('id',visit.id)
        row.innerHTML += `
            <td class="text-end number">${counter}</td>
            <td>
                <span class="flag-icon flag-icon-${country.code}" title="${country.name}"></span>
            </td>
            <td class="number">${visit.ip}</td>
            <td>${visit.browser}</td>
            <td>${visit.os}</td>
            <td>${visit.route}</td>
            <td class="text-end number">${visit.created_at}</td>
        `;

        if(logged.role.name == 'owner'){
            row.innerHTML += `
                <td>
                    <div class="aligner">
                        <button class="delete_visit red">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </td>
            `;
            row.querySelector('.delete_visit').addEventListener('click', function(){
            row.style.backgroundColor = "gray";
            delete_visit(row,visit.id);
        });
        }

        results.appendChild(row);
        counter++;
    }
    let page = 1;
    let requesting = false;
    let querying = false;

    function request() {
        //means there are no more users for this query
        if (page == -1) { return; }

        const ajax_data = {
            method: 'POST',
            url: '{{ URL('/ajax/admin/visits/request') }}',
            request_data: {
                _token: '{{ csrf_token() }}',
                locale: '{{ $locale }}',
                page: page,
            },

            before_func: function() {
                requesting = true;
            },
            success_func: function(response_data) {
                // console.log(response_data);
                page = response_data['next_page'];
                create_rows(response_data['visits']);
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

    function delete_visit(row, visit_id) {
        const ajax_data = {
            method: 'POST',
            url: '{{ URL('/ajax/admin/visits/delete') }}',
            request_data: {
                _token: '{{ csrf_token() }}',
                visit_id: visit_id,
            },

            before_func: function() {
                requesting = true;
            },
            success_func: function(response_data) {
                console.log(response_data);
                row.parentElement.removeChild(row);
            },
            after_func: request_cooldown
        }

        ajax(ajax_data);
    }
</script>


@endsection
