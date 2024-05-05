@extends('layout.masterpage')

@section('title')
@lang('otherworlds.edit_profile') | Otherworlds
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')
<form class="wrapper col-12 col-lg-8">
    <div class="mb-4 title">
        <div class="d-flex flex-row align-items-end gap-4">
            <h3 class="regular pb-2">@lang('otherworlds.edit_profile')</h3>
        </div>

        <nav class="buttons d-flex flex-row">
        </nav>
    </div>

    <h4 class="mb-4 semibold d-flex">
        <i class="ri-arrow-right-s-line"></i>
        <span class="mx-1">@lang('otherworlds.required_data')</span>
    </h4>
    <h4 class="mb-4 semibold d-flex">
        <i class="ri-arrow-right-s-line"></i>
        <span class="mx-1">@lang('otherworlds.optional_data')</span>
    </h4>

    {{-- buttons --}}
    <div class="d-flex justify-content-center gap-3">
        <button class="app_button">
            @lang('otherworlds.cancel')
        </button>
        <button type="submit" class="app_button">
            @lang('otherworlds.submit')
        </button>
    </div>
</form>
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

@endsection
