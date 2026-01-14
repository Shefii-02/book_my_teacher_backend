<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PurchaseController extends Controller
{

  private $saltKey;
  private $saltIndex;
  private $payUrl;
  private $merchantId;

  public function __construct()
  {
    // Move env() inside constructor (important)
    $this->merchantId = env("Merchant_ID");
    $this->saltKey    = env("Salt_Key");
    $this->saltIndex  = env("Salt_Index", 1);
    $this->payUrl     = env("Redirect_URL");
  }


  public function initPayment($orderId)
  {

    $payment  = PurchasePayment::with('purchase')->where('order_id', $orderId)->first();

    $purchase = Purchase::where('id', $payment->purchase_id)->first();

    return view('company.academic.payments.online-init', compact('payment', 'purchase'));

    // if ($purchase->payment_method === 'cash') {
    //   $purchase->update(['status' => 'paid']);
    //   return back()->with('success', 'Cash payment marked as paid');
    // }
  }



  public function paymentProcess($orderId)
  {

    $payment  = PurchasePayment::with('purchase')->where('order_id', $orderId)->first();

    $purchase = Purchase::where('id', $payment->purchase_id)->first();

    $student  = $purchase->student;

    $transactionId = "TXN" . time() . $student->id;

    $payment->reference_id = $transactionId;
    $payment->save();


    // *** You can make dynmic amount ***
    // $amount = $purchase->grand_total * 100; // Rs.20 in paisa

    $amount = (int) bcmul($purchase->payments->amount, 100, 0);

    $payload = [
      "merchantId"            => $this->merchantId,
      "merchantTransactionId" => $transactionId,
      "merchantUserId"        => "USER" . $student->id,
      "amount"                => $amount,
      "redirectUrl"           => route('company.payments.callback', $orderId),
      "callbackUrl"           => route('company.payments.callback', $orderId),
      "mobileNumber"          => $student->mobile,
      "paymentInstrument"     => [
        "type" => "PAY_PAGE",
      ],
    ];

    $payloadJSON = json_encode($payload);
    $encodedPayload = base64_encode($payloadJSON);

    // hashing rule => base64(payload) . path . saltKey
    $stringToHash = $encodedPayload . "/pg/v1/pay" . $this->saltKey;
    $sha256 = hash("sha256", $stringToHash);
    $xVerify = $sha256 . "###" . $this->saltIndex;

    $response = $this->curlPost($this->payUrl, $encodedPayload, $xVerify);

    if (
      $response['success'] &&
      isset($response['data']['instrumentResponse']['redirectInfo']['url'])
    ) {

      // redirect to PhonePe payment page
      return redirect()->away(
        $response['data']['instrumentResponse']['redirectInfo']['url']
      );
    }

    return dd($response); // show exact failure
  }


  public function bankProcess($orderId){

    $payment = PurchasePayment::where('order_id', $orderId)->firstOrFail();

    /////////////////////

    DB::transaction(function () use ($payment) {
      $payment->update([
        'status'         => 'success',
        'transaction_id' => $merchantTxnId ?? null,
        'response'       => 'done',
      ]);

      $payment->purchase->update([
        'status' => 'paid'
      ]);

          // 2️⃣ INSTALLMENT LOGIC
        if ($payment->purchase->is_installment) {

            $installment = $payment->purchase->installments()
                ->where('is_paid', 0)
                ->orderBy('due_date')
                ->first();

            if ($installment) {
                $installment->update([
                    'paid_amount'   => $installment->amount,
                    'paid_date'     => now(),
                    'paid_by'       => 'manual',
                    'payment_method'=> 'bank',
                    'payment_source'=> 'web',
                    'is_paid'       => 1,
                ]);
            }

            // Check if all installments paid
            // $pendingCount = $payment->purchase->installments()
            //     ->where('is_paid', 0)
            //     ->count();

            // if ($pendingCount === 0) {
            //     $payment->purchase->update(['status' => 'paid']);
            // }
          }
    });

    if (method_exists($payment->purchase->student, 'courses')) {
      $payment->purchase->student->courses()->attach($payment->purchase->course_id);
    }

        return redirect()->route('company.payments.success', $orderId);


  }


  public function cashProcess($orderId){

  }



  public function paymentCallback(Request $request, $orderId)
  {

    $payment = PurchasePayment::where('order_id', $orderId)->firstOrFail();

    $merchantTxnId = $payment->reference_id;

    if (!$merchantTxnId) {
      return "Merchant Transaction ID missing!";
    }

    /////////////////////

    DB::transaction(function () use ($payment) {
      $payment->update([
        'status'         => 'success',
        'transaction_id' => $merchantTxnId ?? null,
        'response'       => 'done',
      ]);

      $payment->purchase->update([
        'status' => 'paid'
      ]);

          // 2️⃣ INSTALLMENT LOGIC
        if ($payment->purchase->is_installment) {

            $installment = $payment->purchase->installments()
                ->where('is_paid', 0)
                ->orderBy('due_date')
                ->first();

            if ($installment) {
                $installment->update([
                    'paid_amount'   => $installment->amount,
                    'paid_date'     => now(),
                    'paid_by'       => 'online',
                    'payment_method'=> 'online',
                    'payment_source'=> 'web',
                    'is_paid'       => 1,
                ]);
            }

            // Check if all installments paid
            // $pendingCount = $payment->purchase->installments()
            //     ->where('is_paid', 0)
            //     ->count();

            // if ($pendingCount === 0) {
            //     $payment->purchase->update(['status' => 'paid']);
            // }
          }
    });

    if (method_exists($payment->purchase->student, 'courses')) {
      $payment->purchase->student->courses()->attach($payment->purchase->course_id);
    }

    return redirect()->route('company.payments.success', $orderId);

    //////////////////

    $statusPath = "/pg/v1/status/{$this->merchantId}/{$merchantTxnId}";
    $statusUrl  = "https://api.phonepe.com/apis/hermes" . $statusPath;

    $xVerify = hash("sha256", $statusPath . $this->saltKey) . "###" . $this->saltIndex;

    $result = $this->curlGet($statusUrl, $xVerify);

    if (
      isset($result['code']) &&
      $result['code'] === "PAYMENT_SUCCESS"
    ) {

      DB::transaction(function () use ($payment, $result) {
        $payment->update([
          'status'         => 'success',
          'transaction_id' => $result['data']['transactionId'] ?? null,
          'response'       => json_encode($result),
        ]);

        $payment->purchase->update([
          'status' => 'paid'
        ]);
      });

      return redirect()->route('company.payments.success');
    }

    // FAILED / PENDING
    $payment->update([
      'status'   => 'failed',
      'response' => json_encode($result),
    ]);

    return redirect()->route('payment.failed.page');
  }




  public function reject(Request $request)
  {
    $payment = Purchase::where('id', $request->purchase_id)->firstOrFail();
    $payment->notes =  $request->notes;
    $payment->status = 'rejected';
    $payment->save();

    return redirect()->back()->with('success', "Transaction Rejected");
  }



  public function successPage($orderId)
  {
      $payment= PurchasePayment::where('order_id', $orderId)->firstOrFail();
    $purchase = $payment->purchase;

    return view('company.academic.payments.success', compact('purchase'));
  }



  public function verify($orderId)
  {
    $payment= PurchasePayment::where('order_id', $orderId)->firstOrFail();
    $purchase = $payment->purchase;

    if ($purchase->status !== 'paid') {
      return view('company.academic.payments.invalid');
    }

    return view('company.academic.payments.verified', compact('purchase'));
  }



  /**
   * POST Request
   */
  private function curlPost($url, $payload, $xVerify)
  {
    $postData = json_encode(["request" => $payload]);

    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL            => $url,
      CURLOPT_POST           => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER     => [
        "Content-Type: application/json",
        "X-VERIFY: $xVerify",
        "X-MERCHANT-ID: $this->merchantId",
      ],
      CURLOPT_POSTFIELDS     => $postData,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
  }

  /**
   * GET Request
   */
  private function curlGet($url, $xVerify)
  {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL            => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER     => [
        "Content-Type: application/json",
        "accept: application/json",
        "X-VERIFY: $xVerify",
        "X-MERCHANT-ID: $this->merchantId",
      ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
  }
}
