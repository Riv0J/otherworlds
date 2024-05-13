@extends('layout.masterpage')

@section('title')
@lang('otherworlds.users') | Otherworlds
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}"/>

<section class="wrapper col-12 col-lg-8">
    <div class="mb-4 p-2 title">
        <div class="d-flex flex-row align-items-end gap-4">
            <h3>@lang('otherworlds.users')</h3>
            <small>@lang('otherworlds.results'): {{count($users)}}</small>
        </div>
        <nav class="buttons d-flex flex-row">
            <a href="{{route('user_create',['locale'=>$locale])}}" class="button info" style="border-radius: 0">
                <i class="fa-regular fa-add"></i>@lang('otherworlds.create_user')
            </a>
        </nav>
    </div>


    <div class="table_container">
        <table class="results_table">
            <thead>
                <tr>
                    <th>@lang('otherworlds.role')</th>
                    <th></th>
                    <th></th>
                    <th>@lang('otherworlds.username')</th>
                    <th>@lang('otherworlds.email')</th>
                    <th>@lang('otherworlds.favorites')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr {{$user->id == $logged->id ? 'you' : ''}} user_id="{{$user->id}}" username='{{$user->name}}' active="{{$user->active ? 'true' : 'false'}}" role="{{$user->role->name}}" title="Role: {{$user->role->name}}, User Id: {{$user->id}}">
                    <td>
                        <div class="aligner">
                            @if(!$user->is_public())
                                <i class="fa-solid {{$user->role->icon}}"></i>
                            @endif
                        </div>
                    </td>
                    <td class="profile_img"><img src="{{asset('users/'.$user->img)}}"></td>
                    <td class="text-center px-1">
                        <span class="flag-icon flag-icon-{{$user->country->code}}" title="{{$user->country->name}}"></span>
                    </td>
                    <td class="name_td">
                        <div class="d-flex gap-2">
                            @if($user->active == false)
                            <i class="fa-solid fa-ban" style="color: red"></i>
                            @endif
                            {{$user->name}}
                            {{$user->id == $logged->id ? '[YOU]' : ''}}
                        </td>
                        </div>

                    <td>{{$user->email}}</td>
                    <td class="text-end">{{$user->favorites->count()}}</td>
                    <td>
                        @if($user->is_editable($logged) && $user->id != $logged->id)

                        <div class="aligner">
                            <button class="edit yellow">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="reset_img red">
                                <i class="fa-solid fa-camera-rotate"></i>
                            </button>
                            @if($user->active)
                                <button class="ban_toggle red">
                                    <i class="fa-solid fa-ban"></i>
                                </button>
                            @else
                                <button class="ban_toggle green">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</section>
<style>
    .aligner{
        display: flex;
        justify-content: center;
        align-items: center
    }
    .aligner i{
        font-size: 1.25rem;
        width: 1.25rem;
    }
    td button{
        background-color: transparent;
        border: none;
        padding: 0.5rem;
    }
    .red:hover{
        color: red;
    }
    .green:hover{
        color: var(--green_light);
    }
    .yellow{
        color: white;
    }
    .yellow:hover{
        color: var(--yellow_bright);
    }
    table{
        border: 1px solid white;
    }
    td.profile_img{
        padding: 0;
    }
    td img{
        width: 3rem;
        margin: 0.5rem
    }
    th, td{
        padding: 0 0.5rem;
        border-top: 1px solid white;
    }
    tr{
        cursor: pointer;
    }
    tbody>tr:hover{
        background-color: var(--gray_opacity);
    }
    tr[you]{
        border: 2px solid red;
    }
    tr[role="admin"]{
        border-left: 4px solid var(--green_light);
    }
    tr[role="owner"]{
        border-left: 4px solid var(--purple_light);
    }
    tr[active="false"]{
        position: relative;
    }
    tr[active="false"]::after{
        content: '';
        position: absolute;
        inset: 0;
        background-color: var(--gray_opacity);
        pointer-events: none;
    }

</style>
@endsection

@section('script')
<script src="{{asset('js/ajax.js')}}"></script>
<script>

    document.querySelectorAll('tbody tr').forEach(row => {
        add_listeners(row);
    });

    function add_listeners(row){
        const cells = row.querySelectorAll('td')
        const user_id = row.getAttribute('user_id')
        const username = row.getAttribute('username');

        for (let i = 0; i < cells.length; i++) {
            const cell = cells[i];

            if(i == cells.length-1 && cell.children.length>0){
                break;
            }

            cell.addEventListener('click' , function(){
                const route = "{{ route('user_show', ['locale' => $locale, 'username' => 'null']) }}".replace('/null', '');
                window.location.href = route+'/'+username;
            });


        }

        // assign listeners to the buttons in the row
        const edit = row.querySelector('.edit');
        if (edit) {
            row.querySelector('.edit').addEventListener('click', function() {
                window.location.href = "{{route('user_edit',['locale'=>$locale,'username'=>'null_username'])}}".replace('null_username',username);
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

                if(response_data.user != null){
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

                if(response_data.user != null){
                    refresh_row(row, response_data.user)
                }

            },
            after_func: function() {}
        };

        ajax(ajax_data);
    }
    function refresh_row(row, user){
        console.log(user);
        row.querySelector('.profile_img img').setAttribute('src', "{{asset('users/null_img')}}".replace('null_img',user.img));


        const ban_button = row.querySelector('.ban_toggle');
        const ban_i = row.querySelector('.ban_toggle i');
        const name_container = row.querySelector('.name_td div')
        if(user.active == 1){
            ban_button.className = "ban_toggle red";
            ban_i.className = "fa-solid fa-ban";
            name_container.innerHTML = user.name;
            row.setAttribute('active', true);
        } else {
            ban_button.className = "ban_toggle green";
            ban_i.className = "fa-solid fa-rotate-left";
            row.setAttribute('active', false);
            name_container.innerHTML = '<i class="fa-solid fa-ban" style="color: red"></i>'+user.name

        }
    }
</script>
@endsection
