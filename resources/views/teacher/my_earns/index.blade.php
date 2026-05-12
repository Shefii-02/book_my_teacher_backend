@extends('layouts.teacher')

@section('nav-options')
<nav>

    <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg sm:mr-16">

        <li class="text-sm">
            <a class="text-white" href="#">
                Home
            </a>
        </li>

        <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
            Dashboard
        </li>

        <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
            My Earnings
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        My Earnings
    </h6>

</nav>
@endsection

@section('content')

<div class="w-full px-3 py-6 mx-auto">

    {{-- TOP STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-5 gap-3 mb-5">

        {{-- AVAILABLE --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-500 to-teal-400 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Available
                    </p>

                    <h2 class="text-3xl font-black mt-3">
                        ₹{{ number_format($data['available_balance'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-money-coins text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TOTAL --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-blue-500 to-cyan-400 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Total Earned
                    </p>

                    <h2 class="text-3xl font-black mt-3">
                        ₹{{ number_format($data['total_earnings'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-chart-bar-32 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- MONTH --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-violet-500 to-purple-500 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        This Month
                    </p>

                    <h2 class="text-3xl font-black mt-3">
                        ₹{{ number_format($data['this_month_earnings'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-calendar-grid-58 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- PAYOUT --}}
        <div class="rounded-2xl p-6 bg-gradient-to-br from-orange-500 to-yellow-400 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70">
                        Total Payout
                    </p>

                    <h2 class="text-3xl font-black mt-3">
                        ₹{{ number_format($data['total_payout'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-send text-2xl"></i>
                </div>

            </div>

        </div>



    </div>

    {{-- TABS --}}
    <div class="flex flex-wrap gap-3 mb-6">

        <button class="earnTabBtn activeEarnTab px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold"
            data-tab="earnings">

            Earnings

        </button>

        <button class="earnTabBtn px-5 py-3 rounded-2xl bg-white dark:bg-slate-900 shadow-lg font-bold"
            data-tab="payouts">

            Payout Requests

        </button>

    </div>

    {{-- EARNINGS TABLE --}}
    <div id="earningsSection"
        class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden mb-8">

        <div class="p-6 border-b dark:border-slate-800">

            <h3 class="text-2xl font-black dark:text-white">
                Earnings History
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            #
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Title
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Type
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Earned Date
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($earns as $key => $earn)

                    <tr>

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            {{ $key + 1 }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <div class="font-bold dark:text-white">
                                {{ $earn->title }}
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                {{ $earn->remarks }}
                            </div>

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800 capitalize">
                            {{ $earn->type }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <span class="font-black text-emerald-500">
                                ₹{{ number_format($earn->amount,2) }}
                            </span>

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            {{ $earn->earned_at
                                ? \Carbon\Carbon::parse($earn->earned_at)->format('d M Y h:i A')
                                : '-' }}

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            @php

                                $statusColor = match($earn->status) {
                                    'completed' => 'bg-emerald-500',
                                    'pending' => 'bg-orange-500',
                                    'processing' => 'bg-blue-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-slate-500'
                                };

                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs text-white font-bold {{ $statusColor }}">
                                {{ ucfirst($earn->status) }}
                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6">

                            <div class="text-center py-20">

                                <div class="text-6xl mb-4">
                                    💸
                                </div>

                                <h4 class="text-2xl font-black dark:text-white">
                                    No Earnings Found
                                </h4>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAYOUTS --}}
    <div id="payoutSection"
        class="hidden rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        <div class="p-6 border-b dark:border-slate-800">

            <h3 class="text-2xl font-black dark:text-white">
                Payout Requests
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Transfer No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Method
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Charge
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Final Amount
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Requested At
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($transfers as $transfer)

                    <tr>

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            {{ $transfer->transfer_no }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800 capitalize">
                            {{ $transfer->transfer_method }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            ₹{{ number_format($transfer->amount,2) }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            ₹{{ number_format($transfer->charge_amount,2) }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800 font-black text-emerald-500">
                            ₹{{ number_format($transfer->final_amount,2) }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            {{ $transfer->requested_at
                                ? \Carbon\Carbon::parse($transfer->requested_at)->format('d M Y h:i A')
                                : '-' }}

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            @php

                                $statusColor = match($transfer->status) {
                                    'completed' => 'bg-emerald-500',
                                    'pending' => 'bg-orange-500',
                                    'processing' => 'bg-blue-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-slate-500'
                                };

                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs text-white font-bold {{ $statusColor }}">
                                {{ ucfirst($transfer->status) }}
                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7">

                            <div class="text-center py-20">

                                <div class="text-6xl mb-4">
                                    🏦
                                </div>

                                <h4 class="text-2xl font-black dark:text-white">
                                    No Payout Requests
                                </h4>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

    const earnTabBtns = document.querySelectorAll('.earnTabBtn');

    const earningsSection = document.getElementById('earningsSection');

    const payoutSection = document.getElementById('payoutSection');

    earnTabBtns.forEach(btn => {

        btn.addEventListener('click', function () {

            earnTabBtns.forEach(item => {

                item.classList.remove(
                    'bg-gradient-to-r',
                    'from-blue-500',
                    'to-cyan-400',
                    'text-white'
                );

                item.classList.add(
                    'bg-white',
                    'dark:bg-slate-900'
                );

            });

            this.classList.add(
                'bg-gradient-to-r',
                'from-blue-500',
                'to-cyan-400',
                'text-white'
            );

            const tab = this.dataset.tab;

            if(tab === 'earnings') {

                earningsSection.classList.remove('hidden');
                payoutSection.classList.add('hidden');

            } else {

                payoutSection.classList.remove('hidden');
                earningsSection.classList.add('hidden');

            }

        });

    });

</script>

@endpush
