@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Admission Transactions List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Admission Transactions List</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white dark:bg-slate-850 dark:shadow-dark-xl rounded-3 my-3">
            <div class="card-title p-3 my-3 flex justify-between">
                <h6 class="font-bold dark:text-white">
                    Confirm Your Payment
                </h6>
                <a href="{{ route('admin.coupons.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded text-sm">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back</a>
            </div>
        </div>

        <div class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl p-6">

            <form action="{{ route('admin.payments.process', $purchase->payments->order_id) }}" method="POST"
                class="w-full max-w-3xl">
                @csrf
                {{-- Main Card --}}
                <div class="overflow-hidden">

                    {{-- Card Header --}}
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-2">
                        <h2 class="text-dark text-lg font-semibold">Payment Summary</h2>

                        <p class="text-gray-500 mt-1">Please review the details before proceeding</p>
                    </div>

                    <div class="p-6 space-y-6">

                        {{-- ================= COURSE DETAILS ================= --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">
                                Course Details
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-400">Course Title</p>
                                    <p class="font-medium text-gray-800">{{ $purchase->course->title }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-400">Teaching Teacher</p>
                                    <p class="font-medium text-gray-800">{{ implode(',',$purchase->course?->teachers?->pluck('name')->toArray()) }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-400">Price</p>
                                    <p class="font-medium text-gray-800">₹{{ number_format($purchase->course->net_price, 2) }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-gray-400">Validity</p>
                                    <p class="font-medium text-gray-800">{{ $purchase->course->validity }} Days</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- ================= STUDENT DETAILS ================= --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">
                                Student Details
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-400">Student Name</p>
                                    <p class="font-medium text-gray-800">{{ $purchase->student->name }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-400">Email</p>
                                    <p class="font-medium text-gray-800">{{ $purchase->student->email }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-400">Mobile</p>
                                    <p class="font-medium text-gray-800">{{ $purchase->student->mobile }}</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- ================= PAYMENT DETAILS ================= --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">
                                Payment Details
                            </h3>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Price</span>
                                    <span class="font-medium text-gray-800">
                                        ₹{{ number_format($purchase->net_price, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Discount</span>
                                    <span class="font-medium text-green-600">
                                        - ₹{{ number_format($purchase->discount_amount, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tax</span>
                                    <span class="font-medium text-gray-800">
                                        ₹{{ number_format($purchase->tax_amount, 2) }}
                                    </span>
                                </div>

                                <hr>

                                <div class="flex justify-between text-lg font-semibold">
                                    <span>Grand Total</span>
                                    <span class="text-indigo-600">
                                        ₹{{ number_format($purchase->grand_total, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ================= FOOTER ACTION ================= --}}
                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row gap-4 sm:justify-between items-center">

                        <p class="text-xs text-gray-400 text-center sm:text-left">
                            By clicking Pay Now, you agree to our terms & conditions.
                        </p>

                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition-all shadow-md">
                            Pay Now ₹{{ number_format($purchase->payments->amount, 2) }}
                        </button>

                    </div>

                </div>
            </form>
        </div>


    </div>
@endsection
