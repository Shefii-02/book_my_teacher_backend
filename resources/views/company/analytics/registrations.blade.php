@extends('layouts.layout')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="bg-white shadow-xl rounded-2xl p-4 mb-3">

            <h6 class="mb-4 font-bold">Registrations Report</h6>

            <form method="GET" class="flex flex-wrap gap-3 mb-4">

                <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-3 py-2 text-sm">

                <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-3 py-2 text-sm">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email/mobile"
                    class="border rounded px-3 py-2 text-sm w-64">

                 <button class="bg-blue-500 text-white px-4 py-2 rounded text-sm">
                    Filter
                </button>
                        {{-- ✅ Clear button only if filters applied --}}
                @if (request()->hasAny(['from', 'to', 'search']) && (request('from') || request('to') || request('search')))
                    <a href="{{ url()->current() }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
                        <span class=" text-orange-500 font-bold">
                            <i class="bi bi-x-lg"></i> Filters applied clear
                        </span>
                    </a>
                @endif
            </form>
        </div>
   <div class="bg-white shadow-xl rounded-2xl p-6">

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs uppercase text-gray-500 border-b">
                        <th class="p-2">Name</th>
                        <th class="p-2">Type</th>
                        <th class="p-2">Status</th>
                        <th class="p-2">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($registrations as $r)
                        <tr class="border-b">
                            <td class="p-2">
                                <div class="font-semibold">{{ $r->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $r->email ?? '' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $r->mobile ?? '' }}
                                </div>
                            </td>
                            <td class="p-2 capitalize">{{ $r->acc_type }}</td>
                            <td class="p-2">{{ $r->status }}</td>
                            <td class="p-2 text-xs">{{ $r->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $registrations->links() }}
            </div>

        </div>
    </div>
@endsection
