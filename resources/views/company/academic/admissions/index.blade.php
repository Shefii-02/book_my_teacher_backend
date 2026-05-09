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
                aria-current="page">Recent Enroll List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Recent Enroll List</h6>
    </nav>
@endsection

@section('content')

    <!-- cards -->
    <div class="w-full px-6  mx-auto">


        <div
            class="relative flex flex-col min-w-0 my-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="p-4 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex">
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <h6 class="dark:text-white">Recent Enroll Lists</h6>
                    </div>
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                    </div>
                    <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4 mb-3">
                        <a href="{{ route('company.admissions.create') }}"
                            class="px-4 py-2 bg-gradient-to-tl  from-emerald-500 to-teal-400  text-white  text-sm">
                            <i class="bi bi-plus me-1"></i> Create Admission</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
            <!-- card1 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div class="">
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Enroll</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['enrolls']['total'] ?? 0 }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Course</span><br>
                                <span class="text-emerald-500">{{ $stats['enrolls']['course'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Workshop</span><br>
                                <span class="text-emerald-500">{{ $stats['enrolls']['workshop'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Webinar
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['enrolls']['webinar'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card2 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Teachers </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['teachers']['total'] }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                    <i class="ni ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Course</span><br>
                                <span class="text-emerald-500">{{ $stats['teachers']['course'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Workshop</span><br>
                                <span class="text-emerald-500">{{ $stats['teachers']['workshop'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Webinar
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['teachers']['webinar'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card3 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Student </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $stats['students']['total'] }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                    <i class="ni ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Course</span><br>
                                <span class="text-emerald-500">{{ $stats['students']['course'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Workshop</span><br>
                                <span class="text-emerald-500">{{ $stats['students']['workshop'] }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Webinar
                                </span><br>
                                <span class="text-emerald-500">{{ $stats['students']['webinar'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card4 -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Revenue </p>
                                    <h5 class="mb-2 font-bold dark:text-white"> ₹
                                        {{ number_format($stats['revenue']['total'], 2) }}</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="bi bi-ban text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-between">
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Course</span><br>
                                <span class="text-emerald-500">₹ {{ number_format($stats['revenue']['course'], 2) }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Workshop</span><br>
                                <span class="text-emerald-500">₹
                                    {{ number_format($stats['revenue']['workshop'], 2) }}</span>
                            </p>
                            <p class="mb-0 dark:text-white dark:opacity-60">
                                <span
                                    class="font-bold text-neutral-900 dark:text-white text-sm text-emerald-500 mr-2">Webinar
                                </span><br>
                                <span class="text-emerald-500">₹
                                    {{ number_format($stats['revenue']['webinar'], 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- table 1 -->
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">

                        @php
                            $activeTab = request('tab', 'all');
                        @endphp



                        <div class="flex justify-between items-center pb-2">

                            <div class="flex mb-4 mt-2">
                                <a href="{{ route('company.admissions.index') }}?tab=all"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'all' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                                    All
                                </a>

                                <a href="{{ route('company.admissions.index') }}?tab=courses"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'courses' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                                    Courses
                                </a>

                                <a href="{{ route('company.admissions.index') }}?tab=workshops"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'workshops' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                                    Workshops
                                </a>

                                <a href="{{ route('company.admissions.index') }}?tab=webinars"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'webinars' ? 'bg-emerald-500/50 text-white' : 'bg-gray-200' }}">
                                    Webinars
                                </a>
                            </div>

                        </div>

                        <div class="flex1">

                            <div class="w-full max-w-full ">
                                <form method="GET" action="{{ route('company.admissions.index') }}"
                                    class="mb-6 flex flex-wrap gap-4 items-end" id="filterForm">

                                    <!-- SEARCH -->
                                    <div>
                                        <label class="block text-sm font-semibold mb-1">Search</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Name / Email / Mobile" class="border rounded px-3 py-2 w-56">
                                    </div>

                                    <!-- ACC TYPE -->
                                    {{-- <div>
                                        <label class="block text-sm font-semibold mb-1">Acc Type</label>
                                        <select name="type" class="border rounded px-3 py-2 w-40">
                                            <option value="all">All</option>
                                            <option value="student" {{ request('type') == 'student' ? 'selected' : '' }}>
                                                Student</option>
                                            <option value="teacher" {{ request('type') == 'teacher' ? 'selected' : '' }}>
                                                Teacher</option>
                                        </select>
                                    </div> --}}

                                    <!-- STATUS -->
                                    {{-- <div>
                                        <label class="block text-sm font-semibold mb-1">Status</label>
                                        <select name="type" class="border rounded px-3 py-2 w-40">
                                            <option value="all">All</option>
                                            <option value="active" {{ request('type') == 'paid' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="suspended"
                                                {{ request('type') == 'pending' ? 'selected' : '' }}>Suspended</option>
                                            <option value="deleted"{{ request('type') == 'rejected' ? 'selected' : '' }}>
                                                Deleted</option>
                                        </select>
                                    </div> --}}

                                    <!-- START DATE -->
                                    <div>
                                        <label class="block text-sm font-semibold mb-1">Start Date</label>
                                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                                            class="border rounded px-3 py-2">
                                    </div>

                                    <!-- END DATE -->
                                    <div>
                                        <label class="block text-sm font-semibold mb-1">End Date</label>
                                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                                            class="border rounded px-3 py-2">
                                    </div>

                                    <!-- BUTTONS -->
                                    <div class="flex gap-2">

                                        <button type="submit"
                                            class="px-4 py-2 bg-emerald-500/50 text-white rounded text-sm">
                                            Search
                                        </button>

                                        <a href="{{ route('company.admissions.index') }}"
                                            class="px-4 py-2 bg-gray-500 text-white rounded text-sm">
                                            Reset
                                        </a>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $activeFilters = collect(request()->only(['search', 'type', 'start_date', 'end_date']))->filter(
                            fn($value) => filled($value),
                        ); // remove null/empty
                    @endphp

                    @if ($activeFilters->isNotEmpty())
                        <div class="mb-4 pl-9 flex flex-wrap gap-2">
                            @foreach ($activeFilters as $key => $value)
                                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center">
                                    <span class="mr-2 capitalize">{{ str_replace('_', ' ', $key) }}:
                                        {{ $value }}</span>
                                    <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                                        class="text-red-500 hover:text-red-700 font-bold">×</a>
                                </div>
                            @endforeach
                            <a href="" class="ml-3 mt-2.5 text-sm text-red-600">Clear
                                All</a>
                        </div>
                    @endif
                    <!-- Table -->
                    <div id="enrollTable">
                        @include('company.academic.admissions.enroll-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="hidden fixed inset-0 bg-black opacity-80 flex items-center justify-center">
        <form method="POST" action="{{ route('company.payments.reject') }}" class="bg-white p-6 rounded w-96">
            @csrf
            <input type="hidden" name="purchase_id" id="reject_purchase_id">

            <label class="block mb-2 font-bold">Reject Reason</label>
            <textarea name="notes" required class="w-full border rounded p-2"></textarea>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()">Close</button>
                <button class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        function openRejectModal(id) {
            document.getElementById('reject_purchase_id').value = id;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>

    <script>
        $(document).ready(function() {
            initInfiniteTable({
                container: '#enrollTable',
                form: '#filterForm',
                url: "{{ route('company.admissions.index') }}",
                tab: "{{ $activeTab }}",
                liveSearch: true,

            });
        });
    </script>
@endpush
