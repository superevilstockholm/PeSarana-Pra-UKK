<?php

use Illuminate\Support\Str;

if (!function_exists('adminSidebarItems')) {
    function adminSidebarItems(): array
    {
        $items = [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.admin.index'],
            ],
        ];
        foreach ($items as $group => &$groupItems) {
            foreach ($groupItems as &$item) {
                if ($item['route'] === 'dashboard.admin.index') {
                    $item['active_pattern'] = $item['route'];
                } else {
                    $item['active_pattern'] = Str::replaceLast('.index', '.*', $item['route']);
                }
            }
        }
        return $items;
    }
}

if (!function_exists('studentSidebarItems')) {
    function studentSidebarItems(): array
    {
        $items = [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.student.index'],
            ],
        ];
        foreach ($items as $group => &$groupItems) {
            foreach ($groupItems as &$item) {
                if ($item['route'] === 'dashboard.admin.index') {
                    $item['active_pattern'] = $item['route'];
                } else {
                    $item['active_pattern'] = Str::replaceLast('.index', '.*', $item['route']);
                }
            }
        }
        return $items;
    }
}
