@extends('layout.masterpage')

@section('title')
@lang('otherworlds.sign_in') | Otherworlds
@endsection

@section('content')
<div class="spacer mt-3 pt-5"></div>

<section class="row col-12 px-2 px-lg-5 py-2 flex_center">

    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2">
        @lang('otherworlds.sign_in')
    </h2>

    <form class="col-12 col-lg-8 py-5" method="POST" action="{{ route('login') }}">
        @csrf

        {{-- login email --}}
        <div class="row col-12 justify-content-start mb-3">
            <label class="col-md-4 col-form-label text-md-end" for="email">
                @lang('otherworlds.email')
            </label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? 'user@gmail.com'}}" required autocomplete="email" autofocus>

                {{-- show email error, if any --}}
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        {{-- login pass --}}
        <div class="row col-12 justify-content-start mb-3">
            <label class="col-md-4 col-form-label text-md-end" for="password" >
                @lang('otherworlds.password')
            </label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="user">

                {{-- show pass error, if any --}}
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input style="scale: 1.3;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
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

        <style>
            .app_button{
                position: relative;

                font-size: 1.25rem;
                font-weight: 700;
                letter-spacing: 0.15rem;

                border: 0;
                border-radius: 2rem;
                padding-inline: 1.5rem;
                padding-block: 0.3rem;
                color: black;
                isolation: isolate;
                overflow: hidden;
                background-color: var(--main);
                color: var(--black);


                transition: all 0.75s;
            }
            .app_button::after{
                content: '';
                position: absolute;
                inset: 100%;
                width: 100%;
                aspect-ratio: 1;
                border-radius: 50%;

                background-color: var(--main_dark);
                z-index: -1;
                transition: all 0.75s;
            }
            .app_button:hover{
                color: var(--white);
                background-color: var(--main_dark);
            }
            .app_button:hover::after{
                scale: 5;
            }
        </style>
    </form>
</section>



{{-- <div class="container header_offset">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
