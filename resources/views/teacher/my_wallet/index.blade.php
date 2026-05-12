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
                My Wallet
            </li>

        </ol>

        <h6 class="mb-0 font-bold text-white capitalize">
            My Wallet
        </h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        {{-- TOP CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

            {{-- AVAILABLE --}}
            <div
                class="rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-400 shadow-2xl p-6 text-white">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="uppercase text-xs opacity-70 tracking-wider">
                            Available Balance
                        </p>

                        <h2 class="text-4xl font-black mt-3">
                            ₹{{ number_format($data['available_balance'], 2) }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-money-coins text-2xl"></i>
                    </div>

                </div>

            </div>

            {{-- TOTAL EARNED --}}
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-blue-500 to-cyan-400 shadow-2xl p-6 text-white">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="uppercase text-xs opacity-70 tracking-wider">
                            Total Earned
                        </p>

                        <h2 class="text-4xl font-black mt-3">
                            ₹{{ number_format($data['total_earned'], 2) }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-chart-bar-32 text-2xl"></i>
                    </div>

                </div>

            </div>

            {{-- TOTAL TRANSFERRED --}}
            <div
                class="rounded-2xl overflow-hidden bg-gradient-to-br from-violet-500 to-purple-500 shadow-2xl p-6 text-white">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="uppercase text-xs opacity-70 tracking-wider">
                            Total Payout
                        </p>

                        <h2 class="text-4xl font-black mt-3">
                            ₹{{ number_format($data['total_transferred'], 2) }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-send text-2xl"></i>
                    </div>

                </div>

            </div>

            {{-- PENDING --}}
            <div
                class="rounded-2xl overflow-hidden bg-gradient-to-br from-orange-500 to-yellow-400 shadow-2xl p-6 text-white">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="uppercase text-xs opacity-70 tracking-wider">
                            Pending Payout
                        </p>

                        <h2 class="text-4xl font-black mt-3">
                            ₹{{ number_format($data['pending_payout'], 2) }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="ni ni-time-alarm text-2xl"></i>
                    </div>

                </div>

            </div>

        </div>

        {{-- TABS --}}
        {{-- ================= FILTER BUTTONS ================= --}}
        <div class="mb-6">

            <div class="flex flex-wrap gap-3">

                <button
                    class="walletTabBtn activeWalletTab px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold shadow-lg"
                    data-tab="all">

                    All History

                </button>

                <button class="walletTabBtn px-5 py-3 rounded-2xl bg-white dark:bg-slate-900 shadow-lg font-bold"
                    data-tab="green">

                    Green Coins

                </button>

                <button class="walletTabBtn px-5 py-3 rounded-2xl bg-white dark:bg-slate-900 shadow-lg font-bold"
                    data-tab="ruppes">

                    Rupees

                </button>

            </div>

        </div>


        {{-- HISTORY --}}
        <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

            <div class="p-6 border-b border-slate-100 dark:border-slate-800">

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                            Wallet History
                        </h3>

                        <p class="text-slate-500 text-sm mt-1">
                            Earnings & payout transaction history
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
                                Wallet Type
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase">
                                Title
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase">
                                Type
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase">
                                Amount
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase">
                                Created
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase">
                                Verified
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase">
                                Approved By
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase">
                                Status
                            </th>

                        </tr>

                    </thead>
                    <tbody>

                        @forelse($wallets as $key => $wallet)
                            <tr class="walletRow" data-type="{{ $wallet->wallet_type }}">

                                {{-- ID --}}
                                <td class="px-6 py-5 border-b dark:border-slate-800">
                                    {{ $key + 1 }}
                                </td>

                                {{-- WALLET TYPE --}}
                                <td class="px-6 py-5 border-b dark:border-slate-800">

                                    @if ($wallet->wallet_type == 'green')
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                                            Green Coins
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600">
                                            Rupees
                                        </span>
                                    @endif

                                </td>

                                {{-- TITLE --}}
                                <td class="px-6 py-5 border-b dark:border-slate-800">

                                    <div class="font-bold text-slate-800 dark:text-white">
                                        {{ $wallet->title }}
                                    </div>

                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $wallet->notes }}
                                    </div>

                                </td>

                                {{-- TYPE --}}
                                <td class="px-6 py-5 border-b dark:border-slate-800">

                                    @if ($wallet->type == 'credit')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white">
                                            Credit
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white">
                                            Debit
                                        </span>
                                    @endif

                                </td>

                                {{-- AMOUNT --}}
                                <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                                    @if ($wallet->type == 'credit')
                                        <span class="font-black text-emerald-500">
                                            + ₹{{ number_format($wallet->amount, 2) }}
                                        </span>
                                    @else
                                        <span class="font-black text-red-500">
                                            - ₹{{ number_format($wallet->amount, 2) }}
                                        </span>
                                    @endif

                                </td>

                                {{-- CREATED --}}
                                <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm">

                                    {{ \Carbon\Carbon::parse($wallet->created_at)->format('d M Y h:i A') }}

                                </td>

                                {{-- VERIFIED --}}
                                <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm">

                                    {{ $wallet->updated_at ? \Carbon\Carbon::parse($wallet->updated_at)->format('d M Y h:i A') : '-' }}

                                </td>

                                {{-- APPROVED BY --}}
                                <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                                    Admin

                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                                    @php
                                        $statusColor = match ($wallet->status) {
                                            'approved' => 'bg-emerald-500',
                                            'pending' => 'bg-orange-500',
                                            'rejected' => 'bg-red-500',
                                            default => 'bg-slate-500',
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ $statusColor }}">

                                        {{ ucfirst($wallet->status) }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9">

                                    <div class="text-center py-20">

                                        <div class="text-7xl mb-4">
                                            💰
                                        </div>

                                        <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                                            No Wallet History
                                        </h3>

                                        <p class="text-slate-500 mt-2">
                                            No transactions found.
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
@push('scripts')

<script>

    const tabButtons = document.querySelectorAll('.walletTabBtn');
    const rows = document.querySelectorAll('.walletRow');

    tabButtons.forEach(button => {

        button.addEventListener('click', function () {

            tabButtons.forEach(btn => {

                btn.classList.remove(
                    'activeWalletTab',
                    'bg-gradient-to-r',
                    'from-blue-500',
                    'to-cyan-400',
                    'text-white'
                );

                btn.classList.add(
                    'bg-white',
                    'dark:bg-slate-900'
                );

            });

            this.classList.add(
                'activeWalletTab',
                'bg-gradient-to-r',
                'from-blue-500',
                'to-cyan-400',
                'text-white'
            );

            const type = this.dataset.tab;

            rows.forEach(row => {

                if (type === 'all') {

                    row.style.display = '';

                } else {

                    row.style.display =
                        row.dataset.type === type
                        ? ''
                        : 'none';

                }

            });

        });

    });

</script>

@endpush
