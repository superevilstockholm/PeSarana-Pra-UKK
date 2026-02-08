<?php

if (!function_exists('adminSidebarItems')) {
    function adminSidebarItems(): array
    {
        $items = [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.admin.index', 'active_pattern' => 'dashboard.admin.index'],
            ],
            'master data' => [
                ['label' => 'categories', 'icon' => 'ti ti-tag', 'route' => 'dashboard.admin.master-data.categories.index', 'active_pattern' => 'dashboard.admin.master-data.categories.*   '],
                ['label' => 'aspirations', 'icon' => 'ti ti-flag', 'route' => 'dashboard.admin.master-data.aspirations.index', 'active_pattern' => 'dashboard.admin.master-data.aspirations.*   '],
            ],
        ];
        return $items;
    }
}

if (!function_exists('studentSidebarItems')) {
    function studentSidebarItems(): array
    {
        $items = [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.student.index', 'active_pattern' => 'dashboard.student.index'],
                ['label' => 'aspirations', 'icon' => 'ti ti-flag', 'route' => 'dashboard.student.aspirations.index', 'active_pattern' => 'dashboard.student.aspirations.*'],
            ],
        ];
        return $items;
    }
}
