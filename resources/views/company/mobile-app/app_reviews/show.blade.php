@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.app.app-reviews.index') }}">App Reviews</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white capitalize before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Review #{{ $review->id }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Review Details</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="p-6 pb-0 rounded-t-2xl">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h6>Review #{{ $review->id }}</h6>
                                <p class="mb-4 text-sm text-slate-500">Details for this app review.</p>
                            </div>
                            <a href="{{ route('company.app.app-reviews.index', ['tab' => $review->status === 'approved' ? 'verified' : 'pending']) }}"
                                class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700">Back</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="p-4 border rounded-xl border-slate-200">
                                <h6 class="text-sm font-semibold text-slate-600">User</h6>
                                <p class="mt-2 text-sm text-slate-800">{{ $review->user?->name ?? '-' }}</p>
                                <p class="text-xs text-slate-500">{{ $review->user?->email ?? $review->user?->mobile ?? '-' }}</p>
                            </div>
                            <div class="p-4 border rounded-xl border-slate-200">
                                <h6 class="text-sm font-semibold text-slate-600">Rating</h6>
                                <p class="mt-2 text-sm text-slate-800">{{ $review->rating ?? '-' }}</p>
                            </div>
                            <div class="p-4 border rounded-xl border-slate-200 md:col-span-2">
                                <h6 class="text-sm font-semibold text-slate-600">Feedback</h6>
                                <p class="mt-2 text-sm text-slate-800 whitespace-pre-line">{{ $review->feedback ?: '-' }}</p>
                            </div>
                            <div class="p-4 border rounded-xl border-slate-200">
                                <h6 class="text-sm font-semibold text-slate-600">Status</h6>
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $review->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $review->status === 'approved' ? 'Verified' : ucfirst($review->status) }}
                                </span>
                            </div>
                            <div class="p-4 border rounded-xl border-slate-200">
                                <h6 class="text-sm font-semibold text-slate-600">Visible in App</h6>
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $review->show_dispaly ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $review->show_dispaly ? 'Visible' : 'Hidden' }}
                                </span>
                            </div>
                            <div class="p-4 border rounded-xl border-slate-200">
                                <h6 class="text-sm font-semibold text-slate-600">Created At</h6>
                                <p class="mt-2 text-sm text-slate-800">{{ optional($review->created_at)->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
