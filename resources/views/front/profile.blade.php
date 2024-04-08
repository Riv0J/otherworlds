@extends('layout.masterpage')

@section('title')

@endsection

@section('description')

@endsection

@section('content')

<section class="bg_black row mt-3 col-12 col-lg-8 px-1 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center white shadows_inline">

    <div class="spacer mt-4 pt-5"></div>

    <div>Ello {{$user->name}}</div>
</section>
@endsection
