@extends('layout.masterpage')

@section('title')
{{$place->name}} | Otherworlds
@endsection

@section('content')
<div class="spacer mt-3 pt-5"></div>

<section class="row col-12 px-1 px-lg-4 py-3 flex-column flex-md-row justify-content-center">
    <div class="row col-8 col-md-6">
        <div class="col-12 my-3 d-flex justify-content-between">
            <h3>
                {{$place->name}}
            </h3>
            <p class="flex_center gap-2">
                <i class="ri-map-pin-line"></i>{{$place->country->name}}
            </p>
        </div>
        <img class="col-12" src="{{asset('img/places/'.$place->id.'/t.png')}}" alt="">
    </div>

    <div class="col-8 col-md-6 mt-md-3">
        <p class="border rounded-4 px-3 py-2">{{$place->description}}</p>
        <a class="btn" href="{{route('places')}}"><button>@lang('return')</button></a>
    </div>
</section>

@endsection

@section('script')


@endsection
