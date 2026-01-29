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

        {{-- Page Title --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Teacher Class Requests</h2>
        </div>

        {{-- Table --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Teacher</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Selected Items</th>
                        <th class="px-4 py-3">Class Type</th>
                        <th class="px-4 py-3">Days Needed</th>
                        <th class="px-4 py-3">Notes</th>
                        <th class="px-4 py-3">Requested By</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($requests as $key => $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $requests->firstItem() + $key }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $request->teacher->name ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-2 capitalize">
                                {{ $request->type }}
                            </td>

                            <td class="px-4 py-2">
                                @if (!empty($request->selected_items))
                                    <ul class="list-disc ml-4">
                                        @if (is_array($request->selected_items))
                                            @foreach ($request->selected_items as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        @else
                                            {{ $request->selected_items }}
                                        @endif
                                    </ul>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-2 capitalize">
                                {{ $request->class_type }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $request->days_needed ?? '-' }}
                            </td>

                            <td class="px-4 py-2">
                                @if ($request->notes)
                                    <span title="{{ $request->notes }}">
                                        {{ Str::limit($request->notes, 40) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-2">
                                {{ $request->user->name ?? 'User' }}
                            </td>

                            <td class="px-4 py-2 text-gray-500">
                                {{ $request->created_at }}
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

                                <form method="POST" action="{{ route('company.requests.teacher-class.update', $request->id) }}">
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
                                        <button type="button" onclick="closeModal({{ $request->id }})"
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

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $requests->links() }}
        </div>

    </div>

<script>
function openModal(id){
    document.getElementById('modal_'+id).classList.remove('hidden');
}
function closeModal(id){
    document.getElementById('modal_'+id).classList.add('hidden');
}
</script>
@endsection
