<?php

use App\Models\Department;
use App\Models\Service;

if (!function_exists('getDepartments')) {
    function getDepartments()
    {
        return Department::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name','slug']);
    }
}

if (!function_exists('getServices')) {
    function getServices()
    {
        return Service::where('is_active', 1)
            ->orderBy('title', 'asc')
            ->get(['id', 'title','slug']);
    }
}
