@extends('layouts.layout')

@php
    $isView = isset($webinar);
@endphp

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm"><a class="text-white" href="/">Home</a></li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">
                Webinar Overview
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Webinar Overview</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3 flex justify-between items-center">
                <h5 class="font-bold">Webinar Overview</h5>

                <div class="space-x-2">
                    <a href="{{ route('company.demo-class.edit', $webinar->id) }}"
                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Edit</a>

                    @if (!$webinar->registrations->isEmpty())
                        <a href="{{ route('company.demo-class.registrations.download-csv', $webinar->id) }}" class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Download
                            Registered Users CSV</a>
                    @endif
                    <a href="{{ route('company.demo-class.index') }}" class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Back</a>

                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <!-- Total Participants -->
            <div class="bg-white dark:bg-slate-850 shadow rounded-2xl p-4 text-center">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300">Total Participants</h3>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalParticipants }}</p>
            </div>

            <!-- Teachers Joined -->
            <div class="bg-white dark:bg-slate-850 shadow rounded-2xl p-4 text-center">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300">Teachers</h3>
                <p class="text-2xl font-bold text-green-500">{{ $totalTeachers }}</p>
            </div>

            <!-- Students Joined -->
            <div class="bg-white dark:bg-slate-850 shadow rounded-2xl p-4 text-center">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300">Students</h3>
                <p class="text-2xl font-bold text-blue-500">{{ $totalStudents }}</p>
            </div>

            <!-- Guests Joined -->
            <div class="bg-white dark:bg-slate-850 shadow rounded-2xl p-4 text-center">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300">Guests</h3>
                <p class="text-2xl font-bold text-yellow-500">{{ $totalGuests }}</p>
            </div>
        </div>



        <div class="w-full px-6 py-4 mx-auto space-y-6">
            {{-- Basic Info --}}
            <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-4 dark:text-white">📝 Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><span class="font-semibold">Title:</span> <span
                            class="capitalize font-bold">{{ $webinar->title }}</span></p>
                    <p><span class="font-semibold">Slug:</span> <span class="font-bold">{{ $webinar->slug }}</span></p>
                    <p><span class="font-semibold">Description:</span> <span
                            class="font-bold">{{ $webinar->description ?? 'N/A' }}</span></p>
                    <p><span class="font-semibold">Host:</span> <span
                            class="font-bold">{{ $webinar->host?->name ?? 'N/A' }}</span></p>
                    <p><span class="font-semibold">Stream Provider:</span> <span
                            class="font-bold">{{ $webinar->streamProvider?->name ?? 'N/A' }}</span></p>
                    <p>
                        <span class="font-semibold">Status:</span>
                        <span
                            class="font-bold px-2 py-1 rounded {{ $webinar->status == 'live' ? 'bg-green-200 text-green-800' : ($webinar->status == 'scheduled' ? 'bg-yellow-200 text-yellow-800' : ($webinar->status == 'ended' ? 'bg-gray-200 text-gray-800' : 'bg-blue-200 text-blue-800')) }}">
                            {{ ucfirst($webinar->status) }}
                        </span>
                    </p>
                    <p><span class="font-semibold">Max Participants:</span> <span
                            class="font-bold">{{ $webinar->max_participants ?? 'N/A' }}</span></p>
                </div>
            </div>

            {{-- Images --}}
            <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-4 dark:text-white">🖼️ Images</h2>
                <div class="flex space-x-6">
                    @if ($webinar->thumbnail_image)
                        <div>
                            <p class="font-semibold mb-1">Thumbnail</p>
                            <img src="{{ asset('storage/' . $webinar->thumbnail_image) }}" class="w-32 h-32 rounded-lg">
                        </div>
                    @endif
                    @if ($webinar->main_image)
                        <div>
                            <p class="font-semibold mb-1">Main Image</p>
                            <img src="{{ asset('storage/' . $webinar->main_image) }}" class="w-32 h-32 rounded-lg">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Schedule --}}
            <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-4 dark:text-white">📅 Schedule</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><span class="font-semibold">Start At:</span> <span
                            class="font-bold">{{ $webinar->started_at?->format('d-m-Y H:i') ?? 'N/A' }}</span></p>
                    <p><span class="font-semibold">End At:</span> <span
                            class="font-bold">{{ $webinar->ended_at?->format('d-m-Y H:i') ?? 'N/A' }}</span></p>
                    <p><span class="font-semibold">Registration Ends At:</span> <span
                            class="font-bold">{{ $webinar->registration_end_at?->format('d-m-Y H:i') ?? 'N/A' }}</span></p>
                    <p><span class="font-semibold">Meeting URL:</span>
                        @if ($webinar->meeting_url)
                            <a href="{{ $webinar->meeting_url }}" target="_blank"
                                class="text-blue-500 underline">{{ $webinar->meeting_url }}</a>
                        @else
                            N/A
                        @endif
                    </p>
                    <p><span class="font-semibold">Recording URL:</span>
                        @if ($webinar->recording_url)
                            <a href="{{ $webinar->recording_url }}" target="_blank"
                                class="text-blue-500 underline">{{ $webinar->recording_url }}</a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>

            {{-- Access & Features --}}
            <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-4 dark:text-white">🔑 Access & Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach (['teacher', 'student', 'guest'] as $role)
                        <p><span class="font-semibold">{{ ucfirst($role) }} Access:</span>
                            <span class="font-bold">{{ $webinar->{'is_' . $role . '_allowed'} ? 'Yes' : 'No' }}</span>
                        </p>
                    @endforeach

                    @foreach (['record', 'chat', 'screen_share', 'whiteboard', 'camera', 'audio_only'] as $feature)
                        <p><span class="font-semibold">{{ ucwords(str_replace('_', ' ', $feature)) }}:</span>
                            <span class="font-bold">{{ $webinar->{'is_' . $feature . '_enabled'} ? 'Yes' : 'No' }}</span>
                        </p>
                    @endforeach
                </div>
            </div>

            {{-- Registered Users --}}
            <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-4 dark:text-white">👥 Registered Users
                    ({{ $webinar->registrations->count() }})</h2>

                @if ($webinar->registrations->isEmpty())
                    <p>No users have registered yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">#</th>
                                    <th class="px-4 py-2 border">Name</th>
                                    <th class="px-4 py-2 border">Email</th>
                                    <th class="px-4 py-2 border">Phone</th>
                                    <th class="px-4 py-2 border">Checked In</th>
                                    <th class="px-4 py-2 border">Attended</th>
                                    <th class="px-4 py-2 border">Registered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($webinar->registrations as $registration)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border">{{ $registration->name }}</td>
                                        <td class="px-4 py-2 border">{{ $registration->email }}</td>
                                        <td class="px-4 py-2 border">{{ $registration->phone ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border">{{ $registration->checked_in ? 'Yes' : 'No' }}</td>
                                        <td class="px-4 py-2 border">{{ $registration->attended_status ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $registration->created_at->format('d-m-Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>


            {{-- Tags & Meta --}}
            <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                <h2 class="text-xl font-bold mb-4 dark:text-white">🏷️ Tags & Meta</h2>
                <p><span class="font-semibold">Tags:</span> <span class="font-bold">{{ $webinar->tags ?? 'N/A' }}</span>
                </p>
                <p><span class="font-semibold">Meta:</span> <span class="font-bold">{{ $webinar->meta ?? 'N/A' }}</span>
                </p>
            </div>

        </div>
    </div>
@endsection
