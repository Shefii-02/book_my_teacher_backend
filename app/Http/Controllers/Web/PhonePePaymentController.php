<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PhonePePaymentController extends Controller
{
    public function checkout()
    {
        return view('web.checkout');
    }

    private function getPlanAmount($plan)
    {
        // Amount in RUPEES
        return match ($plan) {
            '1year' => 5999,
            '2year' => 10999,
            default => 5999,
        };
    }

    public function pay(Request $request)
    {

        $request->validate([
            'plan'   => 'required|string',
            'name'   => 'required|string|max:120',
            'email'  => 'required|email',
            'mobile' => 'required|digits:10'
        ]);

        $amountRupees = $this->getPlanAmount($request->plan);
        $amountPaise  = $amountRupees * 100;

        $merchantTransactionId = "BMT_" . Str::upper(Str::random(18));
        $merchantUserId        = "USER_" . Str::upper(Str::random(12));

        // (Optional) store in DB before redirect
        // Payment::create([...])

        $payload = [
            "merchantId" => env('Merchant_ID'),
            "merchantTransactionId" => $merchantTransactionId,
            "merchantUserId" => $merchantUserId,
            "amount" => $amountPaise,
            "redirectUrl" => url('/phonepe/callback'),
            "redirectMode" => "POST",
            "callbackUrl" => url('/phonepe/callback'),
            "mobileNumber" => $request->mobile,
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ],
        ];

        $base64Payload = base64_encode(json_encode($payload));

        $saltKey   = env('Salt_Key');
        $saltIndex = env('Salt_Index');

        $apiPath = "/pg/v1/pay";
        $checksum = hash('sha256', $base64Payload . $apiPath . $saltKey) . "###" . $saltIndex;

        // try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "X-VERIFY" => $checksum,
            ])->post(env('Redirect_URL'), [
                "request" => $base64Payload
            ]);

            $data = $response->json();

            if (!$response->successful() || empty($data['success'])) {
                Log::error("PhonePe PAY error", ["res" => $data]);
                return back()->with('error', 'Payment initiation failed. Please try again.');
            }

            $redirectUrl = $data['data']['instrumentResponse']['redirectInfo']['url'] ?? null;

            if (!$redirectUrl) {
                return back()->with('error', 'Payment redirect URL missing. Try again.');
            }

            return redirect()->away($redirectUrl);

        // } catch (\Exception $e) {
        //     Log::error("PhonePe PAY exception", ["msg" => $e->getMessage()]);
        //     return back()->with('error', 'Server error. Please try again.');
        // }
    }

    public function callback(Request $request)
    {
        // PhonePe sends response after payment
        // You can validate checksum here too (optional)

        $merchantId = env('Merchant_ID');

        // Try to detect merchantTransactionId from callback
        $merchantTransactionId = $request->input('transactionId')
            ?? $request->input('merchantTransactionId')
            ?? $request->input('data.merchantTransactionId');

        // Sometimes PhonePe callback sends "response" (base64)
        if (!$merchantTransactionId && $request->input('response')) {
            $decoded = json_decode(base64_decode($request->input('response')), true);
            $merchantTransactionId = $decoded['data']['merchantTransactionId'] ?? null;
        }

        if (!$merchantTransactionId) {
            return redirect()->route('payment.failed')->with('error', 'Transaction not found.');
        }

        // Verify status via API
        $saltKey   = env('Salt_Key');
        $saltIndex = env('Salt_Index');

        $apiPath = "/pg/v1/status/{$merchantId}/{$merchantTransactionId}";
        $checksum = hash('sha256', $apiPath . $saltKey) . "###" . $saltIndex;

        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "X-VERIFY" => $checksum,
                "X-MERCHANT-ID" => $merchantId,
            ])->get(env('Redirect_URL'));

            $data = $response->json();

            if (!$response->successful() || empty($data['success'])) {
                Log::error("PhonePe STATUS error", ["res" => $data]);
                return redirect()->route('payment.failed')->with('error', 'Payment verification failed.');
            }

            $state = $data['data']['state'] ?? 'FAILED';

            // Update DB record if using payments table
            // Payment::where('merchant_transaction_id', $merchantTransactionId)->update([...]);

            if ($state === "COMPLETED") {
                return redirect()->route('payment.success')->with('tx', $merchantTransactionId);
            }

            return redirect()->route('payment.failed')->with('tx', $merchantTransactionId);

        } catch (\Exception $e) {
            Log::error("PhonePe STATUS exception", ["msg" => $e->getMessage()]);
            return redirect()->route('payment.failed')->with('error', 'Server error while verifying payment.');
        }
    }

    public function success()
    {
        return view('payments.success');
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
