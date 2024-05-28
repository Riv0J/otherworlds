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
                <button type="submit" class="button square border info">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </nav>
        </div>
        <div class="form_line">
            <label for="name">@lang('otherworlds.place_name')</label>
            <input type="text" name="name">
        </div>
        <div class="form_line">
            <label for="name">@lang('otherworlds.gallery_url')</label>
            <input type="text" name="gallery_url" placeholder="@lang('otherworlds.wikimedia_url')">
        </div>
        <div class="form_line">
            <label for="synopsis">@lang('otherworlds.synopsis')</label>
            <textarea name="synopsis"></textarea>
        </div>
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
        <style>
            input, textarea{
                background-color: transparent;
                border: 1px solid gray;
                border-radius: 0.5rem;
                padding: 0.25rem 0.75rem;
                min-height: 2.5rem;
            }
            /* input:focus{
                outline: none
            } */
            .form_line{
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                margin-bottom: 1rem;
            }
            .dynamic_select_container{
                max-width: 300px
            }
        </style>

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
