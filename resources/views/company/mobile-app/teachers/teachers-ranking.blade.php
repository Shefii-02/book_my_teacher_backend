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
                aria-current="page">Teachers Ranking</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teachers Ranking List</h6>
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
                                <h6>Teachers Ranking List</h6>
                            </div>
                            <div class="flex gap-3 items-center">

                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">

                    <form method="GET" id="filterForm" action="{{ route('company.app.teachers.ranking') }}">

                        <div class="flex gap-3 justify-between">
                            <div class="flex gap-3">
                                {{-- Search --}}
                                <div class="w-[272px]">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search name, email, mobile..."
                                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 outline-none">
                                </div>

                                {{-- Rating --}}
                                <div class="w-100">
                                    <select name="rating" class="w-full border rounded-lg px-3 py-2 text-sm">
                                        <option value="">All Ratings</option>
                                        <option value="4">4★ & Above</option>
                                        <option value="3">3★ & Above</option>
                                        <option value="2">2★ & Above</option>
                                        <option value="2">1★</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-end  gap-2">
                                    <a href="{{ route('company.app.teachers.ranking') }}"
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


                    <div class="space-y-4 mt-5" id="teacherTable">
                        @include('company.mobile-app.teachers.ranking-table')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-transparent bg-opacity-50 flex items-center justify-center">

        <form method="POST" id="editForm" class="bg-warning-subtle p-6 rounded w-96">
            @csrf

            <h3 class="text-lg font-bold mb-4">Update Ranking</h3>

            <input type="hidden" id="teacher_id">

            <div class="mb-3">
                <label>Ranking</label>
                <input type="number" name="ranking" id="ranking" class="w-full border px-3 py-2 rounded">
            </div>

            <div class="mb-3">
                <label>Rating</label>
                <input type="number" step="0.1" max="5" name="rating" id="rating"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()">Cancel</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>

    </div>
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {
            initInfiniteTable({
                container: '#teacherTable',
                form: '#filterForm',
                url: "{{ route('company.app.teachers.index') }}",
                liveSearch: true,
            });
        });
    </script>

    <script>
        function openEditModal(id, ranking, rating) {

            document.getElementById('ranking').value = ranking;
            document.getElementById('rating').value = rating;

            document.getElementById('editForm').action = "/company/app/teachers/ranking/update/" + id;

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
@endpush
