@extends('layouts.layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="ltext-sm pl-2 capitalize text-white before:float-left before:pr-2 before:content-['/']">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
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
                <a href="{{ route('company.admission.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded text-sm">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back</a>
            </div>
        </div>

        <div class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl p-6">

            <form id="admissionForm" method="POST" action="{{ route('company.admissions.store') }}">
                @csrf
                <div class="flex h-screen overflow-hidden">

                    <!-- Left: Scrollable (col-9) -->
                    <div class="w-full overflow-y-auto ">
                        <!-- Your scroll content -->
                        <div class="p-6 space-y-4">
                            {{-- Student search (simple) --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Student</label>
                                <input type="text" id="studentSearch" value="{{ old('student_display') }}"
                                    placeholder="Search name/email/mobile" class="border p-2 rounded w-full"
                                    autocomplete="off">
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
                                <input type="text" id="courseSearch" value="{{ old('course_display') }}"
                                    placeholder="Search course search" class="border p-2 rounded w-full" autocomplete="off">
                                <input type="hidden" name="course_id" id="course_id" value="{{ old('course_id') }}">
                                <div id="courseResults" class="hidden mt-1 bg-white border rounded overflow-auto"
                                    style="max-height:200px"></div>
                                @error('course_id')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Course details --}}
                            <div id="courseDetails" class="p-4 border bg-white rounded rounded mb-4 hidden">
                                <div class="flex gap-2">

                                    Course Name : <div id="cd_title" class="font-semibold text-lg"></div>
                                </div>
                                <div class="flex gap-2">
                                    Description : <p id="cd_desc" class="text-sm text-gray-600 mt-1"></p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700">
                                    Price: <span id="cd_actual_price"></span> &nbsp;
                                    Discounted: <span id="cd_net_price"></span> &nbsp;
                                    Hours: <span id="cd_hours"></span>
                                </div>
                            </div>


                            {{-- Installment toggle --}}
                            <div class="InstallmentOption">

                            </div>

                            {{-- Installment config --}}
                            <div id="installmentBox"
                                class="{{ old('is_installment') ? '' : 'hidden' }} mb-4 p-4 border rounded">
                                <div class="grid grid-cols-3 gap-3 mb-3">
                                    <div>
                                        <label class="block text-sm">Count</label>
                                        <input type="number" min="1" id="installments_count"
                                            name="installments_count" value="{{ old('installments_count', 1) }}"
                                            class="w-full p-2 border rounded" />
                                    </div>
                                    <div>
                                        <label class="block text-sm">Interval (months)</label>
                                        <select id="installment_interval_months" name="installment_interval_months"
                                            class="w-full p-2 border rounded">
                                            <option value="1"
                                                {{ old('installment_interval_months') == 1 ? 'selected' : '' }}>1
                                                month</option>
                                            <option value="2"
                                                {{ old('installment_interval_months') == 2 ? 'selected' : '' }}>2
                                                months</option>
                                            <option value="3"
                                                {{ old('installment_interval_months') == 3 ? 'selected' : '' }}>3
                                                months</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm">Additional amount (optional)</label>
                                        <input type="number" step="0.01" id="installment_additional_amount"
                                            name="installment_additional_amount"
                                            value="{{ old('installment_additional_amount', 0) }}"
                                            class="w-full p-2 border rounded" />
                                    </div>
                                </div>

                                <div class="mb-2 flex gap-2">
                                    <button type="button" id="generateInstallments"
                                        class="px-3 py-2 bg-indigo-600 text-white rounded">Re-Generate</button>
                                    {{-- <button type="button" id="resetInstallments"
                                        class="px-3 py-2 bg-gray-300 rounded">Reset</button> --}}
                                </div>

                                <div id="installmentsList" class="space-y-2 mt-3">
                                    {{-- If old installments provided, render them here server side or will be generated by JS --}}
                                    @if (old('installments'))
                                        @foreach (old('installments') as $i => $ins)
                                            <div class="flex gap-2 items-center">
                                                <input type="date" class="p-2 border rounded due-date"
                                                    value="{{ $ins['date'] ?? '' }}">
                                                <input type="number" step="0.01"
                                                    class="p-2 border rounded installment-amount"
                                                    value="{{ $ins['amount'] ?? 0 }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <p class="text-sm">Sum: <span id="installmentsSum">0</span> / Grand Total: <span
                                            id="installmentsGrandTotal">0</span></p>
                                    <p id="installmentError" class="text-red-600 text-sm hidden">Installment sum must
                                        equal grand
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

                        </div>
                    </div>

                    <!-- Right: Fixed (col-3) -->
                    <div class="w-4/12 h-screen  overflow-auto sticky top-0 bg-white border-l p-6">

                        {{-- Price / tax / totals --}}
                        <div class="flex flex-col gap-3 grid-cols-4 items-start mb-4 w-full">


                            <div class="CouponCode">
                                {{-- Coupon --}}
                            </div>
                            <div>
                                <label class="block text-sm">Actual Price</label>
                                <input type="number" step="0.01" readonly disabled name="price" id="price"
                                    value="{{ old('price') }}" class="w-full p-2 border rounded" required />
                            </div>

                            <div>
                                <label class="block text-sm">Discount Amount</label>
                                <input type="number" step="0.01" readonly disabled name="discount_amount"
                                    id="discount_amount" value="{{ old('discount_amount', 0) }}"
                                    class="w-full p-2 border rounded" />
                            </div>

                            <div>
                                <label class="block text-sm">Sub Total</label>
                                <input type="number" step="0.01" readonly disabled name="sub_total" id="sub_total"
                                    value="{{ old('sub_total') }}" class="w-full p-2 border rounded" required />
                            </div>

                            <div>
                                <label class="block text-sm">Tax</label>
                                <input class="hidden" type="checkbox" id="tax_included">
                                <input class="hidden" type="text" id="tax_percent">
                                <input type="number" readonly step="0.01" name="tax" id="tax"
                                    value="{{ old('tax', 0) }}" class="w-full p-2 border rounded" />
                            </div>

                            <div>
                                <label class="block text-sm">Grand Total</label>
                                <input type="number" step="0.01" readonly disabled name="grand_total"
                                    id="grand_total" value="{{ old('grand_total') }}" class="w-full p-2 border rounded"
                                    required />
                            </div>
                            <div>
                                <label class="block text-sm mb-2">Payment Method</label>
                                <div class="flex items-center mb-4">
                                    <input id="online-radio-1" type="radio" value="online" checked
                                        name="payment_method"
                                        class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
                                    <label for="online-radio-1"
                                        class="select-none ms-2 text-sm font-medium text-heading">Online Payment</label>
                                </div>
                                <div class="flex items-center mb-4">
                                    <input id="manually-radio-1" type="radio" value="manually" name="payment_method"
                                        class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
                                    <label for="manually-radio-1"
                                        class="select-none ms-2 text-sm font-medium text-heading">Manually Payment</label>
                                </div>
                                <div class="flex items-center mb-4">
                                    <input id="in-cash-radio-1" type="radio" value="in-cash" name="payment_method"
                                        class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
                                    <label for="in-cash-radio-1"
                                        class="select-none ms-2 text-sm font-medium text-heading">In-cash Payment</label>
                                </div>
                            </div>

                            <div class="flex gap-3 text-center align-center items-center  mt-5">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded"><i
                                        class="bi bi-currency-rupee"></i> Purchase </button>
                                {{-- <a href="{{ route('company.admissions.index') }}"
                                    class="px-4 py-2 bg-gray-200 rounded">Reset</a> --}}
                            </div>
                        </div>
                    </div>

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
                    $.get('{{ route('company.admissions.student.search') }}', {
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


            /* ---------- course inline search (no select2) ---------- */
            let timer2 = null;
            $('#courseSearch').on('keyup', function() {
                const q = $(this).val().trim();
                clearTimeout(timer2);
                if (q.length < 1) {
                    $('#courseResults').addClass('hidden').html('');
                    $('#course_id').val('');
                    $('.CouponCode').html('')
                    return;
                }
                timer2 = setTimeout(() => {
                    $.get('{{ route('company.admissions.course.search') }}', {
                        q
                    }, function(data) {
                        let html = '';
                        if (data.length === 0) html = '<div class="p-2">No results</div>';
                        data.forEach(u => {
                            html +=
                                `<div class="p-2 border-b cursor-pointer courseRow"
                                data-id="${u.id}" data-name="${u.title}">
                                <b>Course : ${u.title}</b><br><small>
                                  Net Price : ${u.net_price ||''} Actual Price : ${u.actual_price || ''}</small></div>`;

                        });
                        $('#courseResults').removeClass('hidden').html(html);
                    }, 'json');
                }, 300);
            });

            $(document).on('click', '.courseRow', function() {
                $('#courseSearch').val($(this).data('name'));
                $('#course_id').val($(this).data('id'));
                $('#courseResults').addClass('hidden');

                var id = $(this).data('id');
                $('.CouponCode').html('');
                $('.InstallmentOption').html('');


                $.get('{{ url('company/admissions/course-info') }}/' + id, function(course) {
                    $('#courseDetails').removeClass('hidden');
                    $('#thumb_img').attr('src', course.thumbnail_url);
                    $('#cd_title').text(course.title);
                    $('#cd_desc').text(course.description || '');
                    $('#cd_actual_price').text(course.net_price ?? 0);
                    $('#cd_net_price').text(course.net_price ?? 0);
                    $('#cd_hours').text(course.total_hours ?? '--');

                    // fill price & totals if empty or always override
                    $('#price').val(course.net_price ?? 0);
                    $('#discount_amount').val(0);
                    let taxPercent = course.is_tax != 'included' ? (course.tax_percentage ?? 0) : 0;

                    course.is_tax != 'included' ? $('#tax_included').attr('checked', true) : $(
                        '#tax_included').attr('checked', false);
                    $('#tax_percent').val(taxPercent);


                    if (course.coupon_available === 1) {
                        var CouponCode = `
                        <div class="">
                                          <div class="flex">
                                              <div>
                                                  <label class="block text-sm font-medium">Coupon Code</label>
                                                  <input type="text" id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}"
                                                      class="w-full border rounded p-2" />
                                              </div>
                                              <div class="flex items-end">
                                                  <button type="button" id="applyCoupon"
                                                      class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
                                              </div>

                                              </div>
                                               <div class="w-full mt-2">
                                                  <p id="couponMsg" class="text-sm text-green-600"></p>
                                              </div>
                                          </div>`;
                        $('.CouponCode').html(CouponCode)
                    }
                    if (course.allow_installment === 1) {
                        var InstallmentOption = `<div class="mb-4">
                                                    <label class="inline-flex items-center gap-2">
                                                        <input type="checkbox" class="border" id="is_installment" name="is_installment"
                                                            value="1" {{ old('is_installment') ? 'checked' : '' }} />
                                                        <span>Pay by Installments</span>
                                                    </label>
                                                </div>`;
                        $('.InstallmentOption').html(InstallmentOption)
                    }

                    // calc tax & grand_total
                    recalcTotals();
                });
            });


            /* coupon */
            $(document).on('click', '#applyCoupon', function() {

                const code = $('#coupon_code').val().trim();
                const stdId = $('#student_id').val().trim();
                const courseId = $('#course_id').val().trim();

                $('#couponMsg').text('');
                $('#discount_amount').val(0);

                // Check empty coupon
                if (!code) {
                    alert('Enter coupon code');
                    syncInstallmentInputs();
                    recalcInstallmentSum();
                    recalcTotals();
                    return;
                }

                // Check course selected
                if (!courseId) {
                    alert('Please select course first');
                    syncInstallmentInputs();
                    recalcInstallmentSum();
                    recalcTotals();
                    return;
                }

                // Check student selected
                if (!stdId) {
                    alert('Please select student first');
                    syncInstallmentInputs();
                    recalcInstallmentSum();
                    recalcTotals();
                    return;
                }

                // Apply coupon
                $.post('{{ route('company.admissions.coupon.validate') }}', {
                    _token: '{{ csrf_token() }}',
                    code: code,
                    student_id: stdId,
                    course_id: courseId
                }, function(res) {

                    if (!res.ok) {
                        $('#couponMsg')
                            .text(res.message)
                            .removeClass('text-green-600')
                            .addClass('text-red-600');

                        syncInstallmentInputs();
                        recalcInstallmentSum();
                        recalcTotals();
                        return;
                    }

                    $('#couponMsg')
                        .text('Coupon applied: -' + res.discount_amount)
                        .removeClass('text-red-600')
                        .addClass('text-green-600');

                    $('#discount_amount').val(res.discount_amount);

                    syncInstallmentInputs();
                    recalcInstallmentSum();
                    recalcTotals();


                    if ($('#is_installment').is(':checked')) {
                      $('#generateInstallments').trigger('click')
                    }

                }, 'json');
            });


            /* recalc totals: price, discount, tax include/exclude */
            function recalcTotals() {
                let price = parseFloat($('#price').val() || 0);
                let discount = parseFloat($('#discount_amount').val() || 0);
                let taxPercent = parseFloat($('#tax_percent').val() || 0);
                let taxIncluded = $('#tax_included').is(':checked');
                const addAmount = parseFloat($('#installment_additional_amount').val() || 0);

                let taxableAmount = (price - discount) + addAmount;

                let taxAmount = 0;
                if (!taxIncluded) {
                    // price includes tax: extract tax portion
                    // taxAmount = taxableAmount - (taxableAmount / (1 + taxPercent / 100))
                    // if (taxPercent > 0) {
                    //     let base = taxableAmount / (1 + (taxPercent / 100));
                    //     taxAmount = taxableAmount - base;
                    //     taxableAmount = base;
                    // } else {
                    taxAmount = 0;
                    // }
                } else {
                    // tax excluded: add tax on top
                    taxAmount = (taxPercent / 100) * taxableAmount;
                }

                let subT = (taxableAmount);
                let grand = (taxableAmount + taxAmount);
                $('#tax_amount').remove(); // cleanup old hidden if any
                // append tax amount hidden so server can store direct number
                $('#tax').val(taxAmount.toFixed(2));

                $('#sub_total').val(subT.toFixed(2))
                $('#grand_total').val(grand.toFixed(2));
                // updateInstallmentGrandTotal();
            }

            $(document).on('input change', '#price, #discount_amount, #tax_percent, #tax_included', recalcTotals);

            /* installment logic - reuse earlier code (generate, sync, sum) */
            $(document).on('change', '#is_installment', function() {

                if ($(this).is(':checked')) $('#installmentBox').removeClass('hidden');
                else $('#installmentBox').addClass('hidden');
            });
            // #installments_count
            $(document).on('input change keyup', '#installment_additional_amount, #installment_interval_months',
                function() {
                    $('#generateInstallments').click();
                });

            $(document).on('click', '#generateInstallments', function() {
                const count = parseInt($('#installments_count').val() || 0);
                const interval = parseInt($('#installment_interval_months').val() || 1);
                const addAmount = parseFloat($('#installment_additional_amount').val() || 0);
                const grandTotal = parseFloat($('#grand_total').val() || 0);
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
                </div>
            `);
                    /* <button type="button" class="btn-remove text-sm text-red-600">Remove</button>*/

                    $('#installmentsList').append(row);
                }

                syncInstallmentInputs();
                recalcInstallmentSum();
                recalcTotals();
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

                const addAmount = parseFloat($('#installment_additional_amount').val() || 0);
                const grandTotal = parseFloat($('#grand_total').val() || 0);
                $('#installmentsGrandTotal').text(parseFloat(grandTotal || 0).toFixed(2));
                // const grand = parseFloat($('#grand_total').val() || 0);
                if (Math.abs(sum - grandTotal) > 0.009) {
                    $('#installmentError').removeClass('hidden');
                } else {
                    $('#installmentError').addClass('hidden');
                }
                syncInstallmentInputs();
            }

            $(document).on('submit', '#admissionForm', function(e) {
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
