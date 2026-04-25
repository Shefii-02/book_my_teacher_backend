<?php────────────────────────────────────────────────────────

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── 1. Purchase Info ──────────────────────────────────────────────────────────
// GET /api/course/{id}/purchase-info

Route::get('course/{id}/purchase-info', function ($id) {
    return response()->json([
        'status'  => true,
        'message' => 'Purchase info fetched successfully',
        'data'    => [

            // ── Course basic details ──────────────────────────────────────────
            'course' => [
                'id'            => (int) $id,
                'title'         => 'Advanced Mathematics & Problem Solving',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800',
                'type_class'    => 'live',        // live | recorded | crash
                'level'         => 'beginner',    // beginner | intermediate | advanced
                'duration'      => '6 months',
                'mode'          => 'online',
                'student_count' => 42,
            ],

            // ── Pricing ───────────────────────────────────────────────────────
            'pricing' => [
                'course_fee'     => 2000.00,
                'gst_rate'       => 18,           // percent
                'gst_amount'     => 360.00,        // 2000 * 18%
                'original_price' => 2360.00,       // before any coupon
                'total_amount'   => 2360.00,       // same as original at load time
                'currency'       => 'INR',
            ],

            // ── Feature flags ─────────────────────────────────────────────────
            'coupon_allowed'     => true,          // set false to hide coupon section
            'instalment_allowed' => true,          // set false to hide instalment section

            // ── Available coupons for this user + course ──────────────────────
            // Only returned when coupon_allowed = true
            'coupons' => [
                [
                    'id'              => 1,
                    'code'            => 'SAVE20',
                    'description'     => '20% off on this course (max ₹400)',
                    'type'            => 'percent',   // percent | flat
                    'value'           => 20,           // 20%
                    'max_discount'    => 400.00,
                    'discount_amount' => 400.00,       // pre-calculated for display
                    'expires_at'      => '2025-12-31',
                ],
                [
                    'id'              => 2,
                    'code'            => 'FIRST50',
                    'description'     => 'First purchase flat discount',
                    'type'            => 'flat',
                    'value'           => 200,
                    'max_discount'    => null,
                    'discount_amount' => 200.00,
                    'expires_at'      => '2025-09-30',
                ],
                [
                    'id'              => 3,
                    'code'            => 'REFER10',
                    'description'     => 'Referral bonus reward',
                    'type'            => 'flat',
                    'value'           => 100,
                    'max_discount'    => null,
                    'discount_amount' => 100.00,
                    'expires_at'      => null,
                ],
            ],

            // ── Instalment schedule ───────────────────────────────────────────
            // Only returned when instalment_allowed = true
            // Amounts here are BEFORE coupon — Flutter recalculates after coupon
            'instalments' => [
                [
                    'instalment_number' => 1,
                    'label'             => 'Instalment 1 of 2',
                    'due_date'          => now()->toDateString(),
                    'due_date_label'    => 'Today',
                    'amount'            => 1180.00,   // 50% of 2360
                    'percentage'        => 50,
                    'status'            => 'pay_now',
                ],
                [
                    'instalment_number' => 2,
                    'label'             => 'Instalment 2 of 2',
                    'due_date'          => now()->addDays(30)->toDateString(),
                    'due_date_label'    => now()->addDays(30)->format('d M Y'),
                    'amount'            => 1180.00,
                    'percentage'        => 50,
                    'status'            => 'pay_later',
                ],
            ],

            // ── Available payment methods ─────────────────────────────────────
            // Only include methods that are configured/enabled on your backend
            'payment_methods' => [
                [
                    'key'         => 'upi',
                    'label'       => 'Direct UPI',
                    'description' => 'Pay via UPI ID — instant redirect',
                    'upi_id'      => 'bookmyteacher@upi',
                    'icon'        => 'upi',
                ],
                [
                    'key'         => 'phonepe',
                    'label'       => 'PhonePe',
                    'description' => 'PhonePe payment gateway',
                    'icon'        => 'phonepe',
                ],
                [
                    'key'         => 'razorpay',
                    'label'       => 'Razorpay',
                    'description' => 'Cards, NetBanking, Wallets & more',
                    'key_id'      => 'rzp_test_xxxxxxxxxxxxxxx',  // your Razorpay key
                    'icon'        => 'razorpay',
                ],
                [
                    'key'         => 'pay_later',
                    'label'       => 'Pay Later',
                    'description' => 'Register now, pay when ready (logged-in users only)',
                    'icon'        => 'pay_later',
                ],
            ],
        ],
    ]);
});


