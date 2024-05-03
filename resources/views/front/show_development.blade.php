@extends('layout.masterpage')

@section('title')
Dev | Otherworlds
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')
<section class="bg_black shadows_inline white col-12 col-lg-8 px-2 px-lg-4 py-3 flex-column flex-md-row justify-content-center align-items-center">
    <div class="spacer mt-4 pt-5"></div>
    <h3 class="m-5"><i class="ri-arrow-right-s-line"></i> Tasks</h3>
    <ol class="m-5">
        <h3 class="div_h div_gray my-4 pb-3 text-center">High prio</h3>
        <li>
            <h5>
                Seed more users, users index section
            </h5>
        </li>
        <li>
            <h5>
                User profile, edit, favorites
            </h5>
        </li>
        <li>
            <h5>
                Make app public
            </h5>
        </li>
        <li>
            <h5>
                Email verification & password reset
            </h5>
        </li>
        <li>
            <h5>
                Implement Visits
            </h5>
        </li>
        <li>
            <h5>
                Admin panel
            </h5>
        </li>
        <li>
            <h5>
                Total 50 places.
            </h5>
        </li>
        <h3 class="div_h div_gray my-4 pb-3 text-center">Low prio</h3>
        <li>
            <h5>
                Geo Classification
            </h5>
        </li>
        <li>
            <h5>
                Big Sitemap
            </h5>
        </li>
        <li>
            <h5>
                Media order
            </h5>
        </li>
        <li>
            <h5>
                Place comments
            </h5>
        </li>
        <li>
            <h5>
                More languages
            </h5>
        </li>
        <h3 class="div_h div_gray my-4 pb-3 text-center">Extras</h3>
        <li>
            <h5>
                Media order in gallery
            </h5>
        </li>

    </ol>
    <ul class="mx-5">
        <h3 class="div_h div_gray my-4 pb-3 text-center">Completed</h3>
        <li>
            <h5 class="text-decoration-line-through">
                Place gallery from wikimedia
            </h5>
        </li>
    </ul>
</section>
<style>
    section{
        min-height: 100vh;
    }
    .shadows_inline{
        box-shadow: 10px 0 10px rgba(0, 0, 0, 0.5), -10px 0 10px rgba(0, 0, 0, 0.5);
    }
</style>

@endsection
