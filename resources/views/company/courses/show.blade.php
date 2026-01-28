@extends('layouts.layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-sm text-white">Home</li>
            <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
                <a href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
                Course Details
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white">{{ $course->title }}</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mb-6 mx-auto">

        {{-- ================= HERO SECTION ================= --}}
        <div class="bg-gradient-to-r  relative bg-emerald-500/30 py-24 from-indigo-600 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
            {{-- ACTIONS --}}
            <div class="absolute top-0 end-0 z-990 ">
                <button onclick="document.getElementById('dropdown_{{ $course->id }}').classList.toggle('hidden')"
                    class="p-2 bg-yellow-50 rounded-b-lg hover:bg-gray-100 dark:hover:bg-slate-700">
                    <i class="bi bi-three-dots-vertical text-dark"></i>
                </button>

                <div id="dropdown_{{ $course->id }}"
                    class="hidden absolute right-0 mt-2 w-36 bg-white dark:bg-slate-800 border dark:border-slate-700 rounded-lg shadow-lg text-sm">

                    @if ($course->status === 'published')
                        <a href="{{ route('company.courses.index') }}"
                            class="block px-4 py-2 text-dark hover:bg-gray-100 dark:hover:bg-slate-700">
                            ← Back
                        </a>
                        <a href="{{ route('company.courses.show', $course->course_identity) }}"
                            class="block px-4 py-2 text-dark hover:bg-gray-100 dark:hover:bg-slate-700">
                            👁️ View
                        </a>
                        <a href="{{ route('company.courses.show', $course->course_identity) }}"
                            class="block px-4 py-2 text-dark hover:bg-gray-100 dark:hover:bg-slate-700">
                            📅 Classes
                        </a>
                        <a href="{{ route('company.courses.show', $course->course_identity) }}"
                            class="block px-4 py-2 text-dark hover:bg-gray-100 dark:hover:bg-slate-700">
                            📕 Materials
                        </a>
                    @endif

                    <a href="{{ route('company.courses.create', ['draft' => $course->course_identity]) }}"
                        class="block px-4 py-2 text-dark hover:bg-gray-100 dark:hover:bg-slate-700">
                        ✏️ Edit
                    </a>

                </div>
            </div>
            <div class="flex flex-row md:flex-row gap-6 items-center">

                <img src="{{ $course->main_image_url ?? asset('assets/images/bg/dummy_image.webp') }}"
                    class=" h-40 w-1/4 rounded-xl object-cover shadow-lg">

                <div class="flex-1">
                    <h3 class="text-2xl font-bold">{{ $course->title }}</h3>
                    <p class="text-sm opacity-90 mt-1">
                        {{ $course->description }}
                    </p>

                    <div class="flex flex-wrap gap-3 mt-4 text-sm">
                        <span class="px-3 py-1 bg-white/20 rounded-full">
                            🧑‍🎓 {{-- {{ $studentsJoined }} --}} Students
                        </span>
                        <span class="px-3 py-1 bg-white/20 rounded-full">
                            ⏱ {{ $course->total_hours ?? '--' }} Hours
                        </span>
                        <span class="px-3 py-1 bg-white/20 rounded-full">
                            🗓 {{ $course->duration ?? '--' }} Days
                        </span>
                        <span class="px-3 py-1 bg-white/20 rounded-full">
                            💰 ₹{{ number_format($course->net_price) }}
                        </span>
                    </div>
                </div>


            </div>
        </div>

        {{-- ================= KPI CARDS ================= --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">

            <div class="bg-white rounded-xl p-4 shadow">
                <p class="text-xs text-gray-500">Students Joined</p>
                {{-- <p class="text-2xl font-bold text-indigo-600">{{ $studentsJoined }}</p> --}}
            </div>

            <div class="bg-white rounded-xl p-4 shadow">
                <p class="text-xs text-gray-500">Revenue Generated</p>
                <p class="text-2xl font-bold text-green-600">
                    {{-- ₹{{ number_format($studentsJoined * $course->net_price) }} --}}
                </p>
            </div>

            <div class="bg-white rounded-xl p-4 shadow">
                <p class="text-xs text-gray-500">Course Status</p>
                <p class="text-lg font-semibold capitalize">{{ $course->status }}</p>
            </div>

            <div class="bg-white rounded-xl p-4 shadow">
                <p class="text-xs text-gray-500">Course Type</p>
                <p class="text-lg font-semibold capitalize">{{ $course->type }}</p>
            </div>

        </div>

        {{-- ================= DETAILS ================= --}}
        <div class="grid md:grid-cols-2 gap-6 mt-8">

            {{-- BASIC INFO --}}
            <div class="bg-white rounded-xl p-5 shadow">
                <h3 class="font-semibold text-indigo-600 mb-4">📘 Basic Information</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><strong>Start Date:</strong> {{ $course->started_at ?? '—' }}</li>
                    <li><strong>End Date:</strong> {{ $course->ended_at ?? 'Unlimited' }}</li>
                    <li>
                        <strong>Categories:</strong>
                        {{ implode(', ', $course->categories->pluck('title')->toArray()) ?: '—' }}
                    </li>
                </ul>
            </div>

            {{-- PRICING --}}
            <div class="bg-white rounded-xl p-5 shadow">
                <h3 class="font-semibold text-green-600 mb-4">💰 Pricing</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li>Actual Price: ₹{{ number_format($course->actual_price) }}</li>
                    <li>
                        Discount:
                        @if ($course->discount_amount)
                            {{ $course->discount_amount }}
                            {{ $course->discount_type === 'percentage' ? '%' : '₹' }}
                        @else
                            None
                        @endif
                    </li>
                    <li class="font-semibold text-green-700">
                        Net Price: ₹{{ number_format($course->net_price) }}
                    </li>
                    <li>Tax Included: {{ $course->is_tax ? 'Yes' : 'No' }}</li>
                </ul>
            </div>

            {{-- ADVANCED --}}
            <div class="bg-white rounded-xl p-5 shadow md:col-span-2">
                <h3 class="font-semibold text-blue-600 mb-4">⚙️ Advanced Settings</h3>

                <div class="grid md:grid-cols-3 gap-4 text-sm text-gray-700">
                    <div>Video Type: {{ ucfirst($course->video_type ?? '—') }}</div>
                    <div>Streaming: {{ ucfirst($course->streaming_type ?? '—') }}</div>
                    <div>Material: {{ $course->has_material ? 'Yes' : 'No' }}</div>
                    <div>Material Download: {{ $course->has_material_download ? 'Allowed' : 'No' }}</div>
                    <div>Exam: {{ $course->has_exam ? 'Yes' : 'No' }}</div>
                    <div>Career Guidance: {{ $course->is_career_guidance ? 'Yes' : 'No' }}</div>
                    <div>Counselling: {{ $course->is_counselling ? 'Yes' : 'No' }}</div>
                </div>
            </div>

        </div>

    </div>

@endsection
