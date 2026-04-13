@extends('layouts.layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>

            <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>

            <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
                Course Admissions
            </li>
        </ol>

        <h6 class="mb-0 font-bold text-white">Course Admissions Listing</h6>
    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div
            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-2 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex">
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <h6 class="dark:text-white">Course Admissions</h6>
                    </div>
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                    </div>
                    <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4">


                        <a href="{{ route('company.courses.index') }}"
                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded text-sm">
                            <i class="bi bi-arrow-left me-2"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUMMARY CARDS -->

        <div class="flex flex-wrap -mx-3 mb-6">

            <div class="w-full px-3 sm:w-1/2 xl:w-1/4 mb-4">
                <div class="bg-white shadow rounded-xl p-4">
                    <p class="text-sm">Total</p>
                    <h4 class="font-bold">{{ $data['total_courses'] ?? 0 }}</h4>
                </div>
            </div>

            <div class="w-full px-3 sm:w-1/2 xl:w-1/4 mb-4">
                <div class="bg-white shadow rounded-xl p-4">
                    <p class="text-sm">Active</p>
                    <h4 class="font-bold">{{ $data['active'] ?? 0 }}</h4>
                </div>
            </div>

            <div class="w-full px-3 sm:w-1/2 xl:w-1/4 mb-4">
                <div class="bg-white shadow rounded-xl p-4">
                    <p class="text-sm">Expiring Soon</p>
                    <h4 class="font-bold">{{ $data['expiring'] ?? 0 }}</h4>
                </div>
            </div>

            <div class="w-full px-3 sm:w-1/2 xl:w-1/4 mb-4">
                <div class="bg-white shadow rounded-xl p-4">
                    <p class="text-sm">Suspended</p>
                    <h4 class="font-bold">{{ $data['suspended'] ?? 0 }}</h4>
                </div>
            </div>

        </div>


        <!-- MAIN PANEL -->

        <div class="bg-white shadow rounded-xl p-6">

            <div class="flex justify-between">

                <!-- TABS -->
                <div class="flex mb-4">

                    <a href="?status=active"
                        class="px-3 py-2  text-sm {{ $status == 'active' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Active ({{ $data['active'] }})
                    </a>

                    <a href="?status=expiring"
                        class="px-3 py-2  text-sm {{ $status == 'expiring' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Expiring Soon ({{ $data['expiring'] }})
                    </a>

                    <a href="?status=inactive"
                        class="px-3 py-2  text-sm {{ $status == 'inactive' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Inactive ({{ $data['inactive'] }})
                    </a>

                    <a href="?status=suspended"
                        class="px-3 py-2  text-sm {{ $status == 'suspended' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Suspended ({{ $data['suspended'] }})
                    </a>

                    <a href="?status=removed"
                        class="px-3 py-2  text-sm {{ $status == 'removed' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Removed ({{ $data['removed'] }})
                    </a>

                </div>


                <!-- SEARCH -->
                <form method="GET" class="flex gap-2 mb-4">

                    <input type="hidden" name="status" value="{{ $status }}">

                    <input type="search" autocomplete="off" name="search" value="{{ $search }}"
                        placeholder="Search name / email / phone" class="border px-3 py-2 rounded w-64">

                    <button class="bg-blue-500 text-white px-4 py-2 rounded">
                        Search
                    </button>

                </form>


            </div>

            <div class="mt-2">
                @php
                    $activeFilters = collect(request()->only(['search']))->filter(fn($value) => filled($value)); // remove null/empty
                @endphp

                @if ($activeFilters->isNotEmpty())
                    <div class="mb-4  flex flex-wrap gap-2">
                        @foreach ($activeFilters as $key => $value)
                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center">
                                <span class="mr-2 capitalize">{{ str_replace('_', ' ', $key) }}:
                                    {{ $value }}</span>
                                <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                                    class="text-red-500 hover:text-red-700 font-bold">×</a>
                            </div>
                        @endforeach
                        <a href="{{ route('company.teachers.index') }}" class="ml-3 mt-2.5 text-sm text-red-600">Clear
                            All</a>
                    </div>
                @endif
            </div>


            <!-- TABLE -->

            <div class="overflow-x-auto">

                <table class="w-full border">

                    <thead class="bg-gray-100">

                        <tr>
                            <th class="p-3 text-left">Student</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Mobile</th>
                            <th class="p-3 text-left">Start</th>
                            <th class="p-3 text-left">Expiry</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Payment</th>
                            <th class="p-3 text-left">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($enrollments as $enroll)
                            <tr class="border-t" id="row{{ $enroll->id }}">

                                <td class="p-3">

                                    <div class="flex items-center gap-3">

                                        <img src="{{ $enroll->user->profile ?? '/default.png' }}"
                                            class="w-10 h-10 rounded-full">

                                        <div>
                                            <div class="font-semibold">
                                                {{ $enroll->user->name }}
                                            </div>

                                            <div class="text-xs text-gray-500">
                                                Joined {{ $enroll->created_at->format('d M Y') }}
                                            </div>
                                        </div>

                                    </div>

                                </td>

                                <td class="p-3">
                                    {{ $enroll->user->email }}
                                </td>

                                <td class="p-3">
                                    {{ $enroll->user->phone }}
                                </td>

                                <td class="p-3">
                                    {{ $enroll->start_date ?? '-' }}
                                </td>

                                <td class="p-3">

                                    @if ($enroll->expiry_date)
                                        @php
                                            $days = \Carbon\Carbon::parse($enroll->expiry_date)->diffInDays(
                                                now(),
                                                false,
                                            );
                                        @endphp

                                        <span class="{{ $days < 7 ? 'text-red-600 font-semibold' : '' }}">
                                            {{ $enroll->expiry_date }}
                                        </span>
                                    @else
                                        -
                                    @endif

                                </td>


                                <td class="p-3">

                                    @if ($enroll->status == 'active')
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                            Active
                                        </span>
                                    @elseif($enroll->status == 'suspended')
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                            Suspended
                                        </span>
                                    @elseif($enroll->status == 'expired')
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                            Expired
                                        </span>
                                    @endif

                                </td>


                                <td class="p-3">

                                    @if ($enroll->payment_status == 'paid')
                                        <span class="text-green-600 text-xs font-semibold">
                                            Paid
                                        </span>
                                    @else
                                        <span class="text-red-600 text-xs font-semibold">
                                            Unpaid
                                        </span>
                                    @endif

                                </td>


                                <td class="p-3 space-x-1">

                                    <button class="px-2 py-1 text-xs bg-yellow-500 text-white rounded suspendBtn"
                                        data-id="{{ $enroll->id }}" data-url="{{ route('company.courses.admissions.suspend', ['identity' => $enroll->course->course_identity, 'id' => $enroll->id]) }}">
                                        Suspend
                                    </button>

                                    <form action="{{ route('company.courses.enrollments.destroy', ['identity' => $enroll->course->course_identity, 'id' => $enroll->id]) }}"
                                        method="POST" id="form_{{ $enroll->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $enroll->id }})"
                                            class="w-full text-left px-2 py-1 text-xxs bg-red-500 text-white rounded">
                                            Remove
                                        </button>
                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-6 text-gray-500">
                                    No students found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- PAGINATION -->

            <div class="mt-4">
                {{ $enrollments->appends(request()->query())->links() }}
            </div>


        </div>

    </div>
@endsection



@push('scripts')
    <script>
        document.querySelectorAll('.suspendBtn').forEach(btn => {

            btn.addEventListener('click', function() {

                let url = this.dataset.url;
                let id = this.dataset.id;

                let reason = prompt("Enter suspension reason");

                if (!reason) return;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id,
                            reason: reason
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })

            })

        })
    </script>


    <script>
        document.querySelectorAll('.removeBtn').forEach(btn => {

            btn.addEventListener('click', function() {

                let id = this.dataset.id;

                if (!confirm('Remove this user?')) return;

                fetch('/admission/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('row' + id).remove();
                        }
                    })

            })

        })
    </script>
@endpush
