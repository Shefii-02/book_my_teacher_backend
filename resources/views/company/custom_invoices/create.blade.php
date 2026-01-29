@extends('layouts.layout')
@push('styles')
    <style>
        .input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-6xl mx-auto p-6">

        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h5 class="text-2xl font-bold text-indigo-600 mb-6">
                Create Custom Invoice
            </h5>

            <form id="invoiceForm" method="POST" action="{{ route('company.custom.invoices.store') }}">
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


                {{-- CUSTOMER --}}
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <input name="customer_name" placeholder="Customer Name" required class="input">
                    <input name="customer_email" placeholder="Email" class="input">
                    <input name="customer_mobile" placeholder="Mobile" class="input">
                    <textarea name="customer_address" placeholder="Address" class="input md:col-span-2"></textarea>
                </div>

                {{-- ITEMS --}}
                <h3 class="font-semibold text-lg mb-2">Invoice Items</h3>

                <table class="w-full mb-4 border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-sm">
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
                    <input name="discount" id="discount" placeholder="Discount" class="input">
                    <input name="tax_percent" id="tax_percent" placeholder="Tax %" class="input">
                    <input readonly id="grand_total" placeholder="Grand Total" class="input font-bold">
                </div>

                {{-- ACTIONS --}}
                <div class="flex gap-4">
                    <button type="button" onclick="previewInvoice()" class="px-6 py-2 bg-gray-800 text-white rounded-lg">
                        Preview
                    </button>

                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg">
                        Save & Generate
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- PREVIEW MODAL --}}
    <div id="previewModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl p-6 overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between mb-4">
                <h3 class="text-xl font-bold">Invoice Preview</h3>
                <button onclick="closePreview()" class="text-red-600 text-xl">×</button>
            </div>

            <div id="previewContent"></div>
        </div>
    </div>
@endsection
<script>
    $(function() {

        /* ---------- student inline search (no select2) ---------- */
        let timer = null;
        $('#studentSearch').on('keyup', function() {
            const q = $(this).val().trim();
            clearTimeout(timer);
            if (q.length < script 1) {
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
    });
</script>
<script>
    let itemIndex = 0;

    function addItem() {
        const row = `
    <tr>
        <td><input name="items[${itemIndex}][title]" class="input"></td>
        <td><input name="items[${itemIndex}][quantity]" value="1" class="input qty" oninput="calc()"></td>
        <td><input name="items[${itemIndex}][price]" class="input price" oninput="calc()"></td>
        <td class="p-2 font-semibold total">0</td>
        <td>
            <button type="button" onclick="this.closest('tr').remove(); calc()">🗑</button>
        </td>
    </tr>`;
        document.getElementById('itemsBody').insertAdjacentHTML('beforeend', row);
        itemIndex++;
    }

    function calc() {
        let subtotal = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const qty = row.querySelector('.qty')?.value || 0;
            const price = row.querySelector('.price')?.value || 0;
            const total = qty * price;
            row.querySelector('.total').innerText = total.toFixed(2);
            subtotal += total;
        });

        const discount = document.getElementById('discount').value || 0;
        const tax = document.getElementById('tax_percent').value || 0;
        const taxAmount = (subtotal * tax) / 100;

        document.getElementById('grand_total').value =
            (subtotal - discount + taxAmount).toFixed(2);
    }

    function previewInvoice() {
        calc();
        let html = `
        <p><strong>Customer:</strong> ${document.querySelector('[name="customer_name"]').value}</p>
        <hr class="my-3">
        <table class="w-full text-sm">
            <tr><th>Item</th><th>Qty</th><th>Total</th></tr>
    `;

        document.querySelectorAll('#itemsBody tr').forEach(row => {
            html += `
            <tr>
                <td>${row.querySelector('[name*="[title]"]').value}</td>
                <td>${row.querySelector('.qty').value}</td>
                <td>${row.querySelector('.total').innerText}</td>
            </tr>
        `;
        });

        html += `
        </table>
        <hr class="my-3">
        <p class="font-bold text-right">Grand Total: ₹${document.getElementById('grand_total').value}</p>
    `;

        document.getElementById('previewContent').innerHTML = html;
        document.getElementById('previewModal').classList.remove('hidden');
        document.getElementById('previewModal').classList.add('flex');
    }

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
    }
    addItem();
</script>
@endpush
