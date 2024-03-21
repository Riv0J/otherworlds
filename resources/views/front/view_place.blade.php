@extends('layout.masterpage')

@section('title')
{{$place->name}} | Otherworlds
@endsection

@section('description')
@lang('otherworlds.learn_more_about') {{$place->name}}. @lang('otherworlds.category'): {{$place->category->keyword}}({{$place->category->name}}).{{$place->synopsis}}
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')

<section class="bg_black row mt-3 col-12 col-lg-8 px-1 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center white shadows_inline">

    <div class="spacer mt-4 pt-5"></div>

    {{-- title --}}
    <div class="d-flex justify-content-between app_border_bottom mx-3 px-0 pb-2">
        <div class="flex_center gap-4">
            <span class="big-icon flag-icon flag-icon-{{$place->country->code}}" title="{{$place->country->name}}"></span>
            <h3 id="pl_name" class="regular">{{$place->name}}</h3>
        </div>
        <div>
            <h5 class="m-0">favs: {{$place->favorites_count}}</h5>
        </div>
    </div>

    {{-- content body --}}
    <div class="row my-4 p-0 justify-content-between">

        {{-- img container--}}
        <div class="col-12 col-md-6 p-0 border bg_gray p-2 pb-4">
            <div class="img_container img_gradient_bottom img_gradient_top text-center">
                <img src="{{asset('img/places/'.$place->id.'/t.png')}}" alt="{{$place->name}} @lang('otherworlds.thumbnail')">
            </div>
            <p class="text-center my-2">{{$place->synopsis}}.</p>

            <div class="div_h div_gray mx-2 my-4"></div>

            {{-- place stats start--}}
            <div class="row p-0 m-0">
                <div class="col-4 d-flex flex-column align-items-end gap-1 text-end">
                    <small>@lang('otherworlds.country'):</small>
                    <small>@lang('otherworlds.category'):</small>
                    <small>@lang('otherworlds.views'):</small>
                    <small>@lang('otherworlds.date_added'):</small>
                    <small>@lang('otherworlds.source'):</small>
                </div>
                <div class="col-8 d-flex flex-column align-items-start gap-1">
                    <small class="flex_center gap-2"><span class="flag-icon flag-icon-{{$place->country->code}}"></span>{{$place->country->name}}</small>
                    <small>{{$place->category->keyword}} ({{$place->category->name}})</small>
                    <small>{{$place->views_count}}</small>
                    <small>{{$place->created_at->format('d-m-Y')}}</small>
                    <small><a class="px-2" href="{{$place->source}}" target="_blank">{{$place->name}}</a></small>
                </div>
            </div>
            {{-- place stats end--}}

        </div>

        {{-- sinopsis --}}
        <div class="col-12 col-md-6 p-0 ml-2">

            <p class="rounded-4 px-3 py-2">{{$place->description}}</p>
            <a class="btn" href="{{route('places')}}"><button>@lang('return')</button></a>
            <a class="btn" href="{{$place->source}}" target="_blank"><button>@lang('source')</button></a>
            <div class="div_h mr-2"></div>

        </div>

    </div>

</section>
<style>
    .img_gradient_top{
        position: relative;
    }
    .img_gradient_top::before,.img_gradient_bottom::after{
        content: '';
        position: absolute;
        width: 100%;
        height: 12%;
        left: 0;
    }
    .img_gradient_top::before{
        top: 0;
        background: linear-gradient(180deg, rgb(46, 43, 52) 10%, rgba(46, 43, 52,0.5) 50%,  rgba(46, 43, 52,0) 70%);
    }
    .img_gradient_bottom::after{
        bottom: 0;
        background: linear-gradient(0deg, rgb(46, 43, 52) 10%, rgba(46, 43, 52,0.5) 50%,  rgba(46, 43, 52,0) 70%);
        z-index: 1000;
    }
    #pl_name{
        scale: 1 1.1;
        letter-spacing: 0.1rem;
    }
    .shadows_inline{
        box-shadow: 10px 0 10px rgba(0, 0, 0, 0.5), -10px 0 10px rgba(0, 0, 0, 0.5);
    }
    .img_icon{
        width: 2.5rem;
        aspect-ratio: 1;
    }
    .app_bg_overlay{
        position: relative;
    }
    .app_bg_overlay::before{
        content: '';
        display: block;
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(255, 255, 255, 0.01) 30%, var(--main_dark_bg_color) 65%);
        outline: 1px solid var(--main_dark_bg_color);
        scale: 1.01 1;
    }
</style>
@endsection

@section('script')


@endsection
