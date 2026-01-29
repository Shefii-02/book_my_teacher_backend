{{-- <table>
    @foreach ($invoices as $invoice)
        <tr>
            <td>{{ $invoice->invoice_no }}</td>
            <td>{{ $invoice->customer_name }}</td>
            <td>₹{{ $invoice->grand_total }}</td>

        </tr>
    @endforeach
</table> --}}



@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li
                class="text-sm pl-2 capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Invoice List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Invoice List</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent">
                        <div class="flex justify-between">
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 xl:w-1/4">
                                <h6 class="dark:text-white">Invoices List</h6>
                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 xl:w-3/4">
                                <a href="{{ route('company.custom.invoices.create') }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full text-sm">
                                    Create Invoice
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="flex-auto px-0 pt-0 pb-2 min-h-75">
                        <div class="p-0 overflow-x-auto">
                            <table class="items-center w-full mb-0 align-top border-collapse text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                            #
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                            Offer Name
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                            Offer Code
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                            Coupon Type
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                            Discount
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                            Validity
                                        </th>
                                        <th
                                            class="px-6 py-3 font-semibold text-left uppercase bg-transparent border-b border-gray-200 text-xxs text-slate-400 opacity-70">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoices as $key => $invoice)
                                        <tr>
                                            <td
                                                class="px-6 py-3 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap">
                                                <div class="flex px-2 py-1">
                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                                            {{ $invoice->offer_name }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap">
                                                <span class="text-sm font-semibold">{{ $invoice->offer_code }}</span>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap">
                                                <span class="text-sm">{{ ucfirst($invoice->invoice_type) }}</span>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap">
                                                {{ $invoice->discount_type == 'flat' ? '₹' . $invoice->discount_value : $invoice->discount_value . '%' }}
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap">
                                                <span class="text-xs">
                                                    {{ $invoice->start_date_time ? \Carbon\Carbon::parse($invoice->start_date_time)->format('d M Y h:i A') : '—' }}
                                                    <br>
                                                    {{ $invoice->end_date_time ? \Carbon\Carbon::parse($invoice->end_date_time)->format('d M Y h:i A') : '—' }}
                                                </span>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap text-right">
                                                <button id="dropdownBottomButton"
                                                    data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                    data-dropdown-placement="bottom" class="" type="button">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                            d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div id="dropdownBottom_{{ $key }}"
                                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                                    <ul class="py-2 text-sm text-gray-700"
                                                        aria-labelledby="dropdownBottomButton">
                                                        <li>
                                                            <a href="{{ route('company.custom.invoices.pay', $invoice->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100">Mark as Pay</a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('company.custom.invoices.destroy', $invoice->id) }}"
                                                                id="form_{{ $invoice->id }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <a role="button" href="javascript:;"
                                                                    class="block px-4 py-2 hover:bg-gray-100"
                                                                    onclick="confirmDelete({{ $invoice->id }})">Delete</a>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">No invoices found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="p-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
