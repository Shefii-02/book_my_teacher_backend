@extends('layouts.layout')

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
                            <div>
                                <h6>Teachers List</h6>
                            </div>
                            <div class="flex gap-3 items-center">
                                {{-- <a href="{{ route('company.app.teachers.create') }}"
                                    class="bg-emerald-500/50 rounded text-sm text-white px-4 fw-bold py-1">
                                    <i class="bi bi-plus me-1 "></i>
                                    Create
                                </a> --}}
                                <a href="{{ route('company.app.teachers.search') }}"
                                    class="bg-gradient-to-tl from-blue-700 to-teal-400  rounded text-sm text-white px-4 fw-bold py-1">
                                    <i class="bi bi-search"></i>
                                    Filter Teachers</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flex justify-between items-center">
                    @php
                        $activeTab = request('tab', 'inactive');
                    @endphp

                    <div class="flex mb-4 mt-2">
                        <a href="{{ route('company.app.teachers.index', array_merge(request()->query(), ['tab' => 'inactive'])) }}"
                            class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'inactive' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                            In Active
                        </a>

                        <a href="{{ route('company.app.teachers.index', array_merge(request()->query(), ['tab' => 'active'])) }}"
                            class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'active' ? 'bg-emerald-500/50 text-white' : 'bg-gray-200' }}">
                            Active
                        </a>

                        <a href="{{ route('company.app.teachers.index', array_merge(request()->query(), ['tab' => 'suspended'])) }}"
                            class="px-4 py-2  text-sm font-semibold
                                    {{ $activeTab === 'suspended' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                            Suspended
                        </a>
                    </div>

                </div>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">

                    <form method="GET" id="filterForm" action="{{ route('company.app.teachers.index') }}">

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

                    <div class="space-y-4 mt-5" id="teacherTable">
                        @include('company.mobile-app.teachers.table')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script>
        $(document).ready(function() {
            initInfiniteTable({
                container: '#teacherTable',
                form: '#filterForm',
                url: "{{ route('company.app.teachers.index') }}",
                tab : "{{ $activeTab }}",
                liveSearch: true,
            });
        });
    </script>

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
