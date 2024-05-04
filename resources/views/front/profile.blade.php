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
    <div class="spacer mt-4 pt-5"></div>

    <div class="mb-4 title">
        <div class="d-flex flex-row align-items-end gap-4">
            <div class="profile_img" style="background-color: gray;">
                <img src="{{asset('img/users/'.$user->img)}}" style="width: 5rem;" alt="@lang('otherworlds.user_image')">
            </div>
            <div class="d-flex flex-column justify-content-between">
                <h3 class="regular pb-2">{{$user->name}}</h3>
                <h5>
                    <span class="flag-icon flag-icon-{{$user->country->code}}" title="{{$user->country->name}}"></span>
                    {{$user->country->name}}
                </h5>
            </div>
        </div>

        <nav class="buttons d-flex flex-row">

            {{-- #edit_button START--}}
            @if($owner == true)
                <button title='@lang('otherworlds.edit')' id="edit_button" class="button info">
                    <i class="fa-regular fa-pen-to-square" style="translate: 2% -5%"></i>
                </button>
            @endif
            {{-- #edit_button END--}}
        </nav>
    </div>

    <h4 class="mb-4 semibold">
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
<style>

</style>
@endsection

@section('script')
{{-- #edit_button onclick --}}
@if($owner == true)
<script>
    document.querySelector('#edit_button').addEventListener('click',function(){
    });
</script>
@endif

@endsection
