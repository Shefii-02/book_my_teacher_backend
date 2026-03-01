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
                aria-current="page">Teachers</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teachers List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Teachers List</h6>
                            <a href="{{ route('company.app.teachers.create') }}"
                                class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-plus me-1 "></i>
                                Create
                            </a>
                        </div>
                    </div>

                </div>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">

                    <form method="GET" action="{{ route('company.app.teachers.index') }}">

                        <div class="grid grid-cols-6 md:grid-cols-6 gap-3 align-center">

                            {{-- Search --}}
                            <div class="md:col-span-2">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search name, email, mobile..."
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 outline-none">
                            </div>

                            {{-- Grade --}}
                            <div>
                                <select name="grade" class="w-full border rounded-lg px-3 py-2 text-sm">
                                    <option value="">All Grades</option>
                                    @foreach ($grades as $g)
                                        <option value="{{ $g->id }}"
                                            {{ request('grade') == $g->id ? 'selected' : '' }}>
                                            {{ $g->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Board --}}
                            <div>
                                <select name="board" class="w-full border rounded-lg px-3 py-2 text-sm">
                                    <option value="">All Boards</option>
                                    @foreach ($boards as $b)
                                        <option value="{{ $b->id }}"
                                            {{ request('board') == $b->id ? 'selected' : '' }}>
                                            {{ $b->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Subject --}}
                            <div>
                                <select name="subject" class="w-full border rounded-lg px-3 py-2 text-sm">
                                    <option value="">All Subjects</option>
                                    @foreach ($subjects as $s)
                                        <option value="{{ $s->id }}"
                                            {{ request('subject') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Rating --}}
                            <div>
                                <select name="rating" class="w-full border rounded-lg px-3 py-2 text-sm">
                                    <option value="">All Ratings</option>
                                    <option value="4">4★ & Above</option>
                                    <option value="3">3★ & Above</option>
                                    <option value="2">2★ & Above</option>
                                    <option value="2">1★</option>
                                </select>
                            </div>
                            <div>
                                <div class="flex justify-end  gap-2">
                                    <a href="{{ route('company.app.teachers.index') }}"
                                        class="p-2 text-sm bg-danger rounded text-light">
                                        Reset
                                    </a>

                                    <button type="submit" class="p-2 text-sm bg-success text-light rounded">
                                        Apply Filter
                                    </button>
                                </div>
                            </div>

                        </div>



                    </form>
                    {{-- </div> --}}

                    <div class="space-y-4 mt-5">

                        @forelse ($teachers as $t)
                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">

                                {{-- Dropdown Top Right --}}
                                <div class="absolute top-4 right-4">
                                    <button data-dropdown-toggle="dropdown_{{ $t->id }}"
                                        class="p-2 rounded-lg hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-width="2"
                                                d="M12 6h.01M12 12h.01M12 18h.01" />
                                        </svg>
                                    </button>

                                    <div id="dropdown_{{ $t->id }}"
                                        class="hidden absolute right-0 mt-2 bg-white shadow-xl rounded-xl w-44 z-10 border">
                                        <ul class="text-sm text-gray-700">

                                            <li> <a href="{{ route('company.app.teachers.edit', $t->id) }}"
                                                    class="block px-4 py-2 hover:bg-gray-100">Edit</a> </li>
                                            <li> <a role="button"
                                                    data-url="{{ route('company.app.teachers.login-security', $t->user_id) }}"
                                                    class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">Login
                                                    Security</a> </li>
                                            <li> <a role="button"
                                                    data-url="{{ route('company.app.teachers.grades.edit', $t->user_id) }}"
                                                    class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">
                                                    Teaching Grades</a> </li>
                                            <li> <a role="button"
                                                    data-url="{{ route('company.app.teachers.slots.edit', $t->user_id) }}"
                                                    class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">
                                                    Teaching Slots</a> </li>
                                            <li>
                                                <form id="form_{{ $t->id }}" method="POST"
                                                    action="{{ route('company.app.teachers.destroy', $t->id) }}"> @csrf
                                                    @method('DELETE') </form> <a
                                                    onclick="confirmDelete({{ $t->id }})"
                                                    class="block px-4 py-2 hover:bg-gray-100" role="button">Delete</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                {{-- Main Content --}}
                                <div class="flex items-start gap-4">
                                    <div class="flex flex-col gap-2 ">

                                        {{-- Profile --}}
                                        <img src="{{ $t->thumbnail_url }}"
                                            class="h-16 w-16 rounded-xl object-cover shadow" />
                                        @if ($t->published)
                                            <span
                                                class="bg-success text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="bg-danger text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                                                Disabled
                                            </span>
                                        @endif

                                    </div>
                                    {{-- Details --}}
                                    <div class="flex">

                                        {{-- Name + Status --}}
                                        <div class="flex items-center gap-3 me-3">
                                            <div class="text-base font-semibold text-gray-900">
                                                {{ $t->name }} <p class="text-xxs">
                                                    {{ $t->user->email }}<br>{{ $t->user->mobile }}</p>
                                            </div>


                                        </div>

                                        <p class="text-xs text-gray-500 mt-1">{{ $t->email }}</p>

                                        {{-- Info Row --}}
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-xs">

                                            <div>
                                                <p class="text-gray-400">Grades</p>
                                                <p class="font-medium text-gray-700">
                                                    {{ implodeComma($t->teachingGrades?->pluck('name')) ?: '-' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-gray-400">Boards</p>
                                                <p class="font-medium text-gray-700">
                                                    {{ implodeComma($t->teachingBoards?->pluck('name')) ?: '-' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-gray-400">Courses</p>
                                                <p class="font-medium text-gray-700">
                                                    {{ $t->courses()->count() }} Total
                                                    • {{ $t->courses->where('ended_at', '>=', date('Y-m-d'))->count() }}
                                                    Ongoing
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-gray-400">Earnings</p>
                                                <p class="font-semibold text-gray-900">
                                                    ₹{{ number_format($t->earnings_total, 0) }}
                                                </p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty
                            <div class="text-center py-10 text-gray-400 bg-white rounded-xl shadow">
                                No teachers found
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            function toggleModes(card) {
                const subject = card.find('.subject-checkbox');
                const modes = card.find('.online-toggle, .offline-toggle');

                if (subject.is(':checked')) {
                    modes.prop('disabled', false);
                } else {
                    modes.prop('disabled', true).prop('checked', false);
                }
            }

            // On load (existing data)
            $('.subject-checkbox').each(function() {
                toggleModes($(this).closest('label'));
            });

            // On change
            $('body').on('change', '.subject-checkbox', function() {
                toggleModes($(this).closest('div'));
            });

        });
    </script>
@endpush
