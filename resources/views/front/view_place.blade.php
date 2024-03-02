@extends('layout.masterpage')

@section('title')
{{$place->name}} | Otherworlds
@endsection

@section('content')
<div class="spacer mt-3 pt-5"></div>

<div class="divider col-9 col-md-6 col-lg-4 my-md-3"></div>



<section class="col-12 px-1 px-lg-2 py-3">
    {{$place->name}}
    {{$place->description}}
</section>

@endsection

@section('script')


@endsection
