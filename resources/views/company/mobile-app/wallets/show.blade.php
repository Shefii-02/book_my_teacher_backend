@extends('company.layouts.app')

@section('content')
<div class="p-6 bg-white shadow-xl rounded-xl">

    <h2 class="text-xl font-bold mb-4">
        Wallet Details – {{ $wallet->user->name }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

        <div class="p-4 bg-emerald-50 border rounded-xl">
            <h3 class="font-bold text-emerald-700 mb-2">Green Coins</h3>
            <p class="text-3xl font-bold">{{ $wallet->green_balance }}</p>
        </div>

        <div class="p-4 bg-blue-50 border rounded-xl">
            <h3 class="font-bold text-blue-700 mb-2">Rupees</h3>
            <p class="text-3xl font-bold">₹{{ $wallet->rupee_balance }}</p>
        </div>
    </div>

    {{-- Green Coin History --}}
    <h3 class="font-bold text-lg text-emerald-700 mt-4 mb-2">Green Coin History</h3>
    <table class="min-w-full table-auto border mb-6">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Type</th>
                <th class="p-2 border">Amount</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($greenHistory as $row)
            <tr>
                <td class="p-2 border">{{ $row->title }}</td>
                <td class="p-2 border">{{ ucfirst($row->type) }}</td>
                <td class="p-2 border">{{ $row->amount }}</td>
                <td class="p-2 border">{{ $row->status }}</td>
                <td class="p-2 border">{{ $row->date }}</td>
            </tr>
            @empty
            <tr><td class="p-3 border text-center" colspan="5">No records</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Rupee History --}}
    <h3 class="font-bold text-lg text-blue-700 mt-4 mb-2">Rupee History</h3>
    <table class="min-w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Type</th>
                <th class="p-2 border">Amount</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rupeeHistory as $row)
            <tr>
                <td class="p-2 border">{{ $row->title }}</td>
                <td class="p-2 border">{{ ucfirst($row->type) }}</td>
                <td class="p-2 border">₹{{ $row->amount }}</td>
                <td class="p-2 border">{{ $row->status }}</td>
                <td class="p-2 border">{{ $row->date }}</td>
            </tr>
            @empty
            <tr><td class="p-3 border text-center" colspan="5">No records</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
