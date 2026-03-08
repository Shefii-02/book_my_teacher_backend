@extends('layouts.layout')

@section('nav-options')
    <nav>

        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">

            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="#">Home</a>
            </li>

            <li class="text-sm pl-2 capitalize text-white before:content-['/'] before:pr-2">
                <a class="text-white" href="#">Dashboard</a>
            </li>

            <li class="text-sm pl-2 font-bold capitalize text-white before:content-['/'] before:pr-2">
                Invoice List
            </li>

        </ol>

        <h6 class="mb-0 font-bold text-white">Invoice List</h6>

    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">


        {{-- CREATE BUTTON --}}

        <div class="bg-white mt-4 flex justify-between rounded-2xl shadow-xl mb-6 p-4">

            <h6 class="text-dark">Invoices List</h6>

            <a href="{{ route('company.custom.invoices.create') }}"
                class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded text-sm">

                <i class="bi bi-plus"></i> Create Invoice

            </a>

        </div>



        {{-- DASHBOARD CARDS --}}

        <div class="flex flex-wrap -mx-3 mb-6">


            {{-- TOTAL --}}

            <div class="w-full xl:w-1/4 px-3">

                <div class="bg-white shadow-xl rounded-2xl p-4">

                    <p class="text-sm text-gray-500">Total Invoices</p>

                    <h5 class="text-xl font-bold">{{ $stats['total']['count'] }}</h5>

                    <p class="text-sm text-gray-600">
                        ₹{{ $stats['total']['amount'] }}
                    </p>

                </div>

            </div>



            {{-- PAID --}}

            <div class="w-full xl:w-1/4 px-3">

                <div class="bg-white shadow-xl rounded-2xl p-4">

                    <p class="text-sm text-gray-500">Paid</p>

                    <h5 class="text-xl font-bold text-green-600">
                        {{ $stats['paid']['count'] }}
                    </h5>

                    <p class="text-sm text-gray-600">
                        ₹{{ $stats['paid']['amount'] }}
                    </p>

                </div>

            </div>



            {{-- UNPAID --}}

            <div class="w-full xl:w-1/4 px-3">

                <div class="bg-white shadow-xl rounded-2xl p-4">

                    <p class="text-sm text-gray-500">Unpaid</p>

                    <h5 class="text-xl font-bold text-yellow-500">
                        {{ $stats['unpaid']['count'] }}
                    </h5>

                    <p class="text-sm text-gray-600">
                        ₹{{ $stats['unpaid']['amount'] }}
                    </p>

                </div>

            </div>



            {{-- CANCELLED --}}

            <div class="w-full xl:w-1/4 px-3">

                <div class="bg-white shadow-xl rounded-2xl p-4">

                    <p class="text-sm text-gray-500">Cancelled</p>

                    <h5 class="text-xl font-bold text-red-500">
                        {{ $stats['cancelled']['count'] }}
                    </h5>

                    <p class="text-sm text-gray-600">
                        ₹{{ $stats['cancelled']['amount'] }}
                    </p>

                </div>

            </div>


        </div>



        {{-- FILTER FORM --}}

        <div class="bg-white shadow-xl rounded-2xl p-4 mb-6">

            <form method="GET" class="flex flex-wrap gap-4 items-end">

                <div>

                    <label class="text-sm font-semibold">Search</label>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Invoice / Name / Mobile" class="border px-3 py-2 rounded w-56">

                </div>


                <div>

                    <label class="text-sm font-semibold">Status</label>

                    <select name="status" class="border px-3 py-2 rounded">

                        <option value="all">All</option>

                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>
                            Unpaid
                        </option>

                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                </div>



                <div>

                    <label class="text-sm font-semibold">Start Date</label>

                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="border px-3 py-2 rounded">

                </div>



                <div>

                    <label class="text-sm font-semibold">End Date</label>

                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="border px-3 py-2 rounded">

                </div>



                <div class="flex gap-2">

                    <button type="submit" class="px-4 py-2 bg-emerald-500/50 text-white rounded">
                        Search
                    </button>

                    <a href="{{ route('company.custom.invoices.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded">
                        Reset
                    </a>

                </div>


            </form>

        </div>



        {{-- TABLE --}}

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-3 text-left">Invoice</th>

                        <th class="px-6 py-3 text-left">Customer</th>

                        <th class="px-6 py-3 text-left">Subtotal</th>

                        <th class="px-6 py-3 text-left">Discount</th>

                        <th class="px-6 py-3 text-left">Tax</th>

                        <th class="px-6 py-3 text-left">Grand Total</th>

                        <th class="px-6 py-3 text-left">Date</th>

                        <th class="px-6 py-3 text-left">Status</th>

                        <th></th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($invoices as $key => $invoice)
                        <tr class="border-t">


                            <td class="px-6 py-3 font-semibold">

                                {{ $invoice->invoice_no }}

                            </td>



                            <td class="px-6 py-3">

                                {{ $invoice->customer_name }} <br>

                                <small>{{ $invoice->customer_mobile }}</small>

                            </td>



                            <td class="px-6 py-3">

                                ₹{{ $invoice->subtotal }}

                            </td>


                            <td class="px-6 py-3">

                                ₹{{ $invoice->discount }}

                            </td>


                            <td class="px-6 py-3">

                                ₹{{ $invoice->tax_amount }}

                            </td>


                            <td class="px-6 py-3 font-semibold">

                                ₹{{ $invoice->grand_total }}

                            </td>


                            <td class="px-6 py-3">

                                {{ $invoice->created_at->format('d M Y') }}

                            </td>



                            <td class="px-6 py-3">

                                @if ($invoice->status == 'paid')
                                    <span class="px-2 py-1 text-xs bg-green-500 text-white rounded">
                                        Paid
                                    </span>
                                @elseif($invoice->status == 'unpaid')
                                    <span class="px-2 py-1 text-xs bg-yellow-500 text-white rounded">
                                        Unpaid
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-500 text-white rounded">
                                        Cancelled
                                    </span>
                                @endif

                            </td>



                            <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 shadow-transparent">
                                <button id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                    data-dropdown-placement="bottom" class="" type="button"> <svg
                                        class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M12 6h.01M12 12h.01M12 18h.01" />
                                    </svg> </button> <!-- Dropdown menu -->
                                <div id="dropdownBottom_{{ $key }}"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownBottomButton">
                                        @if ($invoice->status == 'unpaid')
                                            <li>
                                                <form
                                                    action="{{ route('company.custom.invoices.pay.update', $invoice->id) }}"
                                                    id="form2_{{ $invoice->id }}" method="POST"> @csrf
                                                    @method('POST') <a role="button" href="javascript:;"
                                                        class="block px-4 py-2 hover:bg-gray-100"
                                                        onclick="confirmSubmit({{ $invoice->id }})">Mark as Pay</a>
                                                </form>
                                            </li>
                                            <li>
                                                <form
                                                    action="{{ route('company.custom.invoices.destroy', $invoice->id) }}"
                                                    id="form_{{ $invoice->id }}" method="POST"> @csrf @method('DELETE')
                                                    <a role="button" href="javascript:;"
                                                        class="block px-4 py-2 hover:bg-gray-100"
                                                        onclick="confirmDelete({{ $invoice->id }})">Delete</a>
                                                </form>
                                            </li>
                                        @else
                                            <li class="text-center"> <a href="#"
                                                    class="block px-4 py-2 hover:bg-gray-100"
                                                    @disabled(true)>Restricted</a> </li>
                                        @endif
                                    </ul>


                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="text-center py-6">
                                No invoices found
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>



        {{-- PAGINATION --}}

        <div class="mt-4">

            {{ $invoices->links() }}

        </div>


    </div>
@endsection
