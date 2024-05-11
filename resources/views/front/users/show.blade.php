@extends('layout.masterpage')

@section('title')
@lang('otherworlds.profile') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.visit_user_profile',['username' => $user->name]) | Otherworlds
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/place_index.css') }}"/>

<section class="wrapper col-12 col-lg-8">
    <div class="mb-4 pb-3 title">
        <div class="d-flex flex-row align-items-end gap-4">
            <div class="profile_img">
                <img src="{{asset('users/'.$user->img)}}" style="width: 5rem;" alt="@lang('otherworlds.user_image')">
            </div>
            <div class="d-flex flex-column justify-content-between">
                <h3 class="regular pb-2 d-inline-flex gap-2">
                    @if($user->is_owner())
                    <i class="fa-solid fa-crown"></i>
                    @elseif ($user->is_admin())
                    <i class="fa-solid fa-user-astronaut"></i>
                    @endif
                    {{$user->name}}
                </h3>
                <h5 class="d-inline-flex gap-2">
                    <span class="flag-icon flag-icon-{{$user->country->code}}" title="{{$user->country->name}}"></span>
                    {{$user->country->name}}
                </h5>
            </div>
        </div>

        <nav class="buttons d-flex flex-row">

            {{-- #edit_button START--}}
            @if($can_edit)
                @if($logged->is_public())
                <a title='@lang('otherworlds.edit')' href="{{route('profile_edit', ['locale' => $locale])}}" id="edit_button" class="button info">

                @else
                <a title='@lang('otherworlds.edit')' href="{{route('user_edit', ['locale' => $locale, 'username' => $user->name])}}" id="edit_button" class="button info">

                @endif
                    @if($logged->is_owner())
                        Owner edit
                    @elseif($logged->is_admin())
                        Admin edit
                    @endif
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>

            @endif
            {{-- #edit_button END--}}
        </nav>
    </div>

    <h4 class="mb-4 semibold d-flex">
        <i class="ri-arrow-right-s-line"></i>
        <span class="mx-1">@lang('otherworlds.favorite_places')</span>
    </h4>

    @include('components.places_container')

</section>
    {{-- return START--}}
    <button title="@lang('otherworlds.return')" id="return" class="d-none d-lg-flex button info border" onclick="window.history.back()">
        <i class="fa-solid fa-angles-left"></i>
    </button>
    <style>
        #return{
            position: fixed;
            top: 50%;
            left: 10%
        }
    </style>
    {{-- return END --}}
@endsection
