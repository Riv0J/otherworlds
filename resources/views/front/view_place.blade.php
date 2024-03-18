@extends('layout.masterpage')

@section('title')
{{$place->name}} | Otherworlds
@endsection

@section('content')
<div class="spacer mt-3 pt-5"></div>

<section class="row mt-3 col-12 px-1 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center white">

    {{-- title + img --}}
    <div class="row col-8 col-md-6 d-flex flex_center">

        {{-- title --}}
        <div class="mx-2 d-flex justify-content-between">
            <h3 class="flex_center gap-4">
                <span class="flag-icon flag-icon-{{$place->country->code}}" title="{{$place->country->name}}"></span>{{$place->name}}
            </h3>
            <h5 class="light mb-0 flex_center ">
                {{$place->classification->name}}
            </h5>
        </div>

        {{-- img --}}
        <div class="text-center">
            <img class="p-2 rounded-5 my-4" src="{{asset('img/places/'.$place->id.'/t.png')}}" alt="">
            <h4>{{$place->synopsis}}</h4>
        </div>
    </div>

    {{-- body --}}
    <div class="col-8 col-md-6 my-4 my-md-0">
        <p class="border rounded-4 px-3 py-2">{{$place->description}}</p>
        <a class="btn" href="{{route('places')}}"><button>@lang('return')</button></a>
    </div>
</section>

@endsection

@section('script')


@endsection
