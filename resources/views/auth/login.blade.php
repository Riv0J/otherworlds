@extends('layout.masterpage')

@section('title')
@lang('otherworlds.sign_in') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.description_login')
@endsection

@section('content')
<div class="spacer mt-5 pt-5"></div>

<section class="row col-12 px-2 px-lg-5 py-2 flex_center">

    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2 app_bg">
        @lang('otherworlds.sign_in')
    </h2>

    <form id="login_form" class="col-12 col-lg-8 py-5 flex_center flex-column" method="POST" action="{{ route('login', ['locale' => $locale]) }}">
        @csrf

        <div class="row col-12 mb-4">
            <fieldset class="flex_center gap-3 offset-md-4 col-md-6">
                <label for="email">
                    Logins
                </label>

                <div class="flex_center gap-2">
                    <button type="button" class="app_button" onclick="login('guest@gmail.com', 'guest')">
                        Guest
                    </button>
                </div>
            </fieldset>
        </div>
        <script>
            function login(email, password){
                document.querySelector('input[name="email"]').value = email;
                document.querySelector('input[name="password"]').value = password;
                document.getElementById('login_form').submit();
            }
        </script>

        {{-- login email --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end" for="email">
                @lang('otherworlds.email')
            </label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" required autocomplete="email" autofocus>

                {{-- show email error, if any --}}
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- login pass --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end" for="password" >
                @lang('otherworlds.password')
            </label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="">

                {{-- show pass error, if any --}}
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- remember me check --}}
        <div class="row col-12 mb-3">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input style="scale: 1.3; cursor: pointer;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        @lang('otherworlds.remember_me')
                    </label>
                </div>
            </div>
        </div>

        {{-- buttons --}}
        <div class="row col-12 mb-3">

            <div class="flex_center col-md-6 offset-md-4 gap-5 pb-4 app_border_bottom">
                <button type="submit" class="app_button">
                    @lang('otherworlds.login')
                </button>
            </div>
            <div class="flex_center col-md-6 offset-md-4 flex_center my-3 gap-2">
                <a class="px-2" href="{{get_url($locale,'register_slug')}}">@lang('otherworlds.im_not_registered')</a>
            </div>
        </div>

    </form>
</section>

@endsection
