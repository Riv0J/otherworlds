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

    <form class="col-12 col-lg-8 my-3 flex_center flex-column" method="POST" action="{{ route('register', ['locale' => $locale]) }}">
        @csrf

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endForeach
        @endif

        <h4 class="white my-3">@lang('otherworlds.required_data')</h4>

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
            <label class="col-md-4 col-form-label text-md-end white" for="name">
                @lang('otherworlds.username')
            </label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{old('name')}}" autocomplete="name" required autofocus>

                {{-- show username error, if any --}}
                @error('name')
                <span class="invalid-feedback white" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- country --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="email">
                @lang('otherworlds.country')
            </label>
            <div class="col-md-6">
                <select id="select_country" name="country" class="form-select" required>
                    @foreach (App\Models\Country::all() as $country)
                        <option value="{{$country->id}}">
                            <span class="big-icon flag-icon flag-icon-{{$country->code}}"></span>
                            {{$country->name}}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

        <h4 class="white my-3">@lang('otherworlds.password')</h4>

        {{-- pass --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="password">
                @lang('otherworlds.password')
            </label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autofocus>
            </div>
        </div>

        {{-- repeat_password --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="password">
                @lang('otherworlds.repeat_password')
            </label>
            <div class="col-md-6">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autofocus>
            </div>
        </div>

        <h4 class="white my-3">@lang('otherworlds.optional_data')</h4>

        {{-- birth_date --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="birth_date">
                @lang('otherworlds.birth_date')
            </label>
            <div class="col-md-2">
                <input type="date" class="form-control" name="birth_date" autofocus>
            </div>
        </div>

        {{-- buttons --}}
        <div class="col-12 my-4 flex_center">
            <button type="submit" class="app_button">
                @lang('otherworlds.submit')
            </button>
        </div>

        <div class="col-12 col-md-8 my-4 app_border_bottom text-center"></div>

        <div class="flex_center col-md-6 flex_center white">
            <a class="px-2" href="{{route('show_login', ['locale' => $locale])}}">@lang('otherworlds.already_have_account')</a>
        </div>
    </form>
</section>
<style>
    footer{
        display: none;
    }
</style>
{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}"></script>
<script>
    new DynamicSelect('#select_country', {
    placeholder: "@lang('otherworlds.select_country')",
    data: [
        @foreach ($available_countries as $country)
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
