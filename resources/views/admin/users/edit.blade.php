@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.edit_profile') | Admin {{ config('app.name') }}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{asset('css/forms.css')}}">
    <form action="{{ route('user_delete', ['locale'=>$locale]) }}" method="POST" id="delete_user_form">
        @csrf @method('DELETE')
        <input type="hidden" name="user_id" value="{{$user->id}}">
    </form>
    <form class="wrapper col-12 col-lg-8" method="POST" enctype="multipart/form-data" action="{{ route('user_update', ['locale' => $locale]) }}">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        @csrf
        <div class="title">
            <div class="text">
                <i class="fa-regular fa-pen-to-square"></i>
                <h3 class="regular">@lang('otherworlds.edit_profile')</h3>
            </div>
            <nav class="buttons">
                <button type="submit" class="button square info">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
                <button type="button" class="button square red" id="delete_user">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </nav>
        </div>

        <fieldset class="mb-4">
            <h4 class="form_h4">
                <i class="ri-arrow-right-s-line"></i>
                <span>@lang('otherworlds.admin_data')</span>
            </h4>
            <span> You can edit these fields because you are [{{strtoupper($logged->role->name)}}]</span>

            {{-- active --}}
            <div class="row col-12 my-3">
                <label class="col-md-4 col-form-label text-md-end white" for="active">
                    @lang('otherworlds.active')*
                </label>
                <div class="col-md-6 d-flex align-items-center gap-3">
                    <input type="checkbox" name="active"
                    @if($user->active == true)
                        checked
                    @endif
                    >
                    <small>(Uncheck to ban)</small>
                </div>
            </div>

            {{-- role --}}
            <div class="row col-12 mb-3">
                <label class="col-md-4 col-form-label text-md-end white" for="birth_date">
                    @lang('otherworlds.role')*
                </label>
                <div class="col-md-2 d-inline-flex">
                    <select class="p-2 p-md-0" name="role" required>

                        @if($user->role->name == 'owner')
                            <option value="{{$user->role->id}}" selected>OWNER</option>
                        @else
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}"
                                    @if ($user->role->name == $role->name)
                                    selected
                                    @endif
                                >
                                    {{strtoupper($role->name)}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            {{-- email --}}
            <div class="row col-12 mb-3">
                <label class="col-md-4 col-form-label text-md-end white" for="email">
                    @lang('otherworlds.email')*
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="{{$user->email}}" name="email" required>
                </div>
            </div>

            {{-- password --}}
            <div class="row col-12 mb-3">
                <label class="col-md-4 col-form-label text-md-end white" for="password">
                    @lang('otherworlds.password')
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="" placeholder="* * * * * * * *" name="password">
                </div>
            </div>
        </fieldset>

        <h4 class="form_h4">
            <i class="ri-arrow-right-s-line"></i>
            <span>@lang('otherworlds.required_data')</span>
        </h4>

        {{-- username --}}
        <div class="row col-12 mb-3">
            <label class="col-md-4 col-form-label text-md-end white" for="name">
                @lang('otherworlds.username')*
            </label>
            <div class="col-md-6">
                <input type="text" class="form-control" value="{{$user->name}}" autocomplete="name" name="name" required autofocus>

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
                @lang('otherworlds.country')*
            </label>
            <div class="col-md-6">
                <select id="select_country" class="form-select" name="country_id" required></select>
            </div>
        </div>

        <h4 class="form_h4">
            <i class="ri-arrow-right-s-line"></i>
            <span>@lang('otherworlds.optional_data')</span>
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
            <label class="col-md-4 col-form-label text-md-end white" for="profile_img">
                @lang('otherworlds.profile_img')
            </label>
            <div class="col-md-6 d-flex flex-row gap-3">
                <div class="profile_img" style="width: min-content">
                    <img id="preview_img" src="{{asset('users/'.$user->img)}}" style="aspect-ratio: 1; width: 5rem;" alt="@lang('otherworlds.profile_img')">
                </div>
                <div class="custom-file d-inline-flex flex-column gap-3">
                    <input type="file" class="custom-file-input" id="profile_img" name="profile_img">
                    <label class="custom-file-label button border" style="cursor:pointer" for="profile_img">
                        @lang('otherworlds.select_image')
                    </label>
                    <a href="{{route('reset_img',['locale'=>$locale, 'user_id' => $user->id])}}" class="red custom-file-label button border" style="cursor:pointer">
                        <i class="fa-solid fa-trash"></i>
                    </a>
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

        <div class="div_h div_gray my-4"></div>

        {{-- form buttons --}}
        <div class="d-flex justify-content-center gap-3">
            <button type="button" class="button border red" onclick="window.history.back()">
                @lang('otherworlds.cancel')
            </button>
            <button type="submit" class="button border info">
                <i class="fa-solid fa-floppy-disk"></i>
                @lang('otherworlds.save_changes')
            </button>
        </div>

    </form>

    {{-- return START --}}
    <a href="{{route("user_index",['locale'=>$locale])}}" id="return" class="button d-none d-lg-flex button info border">
        <i class="fa-solid fa-angles-left"></i>
    </a>
    <style>
        #return {
            position: fixed;
            top: 50%;
            left: 10%
        }
    </style>
    {{-- return END --}}
@endsection

@section('script')
{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}"></script>
<script>
    const countries = {!! json_encode($countries) !!};
    const dynamic_select_data = [];

    for (let index = 0; index < countries.length; index++) {
        const country = countries[index];

        // add to dynamic_select_data
        dynamic_select_data.push({
            value: country.id,
            keyword: country.name,
            html: `<span class="medium_i flag-icon flag-icon-${country.code}"></span>
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

    document.querySelector('#delete_user').addEventListener('click', function(){
        const modal_data = {
            'icon': 'danger',
            'title': '@lang('otherworlds.confirm_delete_user_title')',
            'body': '@lang('otherworlds.confirm_delete_user_body')',
            'cancel': '@lang('otherworlds.cancel')',
            'confirm': '@lang('otherworlds.confirm')',
            // 'input_config': {
            //     type: "text",
            //     placeholder: 'Place my holder',
            //     label: 'Hold my Label'
            // },
            'on_confirm': function(input_value){
                document.querySelector('#delete_user_form').submit()
            }
        }
        show_modal('confirm', modal_data)
    })

</script>
@endsection
