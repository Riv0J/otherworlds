@extends('layout.masterpage')

@section('title')

@endsection

@section('description')

@endsection

@section('content')
<section class="bg_black row mt-3 col-12 col-lg-8 px-1 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center white shadows_inline">

    <div class="spacer mt-4 pt-5"></div>

    <div class="d-flex justify-content-between app_border_bottom mx-3 px-0 pb-2 ml-5">
        <div class="flex_center gap-4">
            <div class="profile_img" style="background-color: gray;">
                <img class="" src="{{asset('img/users/'.$user->img)}}" style="width: 5rem;" alt="">
            </div>

            <h3 id="pl_name" class="regular">{{$user->name}}</h3>

            @if($user->country)
            <h3 id="pl_name" class="regular">{{$user->country->name}}</h3>
            @endif
        </div>

    </div>


    <div class="row my-4 p-0 justify-content-between gap-2">


        <div class="col-12 col-md-6 p-0 border bg_gray p-2 pb-4">
            <div class="img_container img_gradient_bottom img_gradient_top text-center">
                <img src="http://localhost/otherworlds/public/img/places/3/t.png" alt="Monument Valley otherworlds.thumbnail">
            </div>
            <p class="text-center my-2">Cluster of sandstone "buttes" rock formations in the Colorado plateau.</p>

            <div class="div_h div_gray mx-2 my-4"></div>


            <div class="row p-0 m-0">
                <div class="col-4 d-flex flex-column align-items-end gap-1 text-end">
                    <small>Country:</small>
                    <small>Category:</small>
                    <small>Views:</small>
                    <small>Date added:</small>
                    <small>Source:</small>
                </div>
                <div class="col-8 d-flex flex-column align-items-start gap-1">
                    <small class="flex_center gap-2"><span class="flag-icon flag-icon-usa"></span>United States</small>
                    <small>Valleys (Land Depressions)</small>
                    <small class="short_number">517.7k</small>
                    <small>07-04-2024</small>
                    <small><a class="px-2" href="https://en.wikipedia.org/wiki/Monument_Valley" target="_blank">Monument Valley</a></small>
                </div>
            </div>


        </div>


        <div class="col-12 col-md p-0">

            <p class="rounded-4 px-3 py-2">Description in English</p>
            <a class="px-2" href="http://localhost/otherworlds/public/places">return</a>
            <a class="px-2" href="https://en.wikipedia.org/wiki/Monument_Valley" target="_blank">Learn more about Monument Valley</a>
            <div class="div_h mr-2"></div>

        </div>

    </div>
</section>
<style>
    .shadows_inline{
        box-shadow: 10px 0 10px rgba(0, 0, 0, 0.5), -10px 0 10px rgba(0, 0, 0, 0.5);
    }
</style>
@endsection
