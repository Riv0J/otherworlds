@extends('layout.masterpage')

@section('title')
@lang('otherworlds.sign_in') | Otherworlds
@endsection

@section('content')
<div class="spacer mt-5 pt-5"></div>

<section class="row col-12 px-2 px-lg-5 py-2 flex_center">

    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2 white app_bg">
        @lang('otherworlds.sign_in')
    </h2>

    <form class="col-12 col-lg-8 py-5" method="POST" action="{{ route('login') }}">
        @csrf

        {{-- login email --}}
        <div class="row col-12 justify-content-start mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="email">
                @lang('otherworlds.email')
            </label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? 'user@gmail.com'}}" required autocomplete="email" autofocus>

                {{-- show email error, if any --}}
                @error('email')
                <span class="invalid-feedback white" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        {{-- login pass --}}
        <div class="row col-12 justify-content-start mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="password" >
                @lang('otherworlds.password')
            </label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="user">

                {{-- show pass error, if any --}}
                @error('password')
                <span class="invalid-feedback white" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input style="scale: 1.3;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label white" for="remember">
                        @lang('otherworlds.remember_me')
                    </label>
                </div>
            </div>
        </div>

        {{-- buttons --}}
        <div class="flex_center pb-3">
            <button type="submit" class="app_button">
                @lang('otherworlds.login')
            </button>
        </div>

    </form>
</section>
<style>
    footer{
        display: none;
    }
</style>

@endsection
