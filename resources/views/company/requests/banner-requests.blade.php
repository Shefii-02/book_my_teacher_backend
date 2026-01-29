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
@extends('layouts.layout')

@section('content')
<div class="w-full px-6 py-6 mx-auto">

    <div class="bg-white rounded-2xl shadow-xl p-5">
        <h2 class="text-xl font-bold mb-4">📋 Class Requests (Leads)</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">Student</th>
                        <th>Location</th>
                        <th>Grade</th>
                        <th>Board</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($requests as $lead)
                    <tr class="border-b">
                        <td class="p-3">
                            <div class="font-semibold">{{ $lead->user->name ?? '—' }}</div>
                            <div class="text-xs text-gray-500">{{ $lead->user->phone ?? '' }}</div>
                        </td>

                        <td>{{ $lead->from_location }}</td>
                        <td>{{ $lead->grade }}</td>
                        <td>{{ $lead->board }}</td>
                        <td>{{ $lead->subject }}</td>

                        <td>
                            <span class="px-3 py-1 rounded-full text-xs
                                {{ $statusColors[$lead->status] ?? 'bg-gray-200' }}">
                                {{ str_replace('_',' ', $lead->status) }}
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
                    <div id="modal_{{ $lead->id }}" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                        <div class="bg-white rounded-xl p-5 w-96">
                            <h3 class="font-semibold mb-3">Update Lead</h3>

                            <form method="POST" action="{{ route('company.requests.top-banner.update', $lead->id) }}">
                                @csrf

                                <label class="block text-sm mb-1">Status</label>
                                <select name="status" class="w-full border rounded px-3 py-2 mb-3">
                                    @foreach (array_keys($statusColors) as $status)
                                        <option value="{{ $status }}" {{ $lead->status === $status ? 'selected' : '' }}>
                                            {{ str_replace('_',' ', $status) }}
                                        </option>
                                    @endforeach
                                </select>

                                <label class="block text-sm mb-1">Note</label>
                                <textarea name="note" class="w-full border rounded px-3 py-2"
                                    rows="3">{{ $lead->note }}</textarea>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" onclick="closeModal({{ $lead->id }})"
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
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
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
