@extends('layouts.layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-emerald-100 py-10">
        <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">

            {{-- SUCCESS ICON --}}
            <div class="text-center">
                <div class="mx-auto w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 " style="color: green" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h4 class="text-2xl font-bold text-emerald-500 mt-2">
                    Payment Successful 🎉
                </h4>
                <p class="text-gray-600 mt-1">
                    Thank you! Your payment has been completed successfully.
                </p>
            </div>

            {{-- DETAILS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

                {{-- STUDENT --}}
                <div class="border rounded-xl p-5">
                    <h6 class="font-semibold text-gray-700 mb-3">👨‍🎓 Student Details</h6>
                    <p><strong>Name:</strong> {{ $purchase->student->name }}</p>
                    <p><strong>Email:</strong> {{ $purchase->student->email }}</p>
                    <p><strong>Mobile:</strong> {{ $purchase->student->mobile }}</p>
                </div>

                {{-- PAYMENT --}}
                <div class="border rounded-xl p-5">
                    <h6 class="font-semibold text-gray-700 mb-3">💳 Payment Details</h6>
                    <p><strong>Transaction ID:</strong> {{ $purchase->payments->transaction_id }}</p>
                    <p><strong>Status:</strong>
                        <span class="text-emerald-600 font-semibold">PAID</span>
                    </p>
                    <p><strong>Date:</strong> {{ date('d M Y, h:i A', strtotime($purchase->created_at)) }}</p>
                </div>

            </div>

            {{-- COURSE TABLE --}}
            <div class="mt-8">
                <h6 class="font-semibold text-gray-700 mb-3">📚 Course Details</h6>

                <table class="w-full border rounded overflow-hidden table">
                    <thead class="border-bottom">
                        <tr>
                            <th>Course</th>
                            <th>Validity</th>
                            <th class="text-right">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">{{ $purchase->course->title }}</td>
                            <td class="text-center">{{ $purchase->course->validity ?? 'N/A' }}</td>
                            <td class="text-right">
                                {{ number_format($purchase->price, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- ================= INSTALLMENTS ================= --}}
            @if ($purchase->is_installment)
                <div class="mt-8">
                    <h6 class="font-semibold text-gray-700 mb-3">Installment Schedule</h6>


                    <table class="w-full border rounded overflow-hidden table">
                        <thead class="border-bottom">
                            <thead>
                                <tr>
                                    <th>Due Date</th>
                                    <th class="text-right">Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($purchase->installments ?? [] as $ins)
                                <tr>
                                    <td class="text-center">{{ date('d-M-Y', strtotime($ins->due_date)) }}</td>
                                    <td class="text-right">₹{{ number_format($ins->amount, 2) }}</td>
                                    <td class="text-center">{{ $ins->is_paid ? 'PAID' : 'PENDING' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- TOTAL --}}
            <div class="mt-6 border-t pt-4 text-right">
                <p>Subtotal: ₹{{ number_format($purchase->price, 2) }}</p>
                <p>Discount: - ₹{{ number_format($purchase->discount_amount, 2) }}</p>
                <p>Tax: ₹{{ number_format($purchase->tax_amount, 2) }}</p>
                <p class="text-xl font-bold text-emerald-700">
                    Grand Total: ₹{{ number_format($purchase->grand_total, 2) }}
                </p>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="mt-8 flex  sm:flex-row gap-4 justify-center">

                <a href="{{ route('company.admissions.index') }}"
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold">
                    ⬅ Back to Courses
                </a>

                <a href="{{ route('company.payments.invoice.download', $purchase->id) }}" target="_blank"
                    class="px-6 py-3 bg-emerald-500/50 hover:bg-emerald-700 text-white rounded-xl font-semibold">
                    📄 Download Invoice
                </a>

            </div>

        </div>
    </div>
@endsection