// ── 2. Validate Coupon ────────────────────────────────────────────────────────
// POST /api/coupon/validate
// Body: { course_id, coupon_code }

Route::post('coupon/validate', function (Request $request) {
    $code      = strtoupper($request->coupon_code ?? '');
    $courseId  = $request->course_id;
    $courseFee = 2000.00;
    $gst       = 360.00;
    $total     = $courseFee + $gst; // 2360

    // Dummy coupon table
    $coupons = [
        'SAVE20'  => ['id' => 1, 'type' => 'percent', 'value' => 20, 'max' => 400,  'desc' => '20% off (max ₹400)'],
        'FIRST50' => ['id' => 2, 'type' => 'flat',    'value' => 200, 'max' => null, 'desc' => 'Flat ₹200 off'],
        'REFER10' => ['id' => 3, 'type' => 'flat',    'value' => 100, 'max' => null, 'desc' => 'Referral ₹100 off'],
    ];

    if (!array_key_exists($code, $coupons)) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid coupon code. Please check and try again.',
        ]);
    }

    $c        = $coupons[$code];
    $discount = $c['type'] === 'percent'
        ? min(round($courseFee * $c['value'] / 100, 2), $c['max'] ?? PHP_INT_MAX)
        : (float) $c['value'];

    $finalAmount = max(0, round($total - $discount, 2));

    return response()->json([
        'status'  => true,
        'message' => "Coupon '{$code}' applied successfully!",
        'data'    => [
            'coupon_id'       => $c['id'],
            'code'            => $code,
            'description'     => $c['desc'],
            'type'            => $c['type'],
            'value'           => $c['value'],
            'discount_amount' => $discount,
            'original_amount' => $total,
            'final_amount'    => $finalAmount,
        ],
    ]);
});


// ── 3. Create Order ───────────────────────────────────────────────────────────
// POST /api/order/create
// Body: { course_id, coupon_id, payment_method, payment_plan,
//         course_fee, gst_amount, discount_amount, total_amount, pay_now_amount }

