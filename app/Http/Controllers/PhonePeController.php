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
        // Move env() inside constructor (important)
        $this->merchantId = env("Merchant_ID");
        $this->saltKey    = env("Salt_Key");
        $this->saltIndex  = env("Salt_Index", 1);
        $this->payUrl     = env("Redirect_URL");
    }

    /**
     * Start Payment - Redirect to PhonePe
     */
    public function initPayment()
    {
        // *** You can make dynmic amount ***
        $amount = 20 * 100; // Rs.20 in paisa

        $payload = [
            "merchantId"            => $this->merchantId,
            "merchantTransactionId" => "TXN" . time(),
            "merchantUserId"        => "USER123",
            "amount"                => $amount,
            "redirectUrl"           => url('/phonepe/callback'),
            "callbackUrl"           => url('/phonepe/callback'),
            "mobileNumber"          => "9999999999",
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

        if ($response['success'] &&
            isset($response['data']['instrumentResponse']['redirectInfo']['url'])) {

            // redirect to PhonePe payment page
            return redirect()->away(
                $response['data']['instrumentResponse']['redirectInfo']['url']
            );
        }

        return dd($response); // show exact failure
    }

    /**
     * PhonePe Callback URL
     */
    public function callback(Request $request)
    {
        $transactionId = $request->input("transactionId");

        if (!$transactionId) {
            return "Invalid Callback - Transaction ID Missing!";
        }

        $statusUrl = "https://api-preprod.phonepe.com/apis/hermes/pg/v1/status/"
                     . $this->merchantId . "/" . $transactionId;

        // hashing rule => path + saltKey
        $stringToHash = "/pg/v1/status/" . $this->merchantId . "/" . $transactionId . $this->saltKey;
        $sha256 = hash("sha256", $stringToHash);
        $xVerify = $sha256 . "###" . $this->saltIndex;

        $result = $this->curlGet($statusUrl, $xVerify);

        if (isset($result['code']) && $result['code'] === "PAYMENT_SUCCESS") {
            return "Payment Success! Transaction ID: " . $transactionId;
        }

        return "Payment Failed or Pending!";
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
