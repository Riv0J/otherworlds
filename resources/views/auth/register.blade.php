@extends('layout.masterpage')

@section('title')
@lang('otherworlds.register') | Otherworlds
@endsection

@section('description')
@lang('otherworlds.description_register')
@endsection

@section('content')
<div class="spacer mt-5 pt-5"></div>

<section class="row col-12 px-2 px-lg-5 py-2 flex_center">
    <h2 class="semibold text-center display-5 flex_center gap-2 col-12 py-2 white app_bg">
        @lang('otherworlds.register')
    </h2>

    <form class="col-12 col-lg-8 py-5 flex_center flex-column" method="POST" action="{{ route('login') }}">
        @csrf

        {{-- email--}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="email">
                @lang('otherworlds.email')
            </label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email') ?? 'user@gmail.com'}}" required autocomplete="email" autofocus>

                {{-- show email error, if any --}}
                @error('email')
                <span class="invalid-feedback white" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- username --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="username">
                @lang('otherworlds.username')
            </label>
            <div class="col-md-6">
                <input id="username" type="text" class="form-control" name="username" value="{{old('username')}}" autocomplete="username" required autofocus>
            </div>
        </div>

        {{-- pass --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="password">
                @lang('otherworlds.password')
            </label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autofocus>
            </div>
        </div>

        {{-- country --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="email">
                @lang('otherworlds.country')
            </label>
            <div class="col-md-6">
                <select id="select_country" name="country" class="form-select">
                    @foreach (App\Models\Country::all() as $country)
                        <option value="{{$country->id}}">
                            <span class="big-icon flag-icon flag-icon-{{$country->code}}"></span>
                            {{$country->name}}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="col-12 col-md-8 mb-5 mt-4 py-3 app_border_bottom text-center">
            <h3 class="white">@lang('otherworlds.optional_data')</h3>
        </div>

        {{-- age --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="birth_date">
                @lang('otherworlds.birth_date')
            </label>
            <div class="col-md-2">
                <input type="date" class="form-control" name="birth_date" required autofocus>
            </div>
        </div>

    </form>
</section>
<style>
    footer{
        display: none;
    }
</style>
{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('css/selects.css')}}"></link>
<script src="{{asset('js/selects.js')}}"></script>
<script>
    new DynamicSelect('#select_country', {
    placeholder: "@lang('otherworlds.select_country')",
    data: [
        @foreach (App\Models\Country::all() as $country)
        {
            value: {{$country->id}},
            keyword: '{{$country->name}}',
            html: `
                    <span class="big-icon flag-icon flag-icon-{{$country->code}}"></span>
                    {{$country->name}}
            `,

        },
        @endforeach
    ],
});
</script>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
