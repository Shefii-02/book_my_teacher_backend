@extends('layouts.teacher')

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    <form action="{{ route('teacher.payment-transfer.store') }}" method="POST">

        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT --}}
            <div class="lg:col-span-2">

                <div class="rounded-3xl bg-white/70 backdrop-blur-xl shadow-2xl p-8">

                    <div class="mb-8">

                        <h2 class="text-2xl font-bold text-slate-800">
                            Create Transfer
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Transfer teacher earning balance
                        </p>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>

                            <label class="text-sm font-bold text-slate-600 mb-2 block">
                                Transfer Amount
                            </label>

                            <input type="number"
                                step="0.01"
                                name="amount"
                                id="amount"
                                class="w-full rounded-2xl border-0 bg-slate-100 focus:ring-2 focus:ring-violet-500"
                                required>

                            @error('amount')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                        </div>

                        <div>

                            <label class="text-sm font-bold text-slate-600 mb-2 block">
                                Charge Amount
                            </label>

                            <input type="number"
                                step="0.01"
                                value="0"
                                name="charge_amount"
                                id="charge_amount"
                                class="w-full rounded-2xl border-0 bg-slate-100 focus:ring-2 focus:ring-violet-500">

                        </div>

                        <div>

                            <label class="text-sm font-bold text-slate-600 mb-2 block">
                                Final Amount
                            </label>

                            <input type="number"
                                step="0.01"
                                name="final_amount"
                                id="final_amount"
                                readonly
                                class="w-full rounded-2xl border-0 bg-slate-200">

                        </div>

                        <div>

                            <label class="text-sm font-bold text-slate-600 mb-2 block">
                                Transfer Method
                            </label>

                            <select name="transfer_method"
                                class="w-full rounded-2xl border-0 bg-slate-100 focus:ring-2 focus:ring-violet-500">

                                <option value="bank">Bank</option>

                                <option value="upi">UPI</option>

                                <option value="paypal">Paypal</option>

                                <option value="stripe">Stripe</option>

                                <option value="razorpay">Razorpay</option>

                            </select>

                        </div>

                        <div>

                            <label class="text-sm font-bold text-slate-600 mb-2 block">
                                UPI ID
                            </label>

                            <input type="text"
                                name="upi_id"
                                class="w-full rounded-2xl border-0 bg-slate-100">

                        </div>

                        <div>

                            <label class="text-sm font-bold text-slate-600 mb-2 block">
                                Remarks
                            </label>

                            <textarea name="remarks"
                                rows="4"
                                class="w-full rounded-2xl border-0 bg-slate-100"></textarea>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div>

                <div class="rounded-3xl bg-gradient-to-br from-violet-600 to-fuchsia-600 p-8 text-white shadow-2xl">

                    <h4 class="text-xl font-bold">
                        Available Balance
                    </h4>

                    <div class="text-5xl font-black mt-4">
                        ₹{{ number_format($availableBalance,2) }}
                    </div>

                    <button
                        class="w-full mt-8 bg-white text-slate-800 rounded-2xl py-4 font-bold hover:scale-105 duration-300">

                        Submit Transfer

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

<script>

    function calculateFinalAmount(){

        let amount = parseFloat(document.getElementById('amount').value || 0);

        let charge = parseFloat(document.getElementById('charge_amount').value || 0);

        let final = amount - charge;

        document.getElementById('final_amount').value = final.toFixed(2);

    }

    document.getElementById('amount').addEventListener('keyup', calculateFinalAmount);

    document.getElementById('charge_amount').addEventListener('keyup', calculateFinalAmount);

</script>

@endsection
