<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard.' . auth()->user()->role->value . '.index') }}" class="b-brand d-flex align-items-center gap-2 fs-3 fw-bold">
                <img style="height: 35px;" src="{{ asset('static/img/no-image-placeholder.svg') }}" alt="Logo PeSarana">
                PeSarana
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @foreach ($meta['sidebarItems'] as $key => $item)
                    <li class="pc-item pc-caption">
                        <label>{{ $key }}</label>
                    </li>
                    @foreach ($item as $sub_item)
                        <li class="pc-item{{ request()->routeIs($sub_item['active_pattern']) ? ' active' : '' }}">
                            <a href="{{ route($sub_item['route']) }}" class="pc-link">
                                <span class="pc-micon d-inline-flex align-items-center">
                                    <i class="{{ $sub_item['icon'] }}"></i>
                                </span>
                                <span class="pc-mtext fw-medium">
                                    {{ $sub_item['label'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
            <div class="w-100 text-center">
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"></div>
            </div>
        </div>
    </div>
</nav>
