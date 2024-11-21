@extends('layout.masterpage')

@section('title')
Comandos | Admin {{ config('app.name') }}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1" />
<link rel="stylesheet" href="{{ asset('css/search.css') }}?v=2" />
<link rel="stylesheet" href="{{ asset('css/forms.css') }}" />

<section class="col-10 col-lg-10 mt-2">
    <div class="admin_header">
        <div class="admin_title">
            <i class="fa-solid fa-server"></i>
            <h2 class="regular">Servidor [TEST]</h2>
        </div>
    </div>
    <span class="bg-info p-2 rounded-2"> 
        <i class="fa-solid fa-circle-info"></i>
        Información aproximada sobre el estado del servidor
    </span>
    <div class="stats mt-4 flex-row gap-3">
        <article id="cpu">
            <h2>CPU</h2>
            @php $cpu_percent = ($cpuLoad['last1Min'] / $cpuLoad['cores']) * 100; @endphp
            <span>{{$cpu_percent}}<small>%</small></span>
            <div class="progress" style="width:{{$cpu_percent}}%"></div>
        </article>

        <article id="ram">
            <h2>RAM</h2>
            @php $ram_percent = ($ram['used'] / $ram['total']) * 100; @endphp
            <span>{{ $ram['used'] }}<small>GB</small> / {{ $ram['total'] }}<small>GB</small></span>
            <div class="progress" style="width:{{$ram_percent}}%"></div>
        </article>

        <article id="disc">
            <h2>DISK</h2>
            @php $disk_percent = ($disk['used'] / $disk['total']) * 100; @endphp
            <span>{{ $disk['used'] }}<small>GB</small> / {{ $disk['total'] }}<small>GB</small></span>
            <div class="progress" style="width:{{$disk_percent}}%"></div>
        </article>

    </div>
    <div class="mt-4">
        <h2>Sesiones Activas</h2>
        <p>{{ $activeSessions }}</p>
    </div>
    <div class="mt-4">
        <h2>Carga del CPU ({{ $cpuLoad['cores'] }} núcleos) en los últimos minutos:</h2>
        <ul>
            <li>1min: {{ $cpuLoad['last1Min'] / $cpuLoad['cores'] * 100 }}<small>%</small></li>
            <li>5min: {{ $cpuLoad['last5Min'] / $cpuLoad['cores'] * 100 }}<small>%</small></li>
            <li>15min: {{ $cpuLoad['last15Min'] / $cpuLoad['cores'] * 100 }}<small>%</small></li>
        </ul>
    </div>
</section>
<style>
    .progress{
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: 99;
        border-radius: 0;
        background-color: transparent;
        border-bottom: 6px solid red;
    }
    .stats{
        align-items: stretch;
    }
    article::after{
        content:'';
        position:absolute;
        inset:0;
        border-bottom: 6px solid gray;
    }
    article{
        position:relative;
        border: 2px solid black;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        aspect-ratio: 4;
    }
    small{
        font-size: 0.7rem;
    }
</style>
@endsection

@section('script')
@endsection