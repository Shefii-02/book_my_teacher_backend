@extends('layouts.teacher')

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    <form action="{{ route('teacher.payment-transfer.update',$transfer->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="rounded-3xl bg-white/70 backdrop-blur-xl shadow-2xl p-8">

            <div class="flex items-center justify-between mb-8">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        Edit Transfer
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Update transfer information
                    </p>

                </div>

                <button
                    class="px-6 py-3 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-xl">

                    Update Transfer

                </button>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="text-sm font-bold text-slate-600 mb-2 block">
                        Amount
                    </label>

                    <input type="number"
                        step="0.01"
                        name="amount"
                        value="{{ $transfer->amount }}"
                        class="w-full rounded-2xl border-0 bg-slate-100">

                </div>

                <div>

                    <label class="text-sm font-bold text-slate-600 mb-2 block">
                        Charge
                    </label>

                    <input type="number"
                        step="0.01"
                        name="charge_amount"
                        value="{{ $transfer->charge_amount }}"
                        class="w-full rounded-2xl border-0 bg-slate-100">

                </div>

                <div>

                    <label class="text-sm font-bold text-slate-600 mb-2 block">
                        Final Amount
                    </label>

                    <input type="number"
                        step="0.01"
                        name="final_amount"
                        value="{{ $transfer->final_amount }}"
                        class="w-full rounded-2xl border-0 bg-slate-100">

                </div>

                <div>

                    <label class="text-sm font-bold text-slate-600 mb-2 block">
                        Status
                    </label>

                    <select name="status"
                        class="w-full rounded-2xl border-0 bg-slate-100">

                        <option value="pending" @selected($transfer->status=='pending')>Pending</option>

                        <option value="processing" @selected($transfer->status=='processing')>Processing</option>

                        <option value="completed" @selected($transfer->status=='completed')>Completed</option>

                        <option value="failed" @selected($transfer->status=='failed')>Failed</option>

                        <option value="rejected" @selected($transfer->status=='rejected')>Rejected</option>

                    </select>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
