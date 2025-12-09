<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhonePeController extends Controller
{
  private $saltKey;
  private $saltIndex;
  private $payUrl;
  private $merchantId;

  public function __construct()
  {
    $this->saltKey = env("Salt_Key");
    $this->saltIndex = env("Salt_Index");
    $this->payUrl = env("Redirect_URL");
    $this->merchantId = env("Merchant_ID");
  }


  public function initPayment()
  {
    $amount = 20 * 100; // in paise

    $payload = [
      "merchantId" => $this->merchantId,
      "merchantTransactionId" => "TXN" . time(),
      "merchantUserId" => "USER123",
      "amount" => $amount,
      "redirectUrl" => url('/phonepe/callback'),
      "callbackUrl" => url('/phonepe/callback'),
      "mobileNumber" => "9999999999",
      "paymentInstrument" => [
        "type" => "PAY_PAGE",
      ],
    ];

    $payloadJSON = json_encode($payload);
    $encodedPayload = base64_encode($payloadJSON);

    // Generate SHA256 checksum
    $stringToHash = $encodedPayload . "/pg/v1/pay" . $this->saltKey;
    $sha256 = hash("sha256", $stringToHash);
    $finalXHeader = $sha256 . "###" . $this->saltIndex;

    $response = $this->curlRequest($this->payUrl, $encodedPayload, $finalXHeader);

    if ($response['success'] && isset($response['data']['instrumentResponse']['redirectInfo']['url'])) {
      return redirect()->away($response['data']['instrumentResponse']['redirectInfo']['url']);
    }

    return "Payment initialization failed!";
  }

  public function callback(Request $req)
  {
    $input = $req->all();

    // PhonePe sends transactionId inside request body
    $transactionId = $input['transactionId'] ?? null;

    if (!$transactionId) {
      return "Invalid callback!";
    }

    // VERIFY PAYMENT STATUS
    $statusUrl = "https://api-preprod.phonepe.com/apis/hermes/pg/v1/status/{$this->merchantId}/{$transactionId}";

    $stringToHash = "/pg/v1/status/{$this->merchantId}/{$transactionId}" . $this->saltKey;
    $sha256 = hash("sha256", $stringToHash);
    $xVerify = $sha256 . "###" . $this->saltIndex;

    $result = $this->curlGet($statusUrl, $xVerify);

    if ($result['code'] == "PAYMENT_SUCCESS") {
      return "Payment Successful! Transaction ID: " . $transactionId;
    } else {
      return "Payment Failed or Pending";
    }
  }

  private function curlRequest($url, $payload, $xVerify)
  {
    $postData = json_encode(["request" => $payload]);

    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $url,
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-VERIFY: $xVerify",
        "X-MERCHANT-ID: $this->merchantId",
      ],
      CURLOPT_POSTFIELDS => $postData,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
  }

  private function curlGet($url, $xVerify)
  {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => [
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
