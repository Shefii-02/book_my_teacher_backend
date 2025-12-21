@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white capitalize before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Reviews List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Reviews List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Subject Reviews List</h6>
                            <a href="{{ route('company.app.reviews.create') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="flex-auto px-3 pt-3 pb-2 overflow-x-auto">
                        <table class="items-center w-full my-5 text-slate-500 align-top border-collapse">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        ID</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Subject</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Teacher</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Comments</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Rating</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Created At</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($reviews as $review)
                                    <tr>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">{{ $review->id }}
                                        </td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $review->subject?->name ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $review->user?->name ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $review->teacher?->name ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $review->comments }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">{{ $review->rating }}
                                        </td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $review->created_at }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70 space-x-2">
                                            <a href="{{ route('company.app.reviews.edit', $review->id) }}"
                                                class="text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('company.app.reviews.destroy', $review->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">No reviews
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>

                </div>
            @endsection
