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
                <a href="{{ route('company.coupons.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full text-sm">Back</a>
            </div>
        </div>

        <div class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl p-6">
            <form id="admissionForm" method="POST" action="{{ route('company.admissions.store') }}">
                @csrf

                {{-- Student (ajax search using select2) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Student</label>
                    <input type="text" autocomplete="off" id="admissionUserSearch" placeholder="Search name/email/mobile"
                        class="border p-2 rounded w-full">
                    <input type="hidden" name="user_id" id="selectedUserId">
                    <div id="walletUserResults" style="max-height: calc(0.25rem * 56);min-height:120px"
                        class="bg-blue-200 hidden border mt-1.5 overflow-y-auto rounded"></div>
                </div>

                {{-- Course --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Course</label>
                    <select id="courseSelect" name="course_id" class="w-full"></select>
                    @error('course_id')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Course details (auto filled) --}}
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
                        <input type="text" id="coupon_code" name="coupon_code" class="w-full border rounded p-2" />
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="applyCoupon"
                            class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
                    </div>
                    <div class="col-span-2">
                        <p id="couponMsg" class="text-sm text-green-600"></p>
                    </div>
                </div>

                {{-- Prices & totals (editable) --}}
                <div class="mb-4 grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm">Actual Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border rounded"
                            required />
                    </div>
                    <div>
                        <label class="block text-sm">Discount Amount</label>
                        <input type="number" step="0.01" name="discount_amount" id="discount_amount"
                            class="w-full p-2 border rounded" />
                    </div>
                    <div>
                        <label class="block text-sm">Grand Total</label>
                        <input type="number" step="0.01" name="grand_total" id="grand_total"
                            class="w-full p-2 border rounded" required />
                    </div>
                </div>

                {{-- Installment toggle --}}
                <div class="mb-4">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" id="is_installment" name="is_installment" value="1"
                            class="form-checkbox" />
                        <span>Pay by Installments</span>
                    </label>
                </div>

                {{-- Installment config (shown when checked) --}}
                <div id="installmentBox" class="mb-4 p-4 border rounded hidden">
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-sm">Count</label>
                            <input type="number" min="1" id="installments_count" name="installments_count"
                                class="w-full p-2 border rounded" />
                        </div>
                        <div>
                            <label class="block text-sm">Interval (months)</label>
                            <select id="installment_interval_months" name="installment_interval_months"
                                class="w-full p-2 border rounded">
                                <option value="1">1 month</option>
                                <option value="2">2 months</option>
                                <option value="3">3 months</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm">Additional amount (optional)</label>
                            <input type="number" step="0.01" id="installment_additional_amount"
                                name="installment_additional_amount" class="w-full p-2 border rounded" />
                        </div>
                    </div>

                    <div class="mb-2 flex gap-2">
                        <button type="button" id="generateInstallments"
                            class="px-3 py-2 bg-indigo-600 text-white rounded">Generate</button>
                        <button type="button" id="resetInstallments"
                            class="px-3 py-2 bg-gray-300 rounded">Reset</button>
                    </div>

                    <div id="installmentsList" class="space-y-2 mt-3">
                        {{-- generated installment rows here --}}
                    </div>

                    <div class="mt-4">
                        <p class="text-sm">Sum: <span id="installmentsSum">0</span> / Grand Total: <span
                                id="installmentsGrandTotal">0</span></p>
                        <p id="installmentError" class="text-red-600 text-sm hidden">Installment sum must equal grand
                            total.</p>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="mb-4">
                    <label class="block text-sm">Notes (optional)</label>
                    <textarea name="notes" class="w-full p-2 border rounded" rows="3">{{ old('notes') }}</textarea>
                </div>

                {{-- Hidden: we post installments[] dynamically --}}
                <div id="installmentInputs"></div>

                <div class="flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save Purchase</button>
                    <a href="{{ route('company.admissions.index') }}" class="px-4 py-2 bg-gray-200 rounded">Reset</a>
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
        let searchTimer = null;

        // Search users by typing
        document.getElementById("admissionUserSearch").addEventListener("keyup", function() {
            let keyword = this.value.trim();
            // if (keyword.length < 2) return;
            let box = document.getElementById("walletUserResults");
            box.innerHTML = "";
            box.classList.add("hidden");


            if (keyword.length < 1) {

              box.innerHTML = "";
              box.classList.add("hidden");
          }



        clearTimeout(searchTimer); searchTimer = setTimeout(() => {
            fetch("{{ route('company.search-users') }}?key=" + keyword)
                .then(res => res.json())
                .then(data => {

                    box.innerHTML = "";
                    box.classList.remove("hidden");

                    if (data.length === 0) {
                        box.innerHTML = "<p class='p-2 text-gray-500'>No results</p>";
                        return;
                    }

                    data.forEach(u => {
                        let row = document.createElement("div");
                        row.classList = "p-2 border-b cursor-pointer hover:bg-gray-100";

                        row.innerHTML = `
                        <b>${u.name}</b><br>
                        <small>${u.email}</small><br>
                        <small>${u.mobile}</small><br>
                        <span class="text-xs uppercase bg-gray-200 px-2 rounded">${u.acc_type}</span>
                    `;

                        row.onclick = () => {
                            document.getElementById("admissionUserSearch").value = u.name +
                                " (" + u.mobile + ")";
                            document.getElementById("selectedUserId").value = u.id;
                            box.classList.add("hidden");
                        };

                        box.appendChild(row);
                    });
                });
        }, 400);
        });
    </script>

    <script>
        $(function() {

          // {{ route('company.admissions.course.search') }}

            // on course select -> load course info
            $('#courseSelect').on('select2:select', function(e) {
                const id = e.params.data.id;
                $.get('{{ url('admin/admissions/course-info') }}/' + id, function(course) {
                    $('#courseDetails').removeClass('hidden');
                    $('#cd_title').text(course.title);
                    $('#cd_desc').text(course.description || '');
                    $('#cd_actual_price').text(course.actual_price ?? course.net_price ?? '0');
                    $('#cd_net_price').text(course.net_price ?? course.actual_price ?? '0');
                    $('#cd_hours').text(course.total_hours ?? '--');

                    // fill price fields
                    $('#price').val(course.actual_price ?? course.net_price ?? 0);
                    $('#discount_amount').val(0);
                    $('#grand_total').val(course.net_price ?? course.actual_price ?? 0);

                    updateInstallmentGrandTotal();
                });
            });

            // apply coupon AJAX
            $('#applyCoupon').on('click', function() {
                const code = $('#coupon_code').val().trim();
                if (!code) return alert('Enter coupon code');
                $.post('{{ route('company.admissions.coupon.validate') }}', {
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
                    let price = parseFloat($('#price').val() || 0);
                    $('#discount_amount').val(res.discount_amount);
                    $('#grand_total').val((price - res.discount_amount).toFixed(2));
                    updateInstallmentGrandTotal();
                }, 'json');
            });

            // install toggle show/hide
            $('#is_installment').on('change', function() {
                if ($(this).is(':checked')) $('#installmentBox').removeClass('hidden');
                else $('#installmentBox').addClass('hidden');
            });

            // generate installments
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
                    // build row
                    const row = $(`
                <div class="flex gap-2 items-center">
                    <input type="date" class="p-2 border rounded due-date" name="installments[${i}][date]" value="${due}" />
                    <input type="number" step="0.01" class="p-2 border rounded installment-amount" name="installments[${i}][amount]" value="${amt}" />
                    <button type="button" class="btn-remove text-sm text-red-600">Remove</button>
                </div>
            `);
                    $('#installmentsList').append(row);

                    // create hidden inputs for submission as fallback (we keep them fresh later)
                }

                syncInstallmentInputs();
                recalcInstallmentSum();
            });

            // remove installment row
            $(document).on('click', '.btn-remove', function() {
                $(this).closest('div').remove();
                syncInstallmentInputs();
                recalcInstallmentSum();
            });

            // when amounts edited -> recalc
            $(document).on('input', '.installment-amount', function() {
                // keep total equal check
                recalcInstallmentSum();
            });

            // sync installments to hidden inputs before submit
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

            // recalc sum
            function recalcInstallmentSum() {
                let sum = 0;
                $('#installmentsList').find('.installment-amount').each(function() {
                    sum += parseFloat($(this).val() || 0);
                });
                $('#installmentsSum').text(sum.toFixed(2));
                $('#installmentsGrandTotal').text(parseFloat($('#grand_total').val() || 0).toFixed(2));
                // show error if mismatch
                const grand = parseFloat($('#grand_total').val() || 0);
                if (Math.abs(sum - grand) > 0.009) {
                    $('#installmentError').removeClass('hidden');
                } else {
                    $('#installmentError').addClass('hidden');
                }
                syncInstallmentInputs();
            }

            // ensure hidden inputs updated before submit
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
                // continue submit
            });

            // helpers
            function updateInstallmentGrandTotal() {
                const add = parseFloat($('#installment_additional_amount').val() || 0);
                const g = parseFloat($('#grand_total').val() || 0) + add;
                $('#installmentsGrandTotal').text(g.toFixed(2));
            }

            // keep hidden inputs updated when values change
            $('#installment_additional_amount, #grand_total').on('input', function() {
                updateInstallmentGrandTotal();
            });

        });
    </script>
@endpush
