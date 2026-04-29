@extends('layouts.layout')
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
    <div class="container-fluid px-6 py-4">


        <div class="w-full px-6  mx-auto">

            <div class="flex flex-wrap -mx-3 mt-4">

                <div class="flex-none w-full max-w-full px-3">

                    {{-- Table --}}
                    <div
                        class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                        <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                            <div class="flex flex-col border-bottom mb-2">
                                <div class="w-full max-w-full mb-3 flex justify-between">
                                    <h6 class="dark:text-white">Course Requests (Leads)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto px-0 pt-0 pb-2">
                            <div class="p-4 overflow-x-auto">
                                <table
                                    class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                    <thead class="align-bottom">
                                        <tr>
                                            <th
                                                class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                #</th>
                                            <th
                                                class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                Course</th>
                                            <th
                                                class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                User</th>
                                            <th
                                                class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                Requested At</th>
                                            <th
                                                class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                Status</th>
                                            <th
                                                class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y">
                                        @forelse ($requests ?? [] as $key => $request)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2">
                                                    {{ $requests->firstItem() + $key }}
                                                </td>

                                                <td class="px-4 py-2">
                                                    {{ $request->course->title ?? 'N/A' }}
                                                </td>

                                                <td class="px-4 py-2 capitalize">
                                                    {{ $request->name }}/{{ $request->phone }}
                                                </td>

                                                <td class="px-4 py-2 text-gray-500">
                                                    {{ $request->created_at }}
                                                </td>
                                                <td class="px-4 py-2 text-gray-500">
                                                    {{ $request->status }}
                                                </td>

                                                <td>
                                                    <button onclick="openModal({{ $request->id }})"
                                                        class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
                                                        Update
                                                    </button>
                                                </td>

                                            </tr>

                                            {{-- MODAL --}}
                                            <div id="modal_{{ $request->id }}"
                                                class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                                                <div class="bg-white rounded-xl p-5 w-96">
                                                    <h3 class="font-semibold mb-3">Update Lead</h3>

                                                    <form method="POST"
                                                        action="{{ route('company.requests.courses.update', $request->id) }}">
                                                        @csrf

                                                        <label class="block text-sm mb-1">Status</label>
                                                        <select name="status" class="w-full border rounded px-3 py-2 mb-3">
                                                            @foreach (array_keys($statusColors) as $status)
                                                                <option value="{{ $status }}"
                                                                    {{ $request->status === $status ? 'selected' : '' }}>
                                                                    {{ str_replace('_', ' ', $status) }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <label class="block text-sm mb-1">Note</label>
                                                        <textarea name="note" class="w-full border rounded px-3 py-2" rows="3">{{ $request->note }}</textarea>

                                                        <div class="flex justify-end gap-2 mt-4">
                                                            <button type="button"
                                                                onclick="closeModal({{ $request->id }})"
                                                                class="px-4 py-2 bg-gray-200 rounded">
                                                                Cancel
                                                            </button>
                                                            <button class="px-4 py-2 bg-green-600 text-white rounded">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-6 text-gray-500">
                                                    No teacher class requests found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                </div>
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
