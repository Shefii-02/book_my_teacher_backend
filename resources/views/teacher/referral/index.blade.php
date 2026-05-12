@extends('layouts.teacher')

@section('nav-options')

<nav>

    <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg sm:mr-16">

        <li class="text-sm">
            <a class="text-white" href="javascript:;">
                Home
            </a>
        </li>

        <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
            Dashboard
        </li>

        <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
            My Referral
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        My Referral
    </h6>

</nav>

@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL REFERRALS --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Total Referrals
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_referrals'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-single-02 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- TOTAL COINS --}}
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Total Coins
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ number_format($data['total_coins'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-money-coins text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- APPROVED --}}
        <div class="rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Approved Coins
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ number_format($data['approved_coins'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-check-bold text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- PENDING --}}
        <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between items-start">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Pending Coins
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ number_format($data['pending_coins'],2) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-time-alarm text-2xl"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- HISTORY TABLE --}}
    <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <div class="flex items-center justify-between">

                <div>

                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                        Referral History
                    </h3>

                    <p class="text-slate-500 text-sm mt-1">
                        Referral coin credit history
                    </p>

                </div>

            </div>

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
                            Wallet
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Type
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Coins
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Date
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Notes
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($referrals as $key => $referral)

                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800 transition">

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            {{ $key + 1 }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <div class="font-bold text-slate-800 dark:text-white">
                                {{ $referral->title }}
                            </div>

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                                Green Coins
                            </span>

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800 capitalize">

                            @if($referral->type == 'credit')

                            <span class="text-emerald-500 font-bold">
                                Credit
                            </span>

                            @else

                            <span class="text-red-500 font-bold">
                                Debit
                            </span>

                            @endif

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            <span class="font-black text-emerald-500">
                                {{ number_format($referral->amount,2) }}
                            </span>

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm">

                            {{ \Carbon\Carbon::parse($referral->date)->format('d M Y') }}

                            <div class="text-xs text-slate-500 mt-1">
                                {{ \Carbon\Carbon::parse($referral->created_at)->format('h:i A') }}
                            </div>

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm text-slate-500">

                            {{ $referral->notes ?? '-' }}

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            @php

                                $statusColor = match($referral->status) {
                                    'approved' => 'bg-emerald-500',
                                    'pending' => 'bg-orange-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-slate-500'
                                };

                            @endphp

                            <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ $statusColor }}">

                                {{ ucfirst($referral->status) }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8">

                            <div class="text-center py-5">

                                <div class="text-7xl mb-4">
                                    🎁
                                </div>

                                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                                    No Referral History
                                </h3>

                                <p class="text-slate-500 mt-2">
                                    No referral rewards found.
                                </p>

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
