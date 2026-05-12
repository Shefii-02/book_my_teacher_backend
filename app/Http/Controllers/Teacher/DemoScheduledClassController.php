<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DemoClass;
use Illuminate\Http\Request;

class DemoScheduledClassController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();

        $demoClasses = DemoClass::where('host_id', $teacherId)
            ->latest()
            ->get();

        // =========================
        // COUNTS
        // =========================

        $data['total'] = $demoClasses->count();

        $data['completed'] = $demoClasses
            ->where('ended_at', '<', now())
            ->count();

        $data['upcoming'] = $demoClasses
            ->where('started_at', '>', now())
            ->count();

        $data['ongoing'] = $demoClasses
            ->where('started_at', '<=', now())
            ->where('ended_at', '>=', now())
            ->count();

        $data['cancelled'] = $demoClasses
            ->where('status', 'cancelled')
            ->count();

        return view(
            'teacher.demo_classes.index',
            compact('demoClasses', 'data')
        );
    }
}
