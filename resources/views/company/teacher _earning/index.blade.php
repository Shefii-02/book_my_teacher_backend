@extends('layouts.teacher')

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- HERO --}}
    <div
        class="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-slate-900 via-violet-900 to-fuchsia-900 p-8 shadow-[0_20px_60px_rgba(0,0,0,0.35)] mb-8">

        {{-- blur circles --}}
        <div class="absolute top-0 left-0 w-72 h-72 bg-fuchsia-500/20 rounded-full blur-3xl"></div>

        <div class="absolute bottom-0 right-0 w-80 h-80 bg-cyan-500/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>

                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 backdrop-blur-xl text-white text-sm font-semibold mb-5">

                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>

                    Teacher Earnings Dashboard

                </div>

                <h1 class="text-4xl lg:text-5xl font-black text-white leading-tight">
                    Earnings
                    <span
                        class="bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent">
                        Analytics
                    </span>
                </h1>

                <p class="text-white/70 mt-4 max-w-xl">
                    Manage teacher income, course revenue, referral commissions and payouts.
                </p>

            </div>

            <div class="flex flex-wrap gap-4">

                <a href="{{ route('teacher.earning.create') }}"
                    class="group px-6 py-4 rounded-2xl bg-white text-slate-800 font-bold shadow-2xl hover:scale-105 duration-300">

                    <i class="fas fa-plus mr-2 group-hover:rotate-90 duration-300"></i>

                    Add Earning

                </a>

            </div>

        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- CARD --}}
        <div
            class="relative overflow-hidden rounded-[28px] border border-white/20 bg-white/70 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-6">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-violet-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">
                            Total Earnings
                        </p>

                        <h2 class="text-4xl font-black text-slate-800 mt-3">
                            ₹{{ number_format($totalEarning,2) }}
                        </h2>

                    </div>

                    <div
                        class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-violet-600 to-fuchsia-600 flex items-center justify-center shadow-2xl text-white">

                        <i class="fas fa-wallet text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

        {{-- CARD --}}
        <div
            class="relative overflow-hidden rounded-[28px] border border-white/20 bg-white/70 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-6">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">
                            Completed
                        </p>

                        <h2 class="text-4xl font-black text-emerald-600 mt-3">
                            ₹{{ number_format($completedAmount,2) }}
                        </h2>

                    </div>

                    <div
                        class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-emerald-500 to-teal-500 flex items-center justify-center shadow-2xl text-white">

                        <i class="fas fa-check-circle text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

        {{-- CARD --}}
        <div
            class="relative overflow-hidden rounded-[28px] border border-white/20 bg-white/70 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-6">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">
                            Pending
                        </p>

                        <h2 class="text-4xl font-black text-orange-500 mt-3">
                            ₹{{ number_format($pendingAmount,2) }}
                        </h2>

                    </div>

                    <div
                        class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-orange-500 to-yellow-500 flex items-center justify-center shadow-2xl text-white">

                        <i class="fas fa-clock text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

        {{-- CARD --}}
        <div
            class="relative overflow-hidden rounded-[28px] border border-white/20 bg-white/70 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] p-6">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-cyan-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">
                            Total Records
                        </p>

                        <h2 class="text-4xl font-black text-cyan-600 mt-3">
                            {{ $totalRecords }}
                        </h2>

                    </div>

                    <div
                        class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-cyan-500 to-blue-500 flex items-center justify-center shadow-2xl text-white">

                        <i class="fas fa-chart-line text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div
        class="rounded-[32px] overflow-hidden border border-white/20 bg-white/70 backdrop-blur-2xl shadow-[0_20px_60px_rgba(0,0,0,0.08)]">

        {{-- TOP --}}
        <div class="p-6 border-b border-slate-200/70">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div>

                    <h3 class="text-2xl font-black text-slate-800">
                        Recent Earnings
                    </h3>

                    <p class="text-slate-500 mt-1">
                        Recently added earning history
                    </p>

                </div>

                {{-- FILTER --}}
                <form method="GET">

                    <select name="status"
                        onchange="this.form.submit()"
                        class="px-5 py-3 rounded-2xl border-0 bg-slate-100 font-semibold focus:ring-2 focus:ring-violet-500">

                        <option value="">All Status</option>

                        <option value="pending" @selected(request('status')=='pending')>
                            Pending
                        </option>

                        <option value="processing" @selected(request('status')=='processing')>
                            Processing
                        </option>

                        <option value="completed" @selected(request('status')=='completed')>
                            Completed
                        </option>

                        <option value="cancelled" @selected(request('status')=='cancelled')>
                            Cancelled
                        </option>

                    </select>

                </form>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100/70">

                    <tr>

                        <th class="px-6 py-5 text-left text-xs font-black text-slate-500 uppercase">
                            Title
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-black text-slate-500 uppercase">
                            Type
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-black text-slate-500 uppercase">
                            Amount
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-black text-slate-500 uppercase">
                            Status
                        </th>

                        <th class="px-6 py-5 text-left text-xs font-black text-slate-500 uppercase">
                            Date
                        </th>

                        <th class="px-6 py-5 text-right text-xs font-black text-slate-500 uppercase">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($earnings as $earning)

                        <tr
                            class="border-b border-slate-100 hover:bg-violet-50/40 duration-300">

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div
                                        class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-violet-500 to-fuchsia-500 flex items-center justify-center text-white shadow-xl">

                                        <i class="fas fa-money-bill-wave"></i>

                                    </div>

                                    <div>

                                        <h5 class="font-bold text-slate-800">
                                            {{ $earning->title }}
                                        </h5>

                                        <p class="text-xs text-slate-500 mt-1">
                                            #{{ $earning->id }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-5">

                                <span
                                    class="px-4 py-2 rounded-2xl text-xs font-black uppercase bg-blue-100 text-blue-600">

                                    {{ $earning->type }}

                                </span>

                            </td>

                            <td class="px-6 py-5">

                                <div class="font-black text-lg text-emerald-600">
                                    ₹{{ number_format($earning->amount,2) }}
                                </div>

                            </td>

                            <td class="px-6 py-5">

                                @php

                                    $statusClass = match($earning->status){

                                        'completed' => 'bg-emerald-100 text-emerald-600',

                                        'pending' => 'bg-orange-100 text-orange-600',

                                        'processing' => 'bg-blue-100 text-blue-600',

                                        'cancelled' => 'bg-red-100 text-red-600',

                                        default => 'bg-slate-100 text-slate-600'

                                    };

                                @endphp

                                <span
                                    class="px-4 py-2 rounded-2xl text-xs font-black uppercase {{ $statusClass }}">

                                    {{ $earning->status }}

                                </span>

                            </td>

                            <td class="px-6 py-5 text-slate-500 font-medium">

                                {{ date('d M Y',strtotime($earning->earned_at)) }}

                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-3">

                                    <a href="{{ route('teacher.earning.edit',$earning->id) }}"
                                        class="w-11 h-11 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center hover:scale-110 duration-300 shadow-lg">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="py-24 text-center">

                                <div class="flex flex-col items-center">

                                    <div
                                        class="w-28 h-28 rounded-full bg-slate-100 flex items-center justify-center mb-5">

                                        <i class="fas fa-folder-open text-5xl text-slate-300"></i>

                                    </div>

                                    <h3 class="text-2xl font-black text-slate-600">
                                        No Earnings Found
                                    </h3>

                                    <p class="text-slate-400 mt-2">
                                        Create first earning record
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-6 border-t border-slate-200/70">

            {{ $earnings->links() }}

        </div>

    </div>

</div>

@endsection
