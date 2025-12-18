@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50">
    <div class="bg-white p-8 rounded-xl shadow-xl text-center">
        <h2 class="text-2xl font-bold text-green-600">Invoice Verified ✔</h2>
        <p class="mt-2 text-gray-600">
            This invoice is authentic and payment is confirmed.
        </p>

        <p class="mt-4 text-sm">
            <b>Invoice #:</b> {{ $purchase->id }}<br>
            <b>Student:</b> {{ $purchase->student->name }}<br>
            <b>Amount:</b> ₹{{ number_format($purchase->payment->grand_total,2) }}
        </p>
    </div>
</div>
@endsection
