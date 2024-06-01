@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.create_place') | Admin {{config('app.name')}}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}"/>
    <form class="wrapper col-12 col-lg-10" method="POST" enctype="multipart/form-data" action="{{ route('place_store', ['locale' => $locale]) }}">
        <div class="title">
            <div class="text">
                <i class="fa-solid fa-panorama"></i>
                <h3>@lang('otherworlds.create_place')</h3>
            </div>

            <nav class="buttons">
                <i class="fa-solid fa-spinner"></i>
                {{-- <button type="button" class="button square border red" onclick="window.history.back();">
                    <i class="fa-solid fa-angles-left"></i>
                </button> --}}
                <button type="submit" class="button square border info">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </nav>
        </div>

        {{-- country & category --}}
        <div class="form_row">
            <div class="form_line">
                <label for="name">@lang('otherworlds.country')</label>
                <div class="dynamic_select_container">
                    <select id="select_country" name="country" required></select>
                </div>
            </div>
            <div class="form_line">
                <label for="name">@lang('otherworlds.category')</label>
                <div class="dynamic_select_container">
                    <select id="select_category" name="category" required></select>
                </div>
            </div>
        </div>

        {{-- name --}}
        <div class="form_line">
            <label for="name">@lang('otherworlds.place_name')</label>
            <input type="text" name="name">
        </div>

        {{-- gallery_url --}}
        <div class="form_line">
            <label for="name">@lang('otherworlds.gallery_url')</label>
            <input type="text" name="gallery_url" placeholder="@lang('otherworlds.wikimedia_url')">
        </div>

        {{-- synopsis --}}
        <div class="form_line">
            <label for="synopsis">@lang('otherworlds.synopsis')</label>
            <textarea name="synopsis"></textarea>
        </div>
    </form>
@endsection

@section('script')
{{-- dynamic select assets --}}
<link rel="stylesheet" href="{{asset('dynamic_selects/dynamic_selects.css')}}"></link>
<script src="{{asset('dynamic_selects/dynamic_selects.js')}}"></script>
<script>
    const countries = organize_dic({!! json_encode($countries) !!});
    const categories = organize_dic({!! json_encode($categories) !!});

    const countries_select_data = [
        {
            value: 0,
            keyword: '@lang('otherworlds.all')',
            html: `
                <div class="aligner gap-2">
                    <i class="fa-solid fa-location-dot"></i>
                    @lang('otherworlds.all')
                </div>
            `
        }
    ];

    Object.values(countries).forEach(function(country){
        countries_select_data.push({
            value: country.id,
            keyword: country.name,
            html: `
                <span class="big-icon flag-icon flag-icon-${country.code}"></span>
                ${country.name}
            `
        });
    })

    const select = new DynamicSelect('#select_country', {
        placeholder: "@lang('otherworlds.select_country')",
        data: countries_select_data
    });

    select.select_option('0')

    const categories_select_data = [
        {
            value: 0,
            keyword: '@lang('otherworlds.all')',
            html: `
                <div class="aligner gap-2">
                    <i class="fa-regular fa-circle"></i>
                    @lang('otherworlds.all')
                </div>
            `
        }
    ];

    Object.values(categories).forEach(function(cat){
        categories_select_data.push({
            value: cat.id,
            keyword: cat.keyword,
            html: `
                <div class="aligner gap-2">
                    <i class="small_i fa-solid fa-${cat.img_name}"></i>
                        ${cat.keyword}
                </div>
            `
        });
    });
    const select2 = new DynamicSelect('#select_category', {
        placeholder: "@lang('otherworlds.select_category')",
        data: categories_select_data
    });

    select2.select_option('0')
</script>
@endsection
