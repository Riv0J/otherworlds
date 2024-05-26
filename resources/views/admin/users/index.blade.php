@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.users') | Admin {{ config('app.name') }}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}"/>

    <section class="wrapper col-12 col-lg-10">
        <div class="title">
            <div class="text">
                <i class="fa-solid fa-users"></i>
                <h3>@lang('otherworlds.users')</h3>
                <small>@lang('otherworlds.total'): {{ $total }}</small>
            </div>
            <nav class="buttons">
                <i class="fa-solid fa-spinner"></i>
                <div class="search_bar">
                    <button class="search_button button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="text" placeholder="@lang('otherworlds.search_user')" name="search">
                    <button class="clear_button button"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <a href="{{ route('user_create', ['locale' => $locale]) }}" class="button info">
                    <i class="fa-regular fa-add"></i>@lang('otherworlds.create_user')
                </a>
            </nav>
        </div>

        <div class="table_container">
            <table class="results_table">
                <thead>
                    <tr>
                        <th class="small"></th>
                        <th class="small">@lang('otherworlds.role')</th>
                        <th class="small" title="@lang('otherworlds.country')">
                            <div class="aligner">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                        </th>
                        <th class="medium">
                            <div class="aligner">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        </th>
                        <th>@lang('otherworlds.username')</th>
                        <th>@lang('otherworlds.email')</th>
                        <th class="medium"></th>
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
    <script src="{{ asset('js/tables.js') }}"></script>
    <script>
        function request_reset_img(request_url, user_id, row) {
            const ajax_data = {
                method: 'POST',
                url: request_url,
                request_data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id
                },
                before_func: function() {},
                success_func: function(response_data) {
                    if (response_data.user != null) {
                        refresh_row(row, response_data.user)
                    }

                },
                after_func: function() {}
            };

            ajax(ajax_data);
        }

        function request_toggle_ban(request_url, user_id, row) {
            const ajax_data = {
                method: 'POST',
                url: request_url,
                request_data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id
                },
                before_func: function() {},
                success_func: function(response_data) {
                    if (response_data.user != null) {
                        refresh_row(row, response_data.user)
                    }

                },
                after_func: function() {}
            };

            ajax(ajax_data);
        }

        function refresh_row(row, user) {
            row.querySelector('.profile_img img').setAttribute('src', "{{ asset('users/null_img') }}".replace('null_img',
                user.img));

            const ban_button = row.querySelector('.ban_toggle');
            const ban_i = row.querySelector('.ban_toggle i');
            const name_container = row.querySelector('.name_td div')
            if (user.active == 1) {
                ban_button.className = "ban_toggle red";
                ban_i.className = "fa-solid fa-ban";
                name_container.innerHTML = user.name;
                row.setAttribute('active', true);
            } else {
                ban_button.className = "ban_toggle green";
                ban_i.className = "fa-solid fa-rotate-left";
                row.setAttribute('active', false);
                name_container.innerHTML = '<i class="fa-solid fa-ban" style="color: red"></i>' + user.name
            }
        }
    </script>
    <script>
        const results = document.querySelector('.results_table tbody');
        const logged = {!! json_encode($logged) !!};
        const loaded_roles = organize_dic({!! json_encode($roles) !!});

        document.addEventListener('DOMContentLoaded', function() {
            create_rows({!! json_encode($users) !!})
        });

        function wipe_rows(){
            results.innerHTML = '';
        }
        function create_rows(users) {
            users.forEach(user => {
                create_row(user);
            });
        }

        function create_row(user) {
            const role = loaded_roles[user.role_id];
            const country = user.country;
            const row = document.createElement('tr');
            row.setAttribute('user_id', user.id)
            row.setAttribute('username', user.name)
            row.setAttribute('role', role.name);
            if (user.active == 1) {
                row.setAttribute('active', "true");
            } else {
                row.setAttribute('active', "false");
            }
            if (logged.id == user.id) {
                row.setAttribute("you", "");
            }
            row.setAttribute('title', "User ID =  " + user.id);
            row.innerHTML += `<td class="text-end number">${counter}</td>`
            // role
            const role_td = document.createElement('td')
            if (role.name != 'user') {
                role_td.innerHTML += `<div class="aligner"><i class="fa-solid ${role.icon}"></i></div>`;
            }
            row.appendChild(role_td);

            // country
            row.innerHTML += `
                    <td>
                        <span class="flag-icon flag-icon-${country.code}" title="${country.name}"></span>
                    </td>
            `;

            // profile_img
            const asset_route = "{{ asset('users') }}" + '/' + user.img;
            row.innerHTML += `<td class="px-0"><div class="profile_img aligner"><img src="${asset_route}"></div></td>`;

            // name
            const div = document.createElement('div');
            div.className = "d-flex gap-2";
            if (user.active == 0) {
                div.innerHTML += `<i class="fa-solid fa-ban" style="color: red"></i>`;
            }
            div.innerHTML += user.name;
            if (user.id == logged.id) {
                div.innerHTML += ' [YOU]';
            }
            const td = document.createElement('td');
            td.className = 'name_td';
            td.appendChild(div);
            row.appendChild(td);

            // email
            row.innerHTML += `<td>${user.email}</td>`;

            // buttons, check if its editable
            const td_buttons = document.createElement('td');

            if (user.id != logged.id && (role.name == 'user' || role.name == 'guest')) {
                const aligner = create_aligner();
                td_buttons.appendChild(aligner);
                aligner.innerHTML += `
                    <button class="edit yellow">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="reset_img red">
                        <i class="fa-solid fa-camera-rotate"></i>
                    </button>
                `;
                if (user.active == 1) {
                    aligner.innerHTML += `
                        <button class="ban_toggle red">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                    `;
                } else {
                    aligner.innerHTML += `
                        <button class="ban_toggle green">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                    `;
                }
            }

            row.appendChild(td_buttons);
            add_row_listeners(row);
            results.appendChild(row);
            counter += 1;
        }

        function add_row_listeners(row) {
            const cells = row.querySelectorAll('td')
            const user_id = row.getAttribute('user_id')
            const username = row.getAttribute('username');

            for (let i = 0; i < cells.length; i++) {
                const cell = cells[i];

                if (i == cells.length - 1 && cell.children.length > 0) {
                    break;
                }

                cell.addEventListener('click', function() {
                    window.location.href = "{{get_url($locale,'profile_slug')}}" + '/' + username;
                });
            }

            // assign listeners to the buttons in the row
            const edit = row.querySelector('.edit');
            if (edit) {
                row.querySelector('.edit').addEventListener('click', function() {
                    window.location.href =
                        "{{ route('user_edit', ['locale' => $locale, 'username' => 'null_username']) }}".replace(
                            'null_username', username);
                });
            }

            const reset_img = row.querySelector('.reset_img');
            if (reset_img) {
                reset_img.addEventListener('click', function() {
                    request_reset_img('{{ URL('/ajax/admin/users/reset_img') }}', user_id, row)
                });
            }

            const toggle_ban = row.querySelector('.ban_toggle');
            if (toggle_ban) {
                toggle_ban.addEventListener('click', function() {
                    request_toggle_ban('{{ URL('/ajax/admin/users/toggle_ban') }}', user_id, row)
                });
            }
        }

        //ajax variables
        let counter = 1; //number of rows, incremented when a row is created and wiped on search
        let page = 1;
        let requesting = false;
        let querying = false;
        let search = '';

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

        // on scroll event, when user has reached 50% of the cointainer's height
        document.querySelector('.table_container').addEventListener('scroll', function() {
            if (this.scrollTop >= (this.scrollHeight - this.offsetHeight) * 0.5) {
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
        function request() {
            //means there are no more users for this query
            if (page == -1) { return; }

            console.log('Input value:', search);
            const ajax_data = {
                method: 'POST',
                url: '{{ URL('/ajax/admin/users/request') }}',
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

                    create_rows(response_data['users']); //create the user rows
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
@endsection
