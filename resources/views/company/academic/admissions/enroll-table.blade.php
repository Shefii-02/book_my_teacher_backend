<div class="flex-auto px-0 pt-5 pb-2">
    <div class="p-0 overflow-x-auto">
        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
            <thead class="align-bottom">
                <tr>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        #</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        User</th>
                    <th
                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Title</th>
                    <th
                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Amount</th>

                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Type</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Reg:at</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Status</th>
                    <th
                        class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none  text-slate-400 opacity-70">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions ?? [] as $key => $transaction)
                @php
                      $key = ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration;
                @endphp
                    <tr>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ $key }}
                        </td>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            <div class="flex px-2 py-1">

                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                        {{ $transaction->user_name }}</h6>
                                         <span
                                    class="w-20 bg-gradient-to-tl capitalize {{ $transaction->acc_type == 'teacher' ? 'from-slate-600 to-slate-300' : 'from-emerald-500 to-teal-400' }}  text-xs rounded-1.8 inline-block  text-center align-baseline font-bold  leading-none text-white">
                                    {{ $transaction->acc_type }}</span>
                                    <p
                                        class="my-1 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                        <a href="#" class="__cf_email__ lowercase"
                                            title="{{ $transaction->email }}">{{ Str::limit($transaction->email, 12, '..') }}</a>
                                    </p>
                                    <p
                                        class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                        <a href="#" class="__cf_email__"
                                            title="{{ $transaction->mobile }}">{{ Str::limit($transaction->mobile, 12, '..') }}</a>
                                    </p>
                                    <div class="flex gap-3">
                                        <a target="_blank"
                                            href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $transaction->mobile }}"
                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                            <i class="bi bi-whatsapp text-green-400"></i></a>
                                        <a target="_blank" href="tel://{{ $transaction->mobile }}"
                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                            <i class="bi bi-telephone text-blue-400"></i></a>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            <span>{{ $transaction->section }}</span>
                            <span>{{ $transaction->title }}</span>
                        </td>

                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                               {{-- Price : <span>{{ $transaction->price }} </span><br>
                            Discount : <span>{{ $transaction->discount_amount }} </span><br>
                            Tax : <span>{{ $transaction->tax_percent }}%
                                {{ $transaction->grand_total }}</span><br>
                            Grand Total : <span>{{ $transaction->grand_total }} </span> --}}
                            <span>{{ $transaction->amount }}</span>
                        </td>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                             <span>{{ $transaction->trans_type }} </span>
                        </td>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                             <span>{{ $transaction->created_at }} </span>
                            {{-- Created At : <span>{{ $transaction->created_at }} </span> --}}
                        </td>
                        <td
                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent capitalize">

                            @if ($transaction->status == 'pending')
                                <span
                                    class="bg-gradient-to-tl capitalize  from-slate-600 to-slate-300  px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">
                                    Unpaid</span>
                            @elseif($transaction->status == 'paid')
                                <span
                                    class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Paid</span>
                            @elseif($transaction->status == 'rejected')
                                <span
                                    class="bg-gradient-to-tl capitalize from-red-200 to-red-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Rejected</span>
                            @endif
                        </td>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            <button id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                data-dropdown-placement="bottom" class="" type="button">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownBottom_{{ $key }}"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownBottomButton">
                                     @if ($transaction->status === 'pending')
                                        <li>
                                            <a href="{{ route('company.payments.init', $transaction->payments->order_id) }}"
                                                class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">
                                                Pay Now</a>
                                        </li>
                                        <li>
                                            <a href="#" onclick="openRejectModal({{ $transaction->id }})"
                                                class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">
                                                Reject</a>
                                        </li>
                                    @elseif($transaction->status === 'paid')
                                        <li>
                                            <a href="{{ route('company.payments.invoice.download', $transaction->id) }}"
                                                class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Download
                                                Invoice</a>
                                        </li>
                                    @elseif($transaction->status === 'rejected')
                                        <li class="text-center">
                                            <span class="text-red-500  capitalize font-bold">Rejected</span>

                                        </li>
                                    @endif

                                    <li>
                                        <form id="form_{{ $transaction->id }}" class="m-0 p-0"
                                            action="{{ route('company.payments.destroy', $transaction->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf @method('DELETE') </form>
                                        <a role="button" href="javascript:;"
                                            class="block px-4 py-2 hover:bg-gray-100 capitalize dark:hover:bg-white dark:hover:text-white"
                                            onclick="confirmDelete({{ $transaction->id }})">Delete</a>
                                    </li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- <div class="d-flex justify-content-center m-4">
    {!! $transactions->links() !!}
</div>
<p class="p-3">Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of
    {{ $transactions->total() }} transations.</p> --}}
