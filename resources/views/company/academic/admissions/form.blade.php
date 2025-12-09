@extends('layouts.layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="ltext-sm pl-2 capitalize text-white before:float-left before:pr-2 before:content-['/']">
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:float-left before:pr-2 before:content-['/']"
                aria-current="page">
                {{ isset($coupon) ? 'Edit' : 'Create' }} a Admission
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize"> {{ isset($coupon) ? 'Edit' : 'Create' }} a Admission</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white dark:bg-slate-850 dark:shadow-dark-xl rounded-3 my-3">
            <div class="card-title p-3 my-3 flex justify-between">
                <h5 class="font-bold dark:text-white">{{ isset($coupon) ? 'Edit' : 'Create' }} a Admission</h5>
                <a href="{{ route('admin.coupons.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full text-sm">Back</a>
            </div>
        </div>

        <div class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl p-6">

            <form id="admissionForm" method="POST" action="{{ route('admin.admissions.store') }}">
                @csrf

                {{-- Student search (simple) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Student</label>
                    <input type="text" id="studentSearch" value="{{ old('student_display') }}"
                        placeholder="Search name/email/mobile" class="border p-2 rounded w-full" autocomplete="off">
                    <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">
                    <div id="studentResults" class="hidden mt-1 bg-white border rounded overflow-auto"
                        style="max-height:200px"></div>
                    @error('student_id')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Course select (ajax) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Course</label>
                    <select id="courseSelect" name="course_id" class="w-full p-2 border rounded">
                        @if (old('course_id') && ($c = \App\Models\Course::find(old('course_id'))))
                            <option value="{{ $c->id }}" selected>{{ $c->title }}</option>
                        @endif
                    </select>
                    @error('course_id')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Course details --}}
                <div id="courseDetails" class="p-4 border rounded mb-4 hidden">
                    <div id="cd_title" class="font-semibold text-lg"></div>
                    <p id="cd_desc" class="text-sm text-gray-600 mt-1"></p>
                    <div class="mt-2 text-sm text-gray-700">
                        Price: <span id="cd_actual_price"></span> &nbsp;
                        Discounted: <span id="cd_net_price"></span> &nbsp;
                        Hours: <span id="cd_hours"></span>
                    </div>
                </div>

                {{-- Coupon --}}
                <div class="mb-4 grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium">Coupon Code</label>
                        <input type="text" id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}"
                            class="w-full border rounded p-2" />
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="applyCoupon"
                            class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
                    </div>
                    <div class="col-span-2">
                        <p id="couponMsg" class="text-sm text-green-600"></p>
                    </div>
                </div>

                {{-- Price / tax / totals --}}
                <div class="mb-4 grid grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm">Actual Price</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                            class="w-full p-2 border rounded" required />
                    </div>

                    <div>
                        <label class="block text-sm">Discount Amount</label>
                        <input type="number" step="0.01" name="discount_amount" id="discount_amount"
                            value="{{ old('discount_amount', 0) }}" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block text-sm">Tax (%)</label>
                        <input type="number" step="0.01" name="tax_percent" id="tax_percent"
                            value="{{ old('tax_percent', 0) }}" class="w-full p-2 border rounded" />
                        <div class="text-xs text-gray-500 mt-1">Tax included?
                            <label><input type="checkbox" name="tax_included" id="tax_included"
                                    {{ old('tax_included') ? 'checked' : '' }}> Yes</label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm">Grand Total</label>
                        <input type="number" step="0.01" name="grand_total" id="grand_total"
                            value="{{ old('grand_total') }}" class="w-full p-2 border rounded" required />
                    </div>
                </div>

                {{-- Installment toggle --}}
                <div class="mb-4">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" id="is_installment" name="is_installment" value="1"
                            {{ old('is_installment') ? 'checked' : '' }} />
                        <span>Pay by Installments</span>
                    </label>
                </div>

                {{-- Installment config --}}
                <div id="installmentBox" class="{{ old('is_installment') ? '' : 'hidden' }} mb-4 p-4 border rounded">
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-sm">Count</label>
                            <input type="number" min="1" id="installments_count" name="installments_count"
                                value="{{ old('installments_count', 1) }}" class="w-full p-2 border rounded" />
                        </div>
                        <div>
                            <label class="block text-sm">Interval (months)</label>
                            <select id="installment_interval_months" name="installment_interval_months"
                                class="w-full p-2 border rounded">
                                <option value="1" {{ old('installment_interval_months') == 1 ? 'selected' : '' }}>1
                                    month</option>
                                <option value="2" {{ old('installment_interval_months') == 2 ? 'selected' : '' }}>2
                                    months</option>
                                <option value="3" {{ old('installment_interval_months') == 3 ? 'selected' : '' }}>3
                                    months</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm">Additional amount (optional)</label>
                            <input type="number" step="0.01" id="installment_additional_amount"
                                name="installment_additional_amount" value="{{ old('installment_additional_amount', 0) }}"
                                class="w-full p-2 border rounded" />
                        </div>
                    </div>

                    <div class="mb-2 flex gap-2">
                        <button type="button" id="generateInstallments"
                            class="px-3 py-2 bg-indigo-600 text-white rounded">Generate</button>
                        <button type="button" id="resetInstallments"
                            class="px-3 py-2 bg-gray-300 rounded">Reset</button>
                    </div>

                    <div id="installmentsList" class="space-y-2 mt-3">
                        {{-- If old installments provided, render them here server side or will be generated by JS --}}
                        @if (old('installments'))
                            @foreach (old('installments') as $i => $ins)
                                <div class="flex gap-2 items-center">
                                    <input type="date" class="p-2 border rounded due-date"
                                        value="{{ $ins['date'] ?? '' }}">
                                    <input type="number" step="0.01" class="p-2 border rounded installment-amount"
                                        value="{{ $ins['amount'] ?? 0 }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="mt-4">
                        <p class="text-sm">Sum: <span id="installmentsSum">0</span> / Grand Total: <span
                                id="installmentsGrandTotal">0</span></p>
                        <p id="installmentError" class="text-red-600 text-sm hidden">Installment sum must equal grand
                            total.</p>
                    </div>
                </div>

                {{-- Hidden: we post installments[] dynamically --}}
                <div id="installmentInputs">
                    {{-- old hidden inputs if exist --}}
                    @if (old('installments'))
                        @foreach (old('installments') as $i => $ins)
                            <input type="hidden" name="installments[{{ $i }}][date]"
                                value="{{ $ins['date'] ?? '' }}">
                            <input type="hidden" name="installments[{{ $i }}][amount]"
                                value="{{ $ins['amount'] ?? 0 }}">
                        @endforeach
                    @endif
                </div>

                {{-- Notes --}}
                <div class="mb-4">
                    <label class="block text-sm">Notes (optional)</label>
                    <textarea name="notes" class="w-full p-2 border rounded" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 text-center align-center items-center w-full">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded"><i class="bi bi-currency-rupee"></i> Purchase </button>
                    <a href="{{ route('admin.admissions.index') }}" class="px-4 py-2 bg-gray-200 rounded">Reset</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        $(function() {

            /* ---------- student inline search (no select2) ---------- */
            let timer = null;
            $('#studentSearch').on('keyup', function() {
                const q = $(this).val().trim();
                clearTimeout(timer);
                if (q.length < 1) {
                    $('#studentResults').addClass('hidden').html('');
                    $('#student_id').val('');
                    return;
                }
                timer = setTimeout(() => {
                    $.get('{{ route('admin.admissions.student.search') }}', {
                        q
                    }, function(data) {
                        let html = '';
                        if (data.length === 0) html = '<div class="p-2">No results</div>';
                        data.forEach(u => {
                            html +=
                                `<div class="p-2 border-b cursor-pointer studentRow" data-id="${u.id}" data-name="${u.name}"><b>${u.name}</b><br><small>${u.email||''} ${u.mobile||''}</small></div>`;
                        });
                        $('#studentResults').removeClass('hidden').html(html);
                    }, 'json');
                }, 300);
            });

            $(document).on('click', '.studentRow', function() {
                $('#studentSearch').val($(this).data('name'));
                $('#student_id').val($(this).data('id'));
                $('#studentResults').addClass('hidden');
            });

            /* ---------- course select2 ---------- */
            $('#courseSelect').select2({
                placeholder: 'Search course by title',
                ajax: {
                    url: '{{ route('admin.admissions.course.search') }}',
                    dataType: 'json',
                    delay: 300,
                    data: params => ({
                        q: params.term
                    }),
                    processResults: function(data) {
                        return {
                            results: data.map(c => ({
                                id: c.id,
                                text: c.title
                            }))
                        };
                    }
                },
                minimumInputLength: 1,
                width: '100%'
            });

            $('#courseSelect').on('select2:select', function(e) {
                const id = e.params.data.id;
                $.get('{{ url('admin/admissions/course-info') }}/' + id, function(course) {
                    $('#courseDetails').removeClass('hidden');
                    $('#cd_title').text(course.title);
                    $('#cd_desc').text(course.description || '');
                    $('#cd_actual_price').text(course.actual_price ?? course.net_price ?? 0);
                    $('#cd_net_price').text(course.net_price ?? course.actual_price ?? 0);
                    $('#cd_hours').text(course.total_hours ?? '--');

                    // fill price & totals if empty or always override
                    $('#price').val(course.actual_price ?? course.net_price ?? 0);
                    $('#discount_amount').val(0);
                    let taxPercent = course.is_tax ? (course.tax_percent ?? 0) : 0;
                    $('#tax_percent').val(taxPercent);
                    // calc tax & grand_total
                    recalcTotals();
                });
            });

            /* coupon */
            $('#applyCoupon').on('click', function() {
                const code = $('#coupon_code').val().trim();
                if (!code) {
                    alert('Enter coupon code');
                    return;
                }
                $.post('{{ route('admin.admissions.coupon.validate') }}', {
                    _token: '{{ csrf_token() }}',
                    code
                }, function(res) {
                    if (!res.ok) {
                        $('#couponMsg').text(res.message).removeClass('text-green-600').addClass(
                            'text-red-600');
                        return;
                    }
                    $('#couponMsg').text('Coupon applied: -' + res.discount_amount).removeClass(
                        'text-red-600').addClass('text-green-600');
                    $('#discount_amount').val(res.discount_amount);
                    recalcTotals();
                }, 'json');
            });

            /* recalc totals: price, discount, tax include/exclude */
            function recalcTotals() {
                let price = parseFloat($('#price').val() || 0);
                let discount = parseFloat($('#discount_amount').val() || 0);
                let taxPercent = parseFloat($('#tax_percent').val() || 0);
                let taxIncluded = $('#tax_included').is(':checked');

                let taxableAmount = price - discount;

                let taxAmount = 0;
                if (taxIncluded) {
                    // price includes tax: extract tax portion
                    // taxAmount = taxableAmount - (taxableAmount / (1 + taxPercent/100))
                    if (taxPercent > 0) {
                        let base = taxableAmount / (1 + (taxPercent / 100));
                        taxAmount = taxableAmount - base;
                        taxableAmount = base;
                    } else {
                        taxAmount = 0;
                    }
                } else {
                    // tax excluded: add tax on top
                    taxAmount = (taxPercent / 100) * taxableAmount;
                }

                let grand = (taxableAmount + taxAmount);
                $('#tax_amount').remove(); // cleanup old hidden if any
                // append tax amount hidden so server can store direct number
                $('<input>').attr({
                    type: 'hidden',
                    id: 'tax_amount',
                    name: 'tax_amount',
                    value: taxAmount.toFixed(2)
                }).appendTo('#admissionForm');

                $('#grand_total').val(grand.toFixed(2));
                updateInstallmentGrandTotal();
            }

            $('#price, #discount_amount, #tax_percent, #tax_included').on('input change', recalcTotals);

            /* installment logic - reuse earlier code (generate, sync, sum) */
            $('#is_installment').on('change', function() {
                if ($(this).is(':checked')) $('#installmentBox').removeClass('hidden');
                else $('#installmentBox').addClass('hidden');
            });

            $('#generateInstallments').on('click', function() {
                const count = parseInt($('#installments_count').val() || 0);
                const interval = parseInt($('#installment_interval_months').val() || 1);
                const addAmount = parseFloat($('#installment_additional_amount').val() || 0);
                const grandTotal = parseFloat($('#grand_total').val() || 0) + addAmount;
                $('#installmentInputs').empty();
                $('#installmentsList').empty();

                if (!count || count <= 0) {
                    alert('Enter installment count');
                    return;
                }

                let base = (grandTotal / count);
                base = parseFloat(base.toFixed(2));
                // distribute rounding remainder to last installment
                let amounts = Array(count).fill(base);
                let sum = amounts.reduce((a, b) => a + b, 0);
                let diff = parseFloat((grandTotal - sum).toFixed(2));
                amounts[count - 1] = parseFloat((amounts[count - 1] + diff).toFixed(2));

                let start = moment();
                for (let i = 0; i < count; i++) {
                    let due = start.clone().add(i * interval, 'months').format('YYYY-MM-DD');
                    let amt = amounts[i];
                    const row = $(`
                <div class="flex gap-2 items-center">
                    <input type="date" class="p-2 border rounded due-date" name="installments[${i}][date]" value="${due}" />
                    <input type="number" step="0.01" class="p-2 border rounded installment-amount" name="installments[${i}][amount]" value="${amt}" />
                    <button type="button" class="btn-remove text-sm text-red-600">Remove</button>
                </div>
            `);
                    $('#installmentsList').append(row);
                }

                syncInstallmentInputs();
                recalcInstallmentSum();
            });

            $(document).on('click', '.btn-remove', function() {
                $(this).closest('div').remove();
                syncInstallmentInputs();
                recalcInstallmentSum();
            });

            $(document).on('input', '.installment-amount', function() {
                recalcInstallmentSum();
            });

            function syncInstallmentInputs() {
                $('#installmentInputs').empty();
                $('#installmentsList').find('div').each(function(idx, el) {
                    const date = $(el).find('.due-date').val();
                    const amount = $(el).find('.installment-amount').val();
                    $('#installmentInputs').append(
                        `<input type="hidden" name="installments[${idx}][date]" value="${date}" />`);
                    $('#installmentInputs').append(
                        `<input type="hidden" name="installments[${idx}][amount]" value="${amount}" />`);
                });
            }

            function recalcInstallmentSum() {
                let sum = 0;
                $('#installmentsList').find('.installment-amount').each(function() {
                    sum += parseFloat($(this).val() || 0);
                });
                $('#installmentsSum').text(sum.toFixed(2));
                $('#installmentsGrandTotal').text(parseFloat($('#grand_total').val() || 0).toFixed(2));
                const grand = parseFloat($('#grand_total').val() || 0);
                if (Math.abs(sum - grand) > 0.009) {
                    $('#installmentError').removeClass('hidden');
                } else {
                    $('#installmentError').addClass('hidden');
                }
                syncInstallmentInputs();
            }

            $('#admissionForm').on('submit', function(e) {
                if ($('#is_installment').is(':checked')) {
                    recalcInstallmentSum();
                    const sum = parseFloat($('#installmentsSum').text() || 0);
                    const grand = parseFloat($('#grand_total').val() || 0);
                    if (Math.abs(sum - grand) > 0.009) {
                        e.preventDefault();
                        alert('Installments total must equal Grand Total.');
                        return false;
                    }
                }
                // let the form submit
            });

            // initial recalc if old values present
            recalcTotals();
            recalcInstallmentSum();
        });
    </script>
@endpush
