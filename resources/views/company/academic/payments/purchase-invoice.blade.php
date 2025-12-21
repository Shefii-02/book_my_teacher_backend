<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        body:before {
            content: "PAID";
            position: fixed;
            top: 40%;
            left: 30%;
            font-size: 80px;
            color: #eeeeee;
            transform: rotate(-30deg);
        }

        .container {
            padding: 20px;
        }

        /* .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 12px;
            width: 100%;
        } */
        .invoice-title {
            width: 50%;
            text-align: right;
        }

        .logo {
            width: 50%;

        }

        .logo img {
            height: 50px;
        }

        .invoice-title h1 {
            margin: 0;
            color: #4f46e5;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background: #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-table td {
            padding: 8px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        .qr img {
            height: 80px;
        }
    </style>
</head>

<body>
    <div class="container">


        {{-- ================= HEADER ================= --}}
        {{-- ================= HEADER ================= --}}
        <table width="100%" style="border-bottom:2px solid #4f46e5; padding-bottom:12px;">
            <tr>
                <td width="50%" valign="top">
                    <img src="{{ public_path('assets/images/logo/BookMyTeacher-black.png') }}" style="height:50px;">
                    <p style="margin-top:8px;">
                        {{-- <strong>{{ config('app.name') }}</strong><br> --}}
                        GSTIN: {{ config('company.gst') }}<br>
                        {{ config('company.address') }}
                    </p>
                </td>

                <td width="50%" valign="top" align="right">
                    <h1 style="margin:0; color:#11249c;">INVOICE</h1>
                    <p style="margin-top:8px;">
                        Invoice #:
                        <strong>{{ str_pad($purchase->payments->order_id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                        Date: {{ date('d M Y', strtotime($purchase->created_at)) }}<br>
                        Status: <strong
                            style="
    background:#16a34a;
    color:#fff;
    padding:4px 8px;
    font-size:11px;
    border-radius:4px;
">PAID</strong>
                    </p>
                </td>
            </tr>
        </table>


        {{-- ================= BILL TO ================= --}}
        <table class="table">
            <tr>
                <td width="50%">
                    <strong>Billed To</strong><br>
                    {{ $purchase->student->name }}<br>
                    {{ $purchase->student->email }}<br>
                    {{ $purchase->student->mobile }}
                </td>
                <td width="50%">
                    <strong>Payment Info</strong><br>
                    Method: {{ strtoupper($purchase->payment_method ?? 'ONLINE') }}<br>
                    Transaction ID: {{ optional($purchase->payments->first())->transaction_id }}<br>
                    Order ID: {{ $purchase->payments->order_id }}
                </td>
            </tr>
        </table>

        {{-- ================= COURSE ITEMS ================= --}}
        <table class="table">
            <thead>
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
        {{-- ================= INSTALLMENTS ================= --}}
        @if ($purchase->is_installment)
            <h4>Installment Schedule</h4>
            <table class="table">
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
        @endif

        {{-- ================= TOTALS ================= --}}
        <table class="table">
            <tr>
                <td class="text-right">Subtotal</td>
                <td class="text-right">₹{{ number_format($purchase->price, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right">Discount</td>
                <td class="text-right">- ₹{{ number_format($purchase->discount_amount, 2) }}</td>
            </tr>

            @php
                $cgst = $purchase->tax_amount / 2;
                $sgst = $purchase->tax_amount / 2;
            @endphp

            <tr>
                <td class="text-right">CGST ({{ $purchase->tax_percent / 2 }}%)</td>
                <td class="text-right">₹{{ number_format($cgst, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right">SGST ({{ $purchase->tax_percent / 2 }}%)</td>
                <td class="text-right">₹{{ number_format($sgst, 2) }}</td>
            </tr>

            <tr>
                <th class="text-right">Grand Total</th>
                <th class="text-right">₹{{ number_format($purchase->grand_total, 2) }}</th>
            </tr>
        </table>

        {{-- ================= QR VERIFICATION ================= --}}
        <div class="qr">
            <p><strong>Verify Invoice</strong></p>
            <img
                src="data:image/png;base64,{{ base64_encode(
                    QrCode::format('png')->size(120)->generate(route('company.payments.invoice.verify', $purchase->payments->order_id)),
                ) }}">
        </div>

        {{-- ================= FOOTER ================= --}}
        <div class="footer">
            This is a system generated invoice. No signature required.<br>
            Thank you for choosing {{ config('app.name') }}.
        </div>

    </div>
</body>

</html>
