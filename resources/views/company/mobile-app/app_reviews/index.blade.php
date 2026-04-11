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
                aria-current="page">App Reviews</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">App Reviews</h6>
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
                                <h6>App Reviews</h6>
                                <p class="mb-4 text-sm text-slate-500">Manage pending reviews and app display order for
                                    verified reviews.</p>
                            </div>


                        </div>
                    </div>

                </div>

                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="px-6 pt-4">
                        <form method="GET" action="{{ route('company.app.app-reviews.index') }}"
                            class="flex flex-col gap-4 lg:flex-row lg:items-end">
                            <input type="hidden" name="tab" value="{{ $tab }}">

                            <div class="w-1/2 lg:max-w-sm">
                                <label class="block mb-1 text-sm font-medium text-slate-700">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="User, mobile, email, feedback, rating"
                                    class="w-full px-3 py-2 border rounded-lg border-slate-300 focus:border-emerald-500 focus:outline-none">
                            </div>

                            <div class="w-1/2 lg:max-w-xs">
                                <label class="block mb-1 text-sm font-medium text-slate-700">Created Date Order</label>
                                <select name="sort"
                                    class="px-3 py-2 w-full border rounded-lg border-slate-300 focus:border-emerald-500 focus:outline-none">
                                    @if ($tab === 'verified')
                                        <option value="app_order" {{ $sort === 'app_order' ? 'selected' : '' }}>App Order
                                        </option>
                                    @endif
                                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                </select>
                            </div>

                            <div style="gap: .5rem !important;display: flex;align-items: end;">
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-emerald-500/50">
                                    Filter
                                </button>
                                <a href="{{ route('company.app.app-reviews.index', ['tab' => $tab]) }}"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex mb-4 mt-2 px-4">
                            <a href="{{ route('company.app.app-reviews.index', array_merge(request()->query(), ['tab' => 'pending'])) }}"
                                class="px-4 py-2  text-sm font-semibold  {{ $tab === 'pending' ? 'bg-yellow-500 text-white' : ' bg-gray-200' }}">
                                Pending
                            </a>
                            <a href="{{ route('company.app.app-reviews.index', array_merge(request()->query(), ['tab' => 'verified'])) }}"
                                class="px-4 py-2  text-sm font-semibold  {{ $tab === 'verified' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                                Verified
                            </a>
                        </div>
                    </div>

                    @if ($tab === 'verified')
                        <div class="px-6 pt-4">
                            <div
                                class="px-4 py-3 text-sm border rounded-xl border-emerald-100 bg-emerald-50 text-emerald-700">
                                Drag and drop verified reviews to set the order shown in the app.
                            </div>
                        </div>
                    @endif

                    <div class="flex-auto px-3 pb-2 overflow-x-auto">
                        <table class="items-center w-full  text-slate-500 align-top border-collapse">
                            <thead class="align-bottom">
                                <tr>
                                    @if ($tab === 'verified')
                                        <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Move</th>
                                        {{-- <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Order</th> --}}
                                    @endif
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">ID</th>
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">User</th>
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Feedback</th>
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Rating</th>
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Created Date
                                    </th>
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Status</th>
                                    <th class="px-4 py-3 font-bold text-left text-xxs uppercase opacity-70">Actions</th>
                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-gray-200 {{ $tab === 'verified' ? 'sortable-review-body' : '' }}">
                                @forelse ($reviews as $review)
                                    <tr class="{{ $tab === 'verified' ? 'review-row cursor-move' : '' }}"
                                        data-id="{{ $review->id }}">
                                        @if ($tab === 'verified')
                                            <td class="px-4 py-4 text-sm whitespace-nowrap text-slate-400">
                                                <i class="bi bi-arrows-move text-lg" title="Drag to reorder"></i>
                                            </td>
                                            {{-- <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 current-order">
                                                    {{ $review->position ?: '-' }}
                                                </span>
                                            </td> --}}
                                        @endif

                                        <td class="px-4 py-4 text-sm whitespace-nowrap text-slate-700">{{ $review->id }}
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-semibold text-slate-700">{{ $review->user?->name ?? '-' }}</span>
                                                <span
                                                    class="text-xs text-slate-500">{{ $review->user?->email ?? ($review->user?->mobile ?? '-') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-slate-700 min-w-[280px]">
                                            {{ $review->feedback ?: '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap text-slate-700">
                                            {{ $review->rating ?: '-' }}</td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap text-slate-700">
                                            {{ optional($review->created_at)->format('d M Y, h:i A') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $review->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ $review->status === 'approved' ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('company.app.app-reviews.show', $review->id) }}"
                                                    class="text-blue-500 hover:text-blue-700">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('company.app.app-reviews.edit', $review->id) }}"
                                                    class="text-blue-500 hover:text-blue-700">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('company.app.app-reviews.destroy', $review->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700"
                                                        onclick="return confirm('Are you sure you want to delete this review?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $tab === 'verified' ? 9 : 7 }}"
                                            class="px-4 py-6 text-sm text-center text-slate-500">
                                            No {{ $tab === 'verified' ? 'verified' : 'pending' }} reviews found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($reviews->hasPages())
                        <div class="px-6 pb-6">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @if ($tab === 'verified')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            const reviewTableBody = document.querySelector('.sortable-review-body');

            if (reviewTableBody) {
                new Sortable(reviewTableBody, {
                    animation: 150,
                    onEnd: function() {
                        const positions = [];

                        document.querySelectorAll('.review-row').forEach((row, index) => {
                            positions.push(row.dataset.id);
                            const orderBadge = row.querySelector('.current-order');
                            if (orderBadge) {
                                orderBadge.textContent = index + 1;
                            }
                        });

                        fetch("{{ route('company.app.app-reviews.reorder') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                positions: positions
                            })
                        });
                    }
                });
            }
        </script>
    @endif
@endsection
