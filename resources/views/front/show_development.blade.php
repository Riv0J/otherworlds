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
    <h3 class="m-5 d-inline-flex gap-3">
        <i class="ri-arrow-right-s-line"></i> Tasks
    </h3>
    <ol class="m-5">
        <h3 class="div_h div_gray my-4 pb-3 text-center">High prio</h3>
        <li>
            <h5>
                Modular modals(confirm*, input*, image inspector)
            </h5>
        </li>
        <li>
            <h5>
                Admin Place index(+ajax, +filters country, category)*, create, edit, update, delete
            </h5>
        </li>
        <li>
            <h5>
                Admin Place-Media create, edit, delete
            </h5>
        </li>
        <li>
            <h5>
                Domain name & SSL cert(HTTPS)
            </h5>
        </li>
        <li>
            <h5>
                Admin home (dashboard)
            </h5>
        </li>
        <li>
            <h5>
                Favicon
            </h5>
        </li>
        <li>
            <h5>
                Email verification & password reset
            </h5>
        </li>
        <li>
            <h5>
                Total 75 places
            </h5>
        </li>
        <h3 class="div_h div_gray my-4 pb-3 text-center">Low prio</h3>
        <li>
            <h5>
                SEO CHECK(index.html, sitemap.xml, robots.txt, view-source:, .DS_Store, apache .htaccess, etc):<a href="https://www.seobility.net/en/seocheck/">FREE SEO CHECKER</a>
            </h5>
        </li>
        <li>
            <h5>
                Big Sitemap(HTML, XML, etc)
            </h5>
        </li>
        <li>
            <h5>
                More languages(EU,FR,IT)
            </h5>
        </li>
        <h3 class="div_h div_gray my-4 pb-3 text-center">Extras</h3>
        <li>
            <h5>
                Front Place index search and filters (country, category)
            </h5>
        </li>
        <li>
            <h5>
                Media order in gallery
            </h5>
        </li>
        <li>
            <h5>
                Place show comments
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
        <li>
            <h5 class="text-decoration-line-through">
                Admin aside panel
            </h5>
        </li>
        <li>
            <h5 class="text-decoration-line-through">
                Front User profile*, edit*, update*
            </h5>
        </li>
        <li>
            <h5 class="text-decoration-line-through">
                Admin User index(+ajax)*, create*, edit*, update*, delete*
            </h5>
        </li>
        <li>
            <h5 class="text-decoration-line-through">
                Rutas front 99% traducidas
            </h5>
        </li>
        <li>
            <h5 class="text-decoration-line-through">
                Admin Visit index(+ajax)*, delete*
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
