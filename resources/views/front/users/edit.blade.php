@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.edit_profile') | Otherworlds
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <form class="wrapper col-12 col-lg-8" method="POST" enctype="multipart/form-data" action="{{ route('user_update', ['locale' => $locale]) }}">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        @csrf
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

        {{-- email--}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="email">
                @lang('otherworlds.email')
            </label>
            <div class="col-md-6">
                <input type="email" class="form-control" value="{{$user->email}}" readonly>
            </div>
        </div>

        {{-- username --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="name">
                @lang('otherworlds.username')
            </label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{$user->name}}" autocomplete="name" required autofocus>

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
                <select id="select_country" name="country_id" class="form-select" required></select>
            </div>
        </div>

        <h4 class="mb-4 semibold d-flex">
            <i class="ri-arrow-right-s-line"></i>
            <span class="mx-1">@lang('otherworlds.optional_data')</span>
        </h4>

        {{-- birth_date --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="birth_date">
                @lang('otherworlds.birth_date')
            </label>
            <div class="col-md-2">
                <input type="date" class="form-control" name="birth_date" autofocus value="{{ $user->birth_date }}">
            </div>
        </div>

        {{-- profile_img --}}
        <div class="row col-12 mb-5">
            <label class="col-md-4 col-form-label text-md-end white" for="birth_date">
                @lang('otherworlds.profile_img')
            </label>
            <div class="col-md-2 d-flex flex-row gap-3">
                <div style="background-color: gray; width: min-content">
                    <img id="preview_img" src="{{asset('users/'.$user->img)}}" style="aspect-ratio: 1; width: 5rem;" alt="@lang('otherworlds.user_image')">
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_img" name="profile_img">
                    <label class="custom-file-label button border" style="cursor:pointer" for="profile_img">@lang('otherworlds.select_image')</label>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('profile_img').addEventListener('change', function(event) {
                var input = event.target;
                var reader = new FileReader();

                reader.onload = function() {
                    var dataURL = reader.result;
                    var imgElement = document.getElementById('preview_img');
                    console.log(imgElement);
                    imgElement.src = dataURL;
                };

                reader.readAsDataURL(input.files[0]);
            });
        </script>

        {{-- form buttons --}}
        <div class="d-flex justify-content-center gap-3">
            <button class="button border">
                @lang('otherworlds.cancel')
            </button>
            <button type="submit" class="button border">
                @lang('otherworlds.update_changes')
            </button>
        </div>

    </form>

    {{-- return START --}}
    <button title="@lang('otherworlds.return')" id="return" class="d-none d-lg-flex button info border"
        onclick="window.history.back()">
        <i class="fa-solid fa-angles-left"></i>
    </button>
    <style>
        #return {
            position: fixed;
            top: 50%;
            left: 10%
        }
    </style>
    {{-- return END --}}

    <style>
        input[readonly] {
            background-color: #c2c2c2;
            pointer-events: none;
        }
        input[type="file"]{
            display: none;
        }
    </style>
@endsection

@section('script')
{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}"></script>
<script>
    const available_countries = {!! json_encode($available_countries) !!};
    const dynamic_select_data = [];

    for (let index = 0; index < available_countries.length; index++) {
        const country = available_countries[index];

        // add to dynamic_select_data
        dynamic_select_data.push({
            value: country.id,
            keyword: country.name,
            html: `
                <span class="big-icon flag-icon flag-icon-${country.code}"></span>
                ${country.name}
            `
        });
    }

    const select = new DynamicSelect('#select_country', {
        placeholder: "@lang('otherworlds.select_country')",
        data: dynamic_select_data
    });

    @if($user->country)
        select.select_option({{$user->country->id}})
    @endif
</script>
@endsection
