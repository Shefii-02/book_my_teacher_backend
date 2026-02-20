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
                aria-current="page">Request Form Lead List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Request Form Lead List</h6>
    </nav>
@endsection

@php
    $statusColors = [
        'PENDING' => 'bg-gray-200 text-gray-800',
        'NOT_CONNECTED' => 'bg-red-100 text-red-700',
        'CALL_BACK_LATER' => 'bg-yellow-100 text-yellow-700',
        'FOLLOW_UP_LATER' => 'bg-blue-100 text-blue-700',
        'DEMO_SCHEDULED' => 'bg-purple-100 text-purple-700',
        'CONVERTED_TO_ADMISSION' => 'bg-green-100 text-green-700',
        'CLOSED' => 'bg-slate-200 text-slate-700',
    ];
@endphp

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
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
                                        Total Leads</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['total']['teachers'] ?? 0 }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
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
                                        Pending </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['unverified']['teachers'] ?? 0 }}
                                    </h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                    <i class="ni ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
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
                                        Converted </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['verified']['teachers'] ?? 0 }}</h5>

                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                    <i class="ni ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
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
                                        Rejected </p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['rejected']['teachers'] ?? 0 }}</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="bi bi-ban text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- cards -->
    <div class="w-full px-6  mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">


                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex flex-col border-bottom mb-2">
                            <div class="w-full max-w-full mb-3 flex justify-between">
                                <h6 class="dark:text-white">Request From Class Requests (Leads)</h6>
                                <button class="btn bg-gradient-to-tl from-emerald-500 to-teal-400 text-light btn-sm"><i class="bi bi-plus"></i> Create</button>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            @php
                                $activeTab = request('tab', 'pending');
                            @endphp
                        </div>
                        <div class="flex justify-between items-end">
                            <div class="flex mb-4 mt-2">
                                <a href="{{ route('company.requests.form-class', array_merge(request()->query(), ['tab' => 'pending'])) }}"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                                    Pending
                                </a>

                                <a href="{{ route('company.requests.form-class', array_merge(request()->query(), ['tab' => 'approved'])) }}"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'approved' ? 'bg-emerald-500/50 text-white' : 'bg-gray-200' }}">
                                    Approved
                                </a>

                                <a href="{{ route('company.requests.form-class', array_merge(request()->query(), ['tab' => 'rejected'])) }}"
                                    class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                                    Rejected
                                </a>
                            </div>
                            <div class="">
                                <form method="GET" action="{{ route('company.requests.form-class') }}"
                                    class="mb-4 flex flex-wrap gap-3 items-end">
                                    <input type="hidden" name="tab" value="{{ $activeTab }}" />
                                    <!-- 🔍 Search (name, email, mobile) -->
                                    <div class="flex gap-2 items-center">
                                        <label class="block text-sm font-medium mb-1">Search</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search name, email, mobile" class="border rounded px-3 py-2 w-64">
                                    </div>

                                    <!-- Submit + Reset -->
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm"><i
                                                class="bi bi-search"></i> Apply</button>
                                        <a href="{{ route('company.teachers.index') }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  rounded text-white text-sm"><i
                                                class="bi bi-arrow-clockwise"></i> Reset </a>
                                        <a href="{{ route('company.teachers.export', request()->query()) }}"
                                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded text-sm">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>
                                            Export Excel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $activeFilters = collect(
                            request()->only(['search', 'teaching_mode', 'account_status', 'current_account_stage']),
                        )->filter(fn($value) => filled($value)); // remove null/empty
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
                            <a href="{{ route('company.teachers.index') }}"
                                class="ml-3 mt-2.5 text-sm text-red-600">Clear
                                All</a>
                        </div>
                    @endif


                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-4 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">

                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Student</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Location</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Grade</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Board</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Note</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($requests as $lead)
                                        <tr class="border-b">
                                            <td class="p-3">
                                                <div class="font-semibold">
                                                    <a href="{{ route('company.student-details', $lead->user->id) }}"
                                                        target="user-details">
                                                        {{ $lead->user->name ?? '—' }}</a>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $lead->user->phone ?? '' }}</div>
                                            </td>

                                            <td>{{ $lead->from_location }}</td>
                                            <td>{{ $lead->grade }}</td>
                                            <td>{{ $lead->board }}</td>
                                            <td>{{ $lead->subject }}</td>

                                            <td>
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs
                                {{ $statusColors[$lead->status] ?? 'bg-gray-200' }}">
                                                    {{ str_replace('_', ' ', $lead->status) }}
                                                </span>
                                            </td>

                                            <td class="max-w-xs text-xs">
                                                {{ $lead->note ?? '—' }}
                                            </td>

                                            <td>
                                                <button onclick="openModal({{ $lead->id }})"
                                                    class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
                                                    Update
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- MODAL --}}
                                        <div id="modal_{{ $lead->id }}"
                                            class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                                            <div class="bg-white rounded-xl p-5 w-96">
                                                <h3 class="font-semibold mb-3">Update Lead</h3>

                                                <form method="POST"
                                                    action="{{ route('company.requests.form-class.update', $lead->id) }}">
                                                    @csrf

                                                    <label class="block text-sm mb-1">Status</label>
                                                    <select name="status" class="w-full border rounded px-3 py-2 mb-3">
                                                        @foreach (array_keys($statusColors) as $status)
                                                            <option value="{{ $status }}"
                                                                {{ $lead->status === $status ? 'selected' : '' }}>
                                                                {{ str_replace('_', ' ', $status) }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <label class="block text-sm mb-1">Note</label>
                                                    <textarea name="note" class="w-full border rounded px-3 py-2" rows="3">{{ $lead->note }}</textarea>

                                                    <div class="flex justify-end gap-2 mt-4">
                                                        <button type="button" onclick="closeModal({{ $lead->id }})"
                                                            class="px-4 py-2 bg-gray-200 rounded">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-green-600 text-white rounded">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4">
                            {{ $requests->links() }}
                        </div>
                    </div>

                </div>
                <script>
                    function openModal(id) {
                        document.getElementById('modal_' + id).classList.remove('hidden');
                    }

                    function closeModal(id) {
                        document.getElementById('modal_' + id).classList.add('hidden');
                    }
                </script>
            @endsection
