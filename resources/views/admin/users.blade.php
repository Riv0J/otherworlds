@extends('layout.masterpage')

@section('title')
@lang('otherworlds.users') | Otherworlds
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}"/>

<section class="wrapper col-12 col-lg-8">
    <div class="mb-4 title">
        <div class="d-flex flex-row align-items-end gap-4">
            <h3 class="regular pb-2">@lang('otherworlds.users')</h3>
        </div>

        <nav class="buttons d-flex flex-row">
            <button title='@lang('otherworlds.edit')' id="edit_button" class="button info" style="border-radius: 0">
                Example<i class="fa-regular fa-pen-to-square"></i>
            </button>
        </nav>
    </div>

    <small>Results: {{count($users)}}</small>
    <div class="table_container">
        <table class="results_table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Favorites</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr role="{{$user->role->name}}" title="Role: {{$user->role->name}}, User Id: {{$user->id}}" onclick="visit('{{$user->name}}')">
                    <td class=>
                        @if($user->is_owner())
                        <i class="fa-solid fa-crown"></i>
                        @elseif ($user->is_admin())
                        <i class="fa-solid fa-user-astronaut"></i>
                        @endif
                    </td>
                    <td class="profile_img"><img src="{{asset('users/'.$user->img)}}"></td>
                    <td class="text-center px-1">
                        <span class="flag-icon flag-icon-{{$user->country->code}}" title="{{$user->country->name}}"></span>
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class="text-end">{{$user->favorites->count()}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</section>
<style>
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
    tr[role="admin"]{
        border-left: 4px solid var(--green_light);
    }
    tr[role="owner"]{
        border-left: 4px solid var(--purple_light);
    }

</style>
@endsection

@section('script')
<script>
    function visit(username){
        const route = "{{ route('user_show', ['locale' => $locale, 'username' => 'null']) }}".replace('/null', '');
        window.location.href = route+'/'+username;
    }
</script>
@endsection
