@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.user_create') | Otherworlds
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}" />
    <section class="wrapper col-12 col-lg-10">
        <div class="title">
            <div class="text">
                <i class="fa-solid fa-chart-line"></i>
                <h3>@lang('otherworlds.visits')</h3>
                <small>@lang('otherworlds.total'): {{ count($visits) }}</small>
            </div>
            <nav class="buttons">
                <i class="fa-solid fa-spinner"></i>
            </nav>
        </div>

        <div class="table_container">
            <table class="results_table">
                <thead>
                    <tr>
                        <th class="small"></th>
                        <th>IP</th>

                        <th>@lang('otherworlds.browser')</th>
                        <th>@lang('otherworlds.platform')</th>
                        <th>@lang('otherworlds.route')</th>
                        <th>@lang('otherworlds.date')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr>
                            <td class="text-center px-1">
                                <span class="flag-icon flag-icon-{{ $visit->country->code }}"
                                    title="{{ $visit->country->name }}"></span>
                            </td>
                            <td>
                                {{ $visit->ip }}
                            </td>
                            <td>
                                {{ $visit->browser }}
                            </td>
                            <td>
                                {{ $visit->os }}
                            </td>
                            <td>
                                {{ $visit->route }}
                            </td>
                            <td>
                                {{ $visit->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('script')
@endsection