Route::post('order/create', function (Request $request) {
    $method      = $request->payment_method;
    $plan        = $request->payment_plan;
    $amount      = (float) $request->pay_now_amount;
    $total       = (float) $request->total_amount;
    $orderNumber = 'ORD-' . strtoupper(substr(uniqid(), -8));
    $orderId     = rand(1000, 9999);

    // Build payment gateway data based on method
    $paymentData = match ($method) {

        // ── UPI ──────────────────────────────────────────────────────────────
        'upi' => [
            'method'   => 'upi',
            'upi_id'   => 'bookmyteacher@upi',
            'upi_link' => "upi://pay?pa=bookmyteacher@upi"
                        . "&pn=BookMyTeacher"
                        . "&am={$amount}"
                        . "&cu=INR"
                        . "&tn=Order%20{$orderNumber}",
            'amount'   => $amount,
        ],

        // ── PhonePe ───────────────────────────────────────────────────────────
        'phonepe' => [
            'method'         => 'phonepe',
            'transaction_id' => 'TXN' . strtoupper(uniqid()),
            // In real implementation: base64 encoded payload + checksum from PhonePe SDK
            'payload'        => base64_encode(json_encode([
                'merchantId'            => 'MERCHANTID',
                'merchantTransactionId' => 'TXN' . strtoupper(uniqid()),
                'amount'                => (int) ($amount * 100),
                'redirectUrl'           => 'https://your-app.com/payment/callback',
                'callbackUrl'           => 'https://your-app.com/api/payment/phonepe/webhook',
                'paymentInstrument'     => ['type' => 'PAY_PAGE'],
            ])),
            'checksum'       => 'dummy_checksum_replace_with_real###1',
            'amount'         => $amount,
        ],

        // ── Razorpay ──────────────────────────────────────────────────────────
        'razorpay' => [
            'method'            => 'razorpay',
            'razorpay_order_id' => 'order_' . uniqid(),   // real: from Razorpay API
            'razorpay_key'      => 'rzp_test_xxxxxxxxxxxxxxx',
            'amount'            => $amount,
            'currency'          => 'INR',
            'name'              => 'BookMyTeacher',
            'prefill'           => [
                'name'    => 'John Doe',    // real: from auth user
                'email'   => 'john@example.com',
                'contact' => '9876543210',
            ],
        ],

        // ── Pay Later ─────────────────────────────────────────────────────────
        'pay_later' => [
            'method'   => 'pay_later',
            'message'  => 'You are registered! Complete payment within 7 days to activate your course.',
            'amount'   => $amount,
            'due_date' => now()->addDays(7)->toDateString(),
        ],

        // ── Default fallback ──────────────────────────────────────────────────
        default => [
            'method' => $method,
            'amount' => $amount,
        ],
    };

    return response()->json([
        'status'  => true,
        'message' => 'Order created successfully',
        'data'    => [
            'order_id'     => $orderId,
            'order_number' => $orderNumber,
            'payment_plan' => $plan,
            'pay_now'      => $amount,
            'total'        => $total,
            'payment'      => $paymentData,
        ],
    ]);
});


// ─────────────────────────────────────────────────────────────────────────────
// SAMPLE JSON RESPONSES (copy-paste for Postman / Flutter testing)
// ─────────────────────────────────────────────────────────────────────────────

