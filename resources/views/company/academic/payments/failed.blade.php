@extends('layouts.layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-10">
        <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 text-center">

            <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-red-700 mt-4">
                Payment Failed 😔
            </h1>

            <p class="text-gray-600 mt-2">
                Unfortunately your payment could not be completed.
            </p>

            <div class="mt-6 text-left border rounded-xl p-5">
                <p><strong>Student:</strong> {{ $purchase->student->name }}</p>
                <p><strong>Order ID:</strong> {{ $purchase->id }}</p>
                <p><strong>Status:</strong>
                    <span class="text-red-600 font-semibold">FAILED</span>
                </p>
            </div>

            <div class="mt-8 flex gap-4 justify-center">
                <a href="{{ route('company.payments.init', $purchase->payments->order_id) }}"
                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold">
                    🔁 Retry Payment
                </a>

                <a href="{{ route('company.admissions.index') }}"
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold">
                    ⬅ Back to Courses
                </a>
            </div>

        </div>
    </div>
@endsection
