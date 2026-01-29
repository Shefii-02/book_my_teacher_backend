@extends('layouts.layout')


@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-2xl font-bold text-indigo-600 mb-6">Create Custom Invoice</h2>

            <form method="POST" action="{{ route('company.custom.invoices.store') }}" id="invoiceForm">
                @csrf

                {{-- CUSTOMER TYPE --}}
                <div class="flex gap-6 mb-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="customer_type" value="student" checked>
                        Student
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="customer_type" value="manual">
                        Manual Customer
                    </label>
                </div>

                {{-- STUDENT SEARCH (OPTIONAL) --}}
                <div  id="studentBox" class="mb-4">
                    <label class="font-sm">Search Student (optional)</label>
                    <input type="text" id="studentSearch" class="border" placeholder="Search by name / email / mobile">
                    <input type="hidden" name="student_id" id="student_id">

                    <div id="studentResults" class="border mt-1 rounded hidden max-h-48 overflow-auto bg-white"></div>
                </div>

                {{-- CUSTOMER DETAILS (AUTO-FILL OR MANUAL) --}}
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <input name="customer_name" id="customer_name" placeholder="Customer Name" class="border" required>

                    <input name="customer_email" id="customer_email" placeholder="Email" class="border">

                    <input name="customer_mobile" id="customer_mobile" placeholder="Mobile" class="border">

                    <textarea name="customer_address" id="customer_address" placeholder="Address" class="border md:col-span-2"></textarea>
                </div>


                {{-- ITEMS --}}
                <h3 class="font-semibold text-lg mb-2">Invoice Items</h3>
                <table class="w-full border rounded-lg mb-3">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Item</th>
                            <th class="p-2 w-20">Qty</th>
                            <th class="p-2 w-28">Price</th>
                            <th class="p-2 w-28">Total</th>
                            <th class="p-2 w-10"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody"></tbody>
                </table>

                <button type="button" onclick="addItem()" class="mb-6 px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    + Add Item
                </button>

                {{-- TOTALS --}}
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <input name="discount" id="discount" placeholder="Discount" class="input" oninput="calc()">
                    <input name="tax_percent" id="tax_percent" placeholder="Tax %" class="input" oninput="calc()">
                    <input id="grand_total" readonly class="input font-bold" placeholder="Grand Total">
                </div>

                {{-- ACTIONS --}}
                <div class="flex gap-4">
                    <button type="button" onclick="previewInvoice()" class="px-6 py-2 bg-gray-800 text-white rounded-lg">
                        Preview
                    </button>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg">
                        Save Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- PREVIEW MODAL --}}
    <div id="previewModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl p-6">
            <div class="flex justify-between mb-4">
                <h3 class="text-xl font-bold">Invoice Preview</h3>
                <button onclick="closePreview()" class="text-xl text-red-600">×</button>
            </div>
            <div id="previewContent"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let itemIndex = 0;

        /* ---------- toggle customer type ---------- */
        $('input[name="customer_type"]').on('change', function() {
            if (this.value === 'student') {
                $('#studentBox').show();
                $('#manualBox').hide().find('input,textarea').val('');
            } else {
                $('#studentBox').hide();
                $('#manualBox').show();
                $('#student_id').val('');
            }
        });

        /* ---------- student search ---------- */

        $('#studentSearch').on('keyup', function() {
            let q = $(this).val().trim();
            if (q.length < 2) {
                $('#studentResults').addClass('hidden').html('');
                return;
            }

            $.get("{{ route('company.admissions.student.search') }}", {
                q
            }, function(data) {
                let html = '';
                if (data.length === 0) {
                    html = '<div class="p-2 text-gray-500">No results</div>';
                } else {
                    data.forEach(s => {
                        html += `
                <div class="p-2 border-b cursor-pointer studentRow"
                     data-id="${s.id}"
                     data-name="${s.name ?? ''}"
                     data-email="${s.email ?? ''}"
                     data-mobile="${s.mobile ?? ''}"
                     data-address="${s.address ?? ''}">
                    <b>${s.name}</b><br>
                    <small>${s.email ?? ''} ${s.mobile ?? ''}</small>
                </div>`;
                    });
                }

                $('#studentResults').html(html).removeClass('hidden');
            });
        });

        /* click → auto-fill */
        $(document).on('click', '.studentRow', function() {
            $('#student_id').val($(this).data('id'));

            $('#customer_name').val($(this).data('name'));
            $('#customer_email').val($(this).data('email'));
            $('#customer_mobile').val($(this).data('mobile'));
            $('#customer_address').val($(this).data('address'));

            $('#studentResults').addClass('hidden');
        });



        /* ---------- items ---------- */
        function addItem() {
            $('#itemsBody').append(`
        <tr>
            <td><input name="items[${itemIndex}][title]" class="input" required></td>
            <td><input name="items[${itemIndex}][quantity]" value="1" class="input qty" oninput="calc()"></td>
            <td><input name="items[${itemIndex}][price]" class="input price" oninput="calc()"></td>
            <td class="total p-2 font-semibold">0</td>
            <td><button type="button" onclick="$(this).closest('tr').remove();calc()">🗑</button></td>
        </tr>
    `);
            itemIndex++;
        }

        /* ---------- calc ---------- */
        function calc() {
            let subtotal = 0;
            $('#itemsBody tr').each(function() {
                let q = $(this).find('.qty').val() || 0;
                let p = $(this).find('.price').val() || 0;
                let t = q * p;
                $(this).find('.total').text(t.toFixed(2));
                subtotal += t;
            });

            let discount = $('#discount').val() || 0;
            let tax = $('#tax_percent').val() || 0;
            let taxAmount = subtotal * tax / 100;

            $('#grand_total').val((subtotal - discount + taxAmount).toFixed(2));
        }

        /* ---------- preview ---------- */
        function previewInvoice() {
            calc();
            let html = `<table class="w-full text-sm">`;
            $('#itemsBody tr').each(function() {
                html += `<tr>
            <td>${$(this).find('[name*="[title]"]').val()}</td>
            <td>${$(this).find('.qty').val()}</td>
            <td>${$(this).find('.total').text()}</td>
        </tr>`;
            });
            html += `</table><p class="text-right font-bold mt-3">Total: ₹${$('#grand_total').val()}</p>`;
            $('#previewContent').html(html);
            $('#previewModal').removeClass('hidden').addClass('flex');
        }

        function closePreview() {
            $('#previewModal').addClass('hidden');
        }

        addItem();
    </script>
@endpush
