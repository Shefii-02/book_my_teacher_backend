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
                aria-current="page">Edit Review #{{ $review->id }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Edit Review Status</h6>
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
                                <h6>Edit Review Status</h6>
                                <p class="mb-4 text-sm text-slate-500">Change the approval state for this review.</p>
                            </div>
                            <a href="{{ route('company.app.app-reviews.show', $review->id) }}"
                                class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700">View</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('company.app.app-reviews.update', $review->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="p-4 border rounded-xl border-slate-200 md:col-span-2">
                                    <h6 class="text-sm font-semibold text-slate-600">Review Summary</h6>
                                    <p class="mt-2 text-sm text-slate-800"><strong>User:</strong> {{ $review->user?->name ?? '-' }}</p>
                                    <p class="mt-2 text-sm text-slate-800"><strong>Rating:</strong> {{ $review->rating ?? '-' }}</p>
                                    <p class="mt-2 text-sm text-slate-800"><strong>Feedback:</strong> {{ $review->feedback ?: '-' }}</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-slate-700" for="status">Status</label>
                                    <select id="status" name="status"
                                        class="w-full px-3 py-2 border rounded-lg border-slate-300 focus:border-emerald-500 focus:outline-none">
                                        <option value="approved" {{ $review->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $review->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex items-center gap-3">
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-emerald-500/50 hover:bg-emerald-600">Save Status</button>
                                <a href="{{ route('company.app.app-reviews.index', ['tab' => $review->status === 'approved' ? 'verified' : 'pending']) }}"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