/*
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
GET /api/course/1/purchase-info
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": true,
  "message": "Purchase info fetched successfully",
  "data": {
    "course": {
      "id": 1,
      "title": "Advanced Mathematics & Problem Solving",
      "thumbnail_url": "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800",
      "type_class": "live",
      "level": "beginner",
      "duration": "6 months",
      "mode": "online",
      "student_count": 42
    },
    "pricing": {
      "course_fee": 2000.00,
      "gst_rate": 18,
      "gst_amount": 360.00,
      "original_price": 2360.00,
      "total_amount": 2360.00,
      "currency": "INR"
    },
    "coupon_allowed": true,
    "instalment_allowed": true,
    "coupons": [
      {
        "id": 1,
        "code": "SAVE20",
        "description": "20% off on this course (max ₹400)",
        "type": "percent",
        "value": 20,
        "max_discount": 400.00,
        "discount_amount": 400.00,
        "expires_at": "2025-12-31"
      },
      {
        "id": 2,
        "code": "FIRST50",
        "description": "First purchase flat discount",
        "type": "flat",
        "value": 200,
        "max_discount": null,
        "discount_amount": 200.00,
        "expires_at": "2025-09-30"
      },
      {
        "id": 3,
        "code": "REFER10",
        "description": "Referral bonus reward",
        "type": "flat",
        "value": 100,
        "max_discount": null,
        "discount_amount": 100.00,
        "expires_at": null
      }
    ],
    "instalments": [
      {
        "instalment_number": 1,
        "label": "Instalment 1 of 2",
        "due_date": "2025-04-25",
        "due_date_label": "Today",
        "amount": 1180.00,
        "percentage": 50,
        "status": "pay_now"
      },
      {
        "instalment_number": 2,
        "label": "Instalment 2 of 2",
        "due_date": "2025-05-25",
        "due_date_label": "25 May 2025",
        "amount": 1180.00,
        "percentage": 50,
        "status": "pay_later"
      }
    ],
    "payment_methods": [
      {
        "key": "upi",
        "label": "Direct UPI",
        "description": "Pay via UPI ID — instant redirect",
        "upi_id": "bookmyteacher@upi",
        "icon": "upi"
      },
      {
        "key": "phonepe",
        "label": "PhonePe",
        "description": "PhonePe payment gateway",
        "icon": "phonepe"
      },
      {
        "key": "razorpay",
        "label": "Razorpay",
        "description": "Cards, NetBanking, Wallets & more",
        "key_id": "rzp_test_xxxxxxxxxxxxxxx",
        "icon": "razorpay"
      },
      {
        "key": "pay_later",
        "label": "Pay Later",
        "description": "Register now, pay when ready (logged-in users only)",
        "icon": "pay_later"
      }
    ]
  }
}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
POST /api/coupon/validate
Body: { "course_id": 1, "coupon_code": "SAVE20" }
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": true,
  "message": "Coupon 'SAVE20' applied successfully!",
  "data": {
    "coupon_id": 1,
    "code": "SAVE20",
    "description": "20% off (max ₹400)",
    "type": "percent",
    "value": 20,
    "discount_amount": 400.00,
    "original_amount": 2360.00,
    "final_amount": 1960.00
  }
}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
POST /api/coupon/validate  (invalid code)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": false,
  "message": "Invalid coupon code. Please check and try again."
}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
POST /api/order/create  (UPI + full payment)
Body:
{
  "course_id": 1,
  "coupon_id": 1,
  "payment_method": "upi",
  "payment_plan": "full",
  "course_fee": 2000,
  "gst_amount": 360,
  "discount_amount": 400,
  "total_amount": 1960,
  "pay_now_amount": 1960
}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": true,
  "message": "Order created successfully",
  "data": {
    "order_id": 4821,
    "order_number": "ORD-A3F9C12B",
    "payment_plan": "full",
    "pay_now": 1960.00,
    "total": 1960.00,
    "payment": {
      "method": "upi",
      "upi_id": "bookmyteacher@upi",
      "upi_link": "upi://pay?pa=bookmyteacher@upi&pn=BookMyTeacher&am=1960&cu=INR&tn=Order%20ORD-A3F9C12B",
      "amount": 1960.00
    }
  }
}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
POST /api/order/create  (Razorpay + instalment)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": true,
  "message": "Order created successfully",
  "data": {
    "order_id": 4822,
    "order_number": "ORD-B7D2E45F",
    "payment_plan": "instalment",
    "pay_now": 980.00,
    "total": 1960.00,
    "payment": {
      "method": "razorpay",
      "razorpay_order_id": "order_5f3g7h9k2m",
      "razorpay_key": "rzp_test_xxxxxxxxxxxxxxx",
      "amount": 980.00,
      "currency": "INR",
      "name": "BookMyTeacher",
      "prefill": {
        "name": "John Doe",
        "email": "john@example.com",
        "contact": "9876543210"
      }
    }
  }
}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
POST /api/order/create  (Pay Later)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": true,
  "message": "Order created successfully",
  "data": {
    "order_id": 4823,
    "order_number": "ORD-C9F1D67A",
    "payment_plan": "full",
    "pay_now": 1960.00,
    "total": 1960.00,
    "payment": {
      "method": "pay_later",
      "message": "You are registered! Complete payment within 7 days to activate your course.",
      "amount": 1960.00,
      "due_date": "2025-05-02"
    }
  }
}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
COUPON NOT ALLOWED response (coupon_allowed: false)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "status": true,
  "message": "Purchase info fetched successfully",
  "data": {
    "course": { ... },
    "pricing": { ... },
    "coupon_allowed": false,
    "instalment_allowed": false,
    "coupons": [],
    "instalments": [],
    "payment_methods": [ ... ]
  }
}
*/
