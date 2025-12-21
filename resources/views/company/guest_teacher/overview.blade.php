@extends('layouts.layout')
@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Guest Teacher Overview</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Guest Teacher Overview</h6>
    </nav>
@endsection
@section('content')
    <div class="container">

        <div class="card bg-white rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h5 class="font-bold">Guest Teacher Overview</h5>
                    <a href="{{ route('company.guest-teacher.index') }}"
                        class="bg-emerald-500/50 rounded-1.8  text-white px-3 py-2">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-6 py-4 mx-auto">
        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 dark:text-white">👤 Personal Information</h2>
            <img src="{{ $guestTeacher->avatar_url }}" class="w-20 rounded-lg mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <p><span class="font-semibold">Full Name:</span> <span
                        class="capitalize font-bold">{{ $guestTeacher->name }}</span></p>
                <p><span class="font-semibold">Email:</span> <span
                        class="capitalize font-bold">{{ $guestTeacher->email }}</span>
                </p>
                <p><span class="font-semibold">Phone:</span> <span
                        class="capitalize font-bold">{{ $guestTeacher->mobile }}</span></p>

            </div>
        </div>
    </div>
@endsection
