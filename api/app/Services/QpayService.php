<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class QpayService
{
    public function handle($user, $reference, $amount)
    {
        $countryCode = "01";
        $payload = [
            "em" => $user->email,
            "fn" => $user->first_name,
            "ln" => $user->last_name,
            "am" => $amount,
            "pn" => $user->phone,
            "scode" => config("qpay.scode") . $countryCode . $reference,
        ];
        logger($payload);
        return $this->generatePaymentToken($payload);
    }

    public function generatePaymentToken($payload)
    {
        try {
            $response = Http::withoutVerifying()->get(config('qpay.url') . "/edrum/" . json_encode($payload));

            if (!$response->ok()) {
                $response->throw();
            }

            $response = $response->json();
            logger($response);
            $response = $response['EncryptedValue'][0];

            if (!isset($response['ResponseCode']) || !isset($response['ResponseEncrypted'])) {
                return [
                    "statusCode" => "001",
                ];
            }

            if ($response['ResponseCode'] != "00") {
                return [
                    "statusCode" => "01",
                ];
            }

            return [
                "statusCode" => "00",
                "data" => [
                    "url" => config('qpay.url') . "/odrum/" . $response['ResponseEncrypted'],
                ],
            ];

        } catch (Throwable $th) {
            logger($th);
            return [
                "statusCode" => "01",
            ];
        }
    }
}
