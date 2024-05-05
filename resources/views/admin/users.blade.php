@extends('layout.masterpage')

@section('title')
@lang('otherworlds.users') | Otherworlds
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}"/>

<section class="wrapper col-12 col-lg-8">
    <div class="spacer mt-4 pt-5"></div>

    <div>
        <h4 class="mb-4 semibold d-flex">
            <i class="ri-arrow-right-s-line"></i>
            <span class="mx-1">@lang('otherworlds.users')</span>
        </h4>

    </div>

    <small>Results: {{count($users)}}</small>
    <div class="table_container">

        <table class="results_table">

            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Favorites</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr role="{{$user->role->name}}" title="User Id = {{$user->id}}" onclick="visit('{{$user->name}}')">
                    <td>
                        @if($user->is_owner())
                        <i class="fa-solid fa-crown"></i>
                        @elseif ($user->is_admin())
                        <i class="fa-solid fa-user-astronaut"></i>
                        @endif
                    </td>
                    <td class="text-center px-0">
                        <span class="flag-icon flag-icon-{{$user->country->code}}" title="{{$user->country->name}}"></span>
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class="text-end">{{$user->favorites->count()}}</td>
                    <td>{{$user->role->name}}</td>
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
    th, td{
        padding: 0.5rem;
        border-top: 1px solid white;
    }
    tr{
        cursor: pointer;
    }
    tr:hover{
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
        const route = "{{ route('profile', ['locale' => $locale, 'username' => 'null']) }}".replace('/null', '');
        window.location.href = route+'/'+username;
    }
</script>
@endsection
