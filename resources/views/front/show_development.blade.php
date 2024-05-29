@extends('layout.masterpage')

@section('title')
Dev | Otherworlds
@endsection

@section('canonical')
{{ URL::current() }}
@endsection

@section('content')
<section class="wrapper col-12 col-lg-10">
    <h3 class="m-3 d-inline-flex gap-3">
        <i class="ri-arrow-right-s-line"></i> Tasks
    </h3>
    <div class="notes">
        <fieldset>
            <legend>[ADMIN] Place</legend>
            <ul>
                <li>Index(ajax + filters)*</li>
                <li>Create(from scratch, from wikipedia)</li>
                <li>Edit</li>
                <li>Delete</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>[ADMIN] Media</legend>
            <ul>
                <li>Index?</li>
                <li>Create(from scratch, from wikimedia)</li>
                <li>Edit</li>
                <li>Delete</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Implementations</legend>
            <ul>
                <li>Email verification & password reset</li>
                <li>Admin home (dashboard)</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>SEO</legend>
            <ul>
                <li>Domain name</li>
                <li>SSL cert(HTTPS)</li>
                <li>Crawler Optimization(HTML, XML, etc)</li>
                <li><a href="https://www.seobility.net/en/seocheck/">Free SEO Checker</a></li>
            </ul>
        </fieldset>
    </div>

    <h3>Low Prio</h3>
    <div class="notes">
        <fieldset>
            <legend>[Front] Place</legend>
            <ul>
                <li>Total 75 Places</li>
                <li>Index search + filters</li>
                <li>Show comments</li>
                <li>Media order</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Styles</legend>
            <ul>
                <li>CSS Forms</li>
                <li>Favicon</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Languages</legend>
            <ul>
                <li>EU</li>
                <li>FR</li>
                <li>IT</li>
            </ul>
        </fieldset>
    </div>

    <h3>Complete</h3>
    <div class="notes">
        <fieldset>
            <legend>[Front] User</legend>
            <ul>
                <li>Auth (login/logout, register)</li>
                <li>Show (profile, favorites)</li>
                <li>Edit</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>[Front] Place</legend>
            <ul>
                <li>Index (+ajax, favorites)</li>
                <li>Show (info, gallery)</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>[Admin] User</legend>
            <ul>
                <li>Index (+ajax)</li>
                <li>Create</li>
                <li>Edit</li>
                <li>Delete</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>[Admin] Visit</legend>
            <ul>
                <li>Index (+ajax)</li>
                <li>Delete</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Layout / routes</legend>
            <ul>
                <li>Rutas 100% traducidas</li>
                <li>Admin panel</li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Modals</legend>
            <ul>
                <li>Confirm</li>
                <li>Input</li>
                <li>Choice</li>
                <li>Image Inspector</li>
            </ul>
        </fieldset>
    </div>
</section>
<style>
    h3:not(:first-of-type){
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        text-align: center;
        border-bottom: 1px solid gray;
    }
    .notes{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    fieldset{
        padding: 0.5rem;
        border-radius: 0.5rem;
        background-color: var(--black);
        border: 1px solid rgb(94, 94, 94);
    }
    fieldset h5{
        margin-bottom: 0.5rem;
    }
    fieldset li{
        font-weight: 400;
        list-style-type: circle;
    }
    fieldset *{
        color: white !important;
    }
    legend{
        width: unset;
        float: unset;
        border-radius: inherit;
        background-color: #c7545f;
        font-family: 'Lato';
        font-size: 1.25rem;
        font-weight: 300;
        padding: 0.25rem 1rem;
        margin: 0;
    }
</style>

@endsection
