@extends('App')
@section('layout')
    <x-sidebar :meta="$meta"></x-sidebar>
    <x-topbar></x-topbar>
    <div class="pc-container">
        <div class="pc-content">
            <div class="row mb-4">
                <div class="col">
                    @php
                        $segments = collect(request()->segments());
                        $category = $segments->get(1);
                        $item     = $segments->get(2);
                        $subitem  = $segments->get(3);
                        $isDashboardOnly = request()->is('dashboard');
                    @endphp
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0">
                            <li class="breadcrumb-item {{ $isDashboardOnly ? 'active' : 'fw-medium' }}"
                                @if($isDashboardOnly) aria-current="page" @endif>
                                @if($isDashboardOnly)
                                    Dashboard
                                @else
                                    <a href="{{ url('dashboard') }}">Dashboard</a>
                                @endif
                            </li>
                            @if($item)
                                @php
                                    $itemLabel = ucwords(str_replace('-', ' ', $item));
                                    $itemUrl   = url("dashboard/$category/$item");
                                @endphp
                                <li class="breadcrumb-item {{ $subitem ? 'fw-medium' : 'active' }}"
                                    @if(!$subitem) aria-current="page" @endif>
                                    @if($subitem)
                                        <a href="{{ $itemUrl }}">{{ $itemLabel }}</a>
                                    @else
                                        {{ $itemLabel }}
                                    @endif
                                </li>
                            @endif
                            @if($subitem)
                                @php
                                    $subLabel = ucwords(str_replace('-', ' ', $subitem));
                                @endphp
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $subLabel }}
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
    <footer class="pc-footer">
        <div class="footer-wrapper container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <p class="m-0 text-center fw-medium text-muted">
                        Copyright &copy; 2025 <b>Bjorki's Dev</b>. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('static/vendor/tabler-icons/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('static/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('static/css/style-preset.css') }}">
<link rel="stylesheet" href="{{ asset('static/css/custom.css') }}">
@endpush
@push('js')
<script src="{{ asset('static/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('static/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('static/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('static/js/script.js') }}"></script>
@endpush
