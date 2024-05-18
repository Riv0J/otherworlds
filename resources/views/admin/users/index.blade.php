@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.users') | Otherworlds
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}" />

    <section class="wrapper col-12 col-lg-8">
        <div class="mb-4 p-2 title">
            <div class="d-flex flex-row align-items-center gap-2">
                <i class="fa-solid fa-users"></i>
                <h3>@lang('otherworlds.users')</h3>
                <small class="mx-2">@lang('otherworlds.total'): {{$total}}</small>
            </div>
            <nav class="buttons d-flex flex-row gap-3">
                <i class="fa-solid fa-spinner"></i>
                <a href="{{ route('user_create', ['locale' => $locale]) }}" class="button info" style="border-radius: 0">
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
                        <th></th>
                        <th></th>
                        <th>@lang('otherworlds.username')</th>
                        <th>@lang('otherworlds.email')</th>
                        <th></th>
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

                    show_message(response_data.message)

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

                    show_message(response_data.message)

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
        const loaded_countries = organize_dic({!! json_encode($countries) !!});
        document.addEventListener('DOMContentLoaded', function() {
            create_rows({!! json_encode($users) !!})
        });

        function create_rows(users) {
            users.forEach(user => {
                create_row(user);
            });
        }

        function create_row(user) {
            const role = loaded_roles[user.role_id];
            const country = loaded_countries[user.country_id];
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
            row.innerHTML += `<td class="id text-end">${user.id}</td>`
            // role
            const role_td = document.createElement('td')
            if(role.name != 'user'){
                role_td.innerHTML += `<div class="aligner"><i class="fa-solid ${role.icon}"></i></div>`;
            }
            row.appendChild(role_td);

            // profile_img
            const asset_route = "{{ asset('users') }}" + '/' + user.img;
            row.innerHTML += `<td class="px-0"><div class="profile_img aligner"><img src="${asset_route}"></div></td>`;

            // country
            row.innerHTML += `
                    <td class="text-center px-1">
                        <span class="flag-icon flag-icon-${country.code}" title="${country.name}"></span>
                    </td>
            `;

            // name
            const div = document.createElement('div');
            div.className = "d-flex gap-2";
            if (user.active = 0) {
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
                    const route = "{{ route('user_show', ['locale' => $locale, 'username' => 'null']) }}".replace(
                        '/null', '');
                    window.location.href = route + '/' + username;
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
        let total = 0;
        let current_page = 1;
        let requesting = false;
        let querying = false;

        // on scroll event, when user has reached 75% of the cointainer's height
        document.querySelector('.table_container').addEventListener('scroll', function() {
            if (this.scrollTop >= (this.scrollHeight - this.offsetHeight) * 0.75) {

                if (requesting == false && querying == false) {
                    request();
                } else if (requesting == true) {
                    querying = true;
                }
            }
        });

        function request() {
            if (current_page == -1) {
                //means there are no more places for this query
                return;
            }
            const ajax_data = {
                method: 'POST',
                url: '{{ URL('/ajax/admin/users/request') }}',
                request_data: {
                    _token: '{{ csrf_token() }}',
                    locale: '{{ $locale }}',
                    current_page: current_page,
                },
                before_func: function() {
                    requesting = true;
                    // const ajax_loading = document.getElementById('ajax_loading'); //show #ajax_loading
                    // ajax_loading.style.display = 'flex';
                },
                success_func: function(response_data) {
                    console.log(response_data);
                    current_page = response_data['current_page'];

                    //add the countries to loaded_countries
                    response_data['countries'].forEach(function(country) {
                        if (loaded_countries[country.id] == null) {
                            loaded_countries[country.id] = country;
                        }
                    });

                    create_rows(response_data['users']); //create the user rows
                },
                after_func: function() {
                    //ajax_loading.style.display = 'none'; //hide #ajax_loading
                    request_cooldown();
                }
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
        async function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
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
@endsection
