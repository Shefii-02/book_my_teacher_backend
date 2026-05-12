@extends('layouts.teacher')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        {{-- HEADER --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 p-8 shadow-2xl mb-6">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                <div>
                    <h2 class="text-3xl font-bold text-white">
                        Payment Transfers
                    </h2>

                    <p class="text-white/80 mt-2">
                        Manage teacher transfer history and payout requests
                    </p>
                </div>

                <a href="{{ route('teacher.payment-transfer.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-slate-800 font-semibold shadow-xl hover:scale-105 duration-300">

                    <i class="fas fa-plus"></i>

                    New Transfer
                </a>

            </div>

        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <div
                class="rounded-3xl border border-white/20 bg-white/70 backdrop-blur-xl shadow-2xl p-6 relative overflow-hidden">

                <div
                    class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-emerald-500/20 blur-2xl">
                </div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">
                                Total Earnings
                            </p>

                            <h3 class="text-3xl font-bold text-slate-800 mt-2">
                                ₹{{ number_format($totalEarning,2) }}
                            </h3>

                        </div>

                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg">

                            <i class="fas fa-wallet text-xl"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div
                class="rounded-3xl border border-white/20 bg-white/70 backdrop-blur-xl shadow-2xl p-6 relative overflow-hidden">

                <div
                    class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-blue-500/20 blur-2xl">
                </div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">
                                Total Transferred
                            </p>

                            <h3 class="text-3xl font-bold text-slate-800 mt-2">
                                ₹{{ number_format($totalTransferred,2) }}
                            </h3>

                        </div>

                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-lg">

                            <i class="fas fa-money-bill-wave text-xl"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div
                class="rounded-3xl border border-white/20 bg-white/70 backdrop-blur-xl shadow-2xl p-6 relative overflow-hidden">

                <div
                    class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-orange-500/20 blur-2xl">
                </div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">
                                Available Balance
                            </p>

                            <h3 class="text-3xl font-bold text-slate-800 mt-2">
                                ₹{{ number_format($availableBalance,2) }}
                            </h3>

                        </div>

                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-orange-500 to-pink-500 flex items-center justify-center text-white shadow-lg">

                            <i class="fas fa-coins text-xl"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div
            class="rounded-3xl border border-white/20 bg-white/70 backdrop-blur-xl shadow-2xl overflow-hidden">

            <div class="p-6 border-b border-slate-200/60">

                <div class="flex items-center justify-between">

                    <div>
                        <h4 class="text-xl font-bold text-slate-800">
                            Recent Transfers
                        </h4>

                        <p class="text-slate-500 text-sm mt-1">
                            Latest transfer records
                        </p>
                    </div>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-100/80">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Transfer No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Amount
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Charge
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Final
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Method
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase">
                                Date
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 uppercase">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($transfers as $transfer)

                            <tr class="border-b border-slate-100 hover:bg-slate-50/60 duration-200">

                                <td class="px-6 py-5">

                                    <div class="font-bold text-slate-700">
                                        {{ $transfer->transfer_no }}
                                    </div>

                                </td>

                                <td class="px-6 py-5 font-semibold text-slate-700">
                                    ₹{{ number_format($transfer->amount,2) }}
                                </td>

                                <td class="px-6 py-5 text-red-500 font-semibold">
                                    ₹{{ number_format($transfer->charge_amount,2) }}
                                </td>

                                <td class="px-6 py-5 text-emerald-600 font-bold">
                                    ₹{{ number_format($transfer->final_amount,2) }}
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="px-3 py-1 rounded-xl text-xs font-bold bg-blue-100 text-blue-600 uppercase">

                                        {{ $transfer->transfer_method }}

                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    @php

                                        $statusClass = match($transfer->status) {

                                            'completed' => 'bg-emerald-100 text-emerald-600',

                                            'pending' => 'bg-orange-100 text-orange-600',

                                            'processing' => 'bg-blue-100 text-blue-600',

                                            'failed' => 'bg-red-100 text-red-600',

                                            default => 'bg-slate-100 text-slate-600'

                                        };

                                    @endphp

                                    <span class="px-3 py-1 rounded-xl text-xs font-bold {{ $statusClass }}">
                                        {{ ucfirst($transfer->status) }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-slate-500 text-sm">
                                    {{ date('d M Y', strtotime($transfer->created_at)) }}
                                </td>

                                <td class="px-6 py-5 text-right">

                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('teacher.payment-transfer.edit',$transfer->id) }}"
                                            class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center hover:scale-110 duration-300">

                                            <i class="fas fa-edit"></i>

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-20">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mb-4">

                                            <i class="fas fa-folder-open text-4xl text-slate-400"></i>

                                        </div>

                                        <h4 class="text-xl font-bold text-slate-600">
                                            No Transfers Found
                                        </h4>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-6">
                {{ $transfers->links() }}
            </div>

        </div>

    </div>
@endsection
