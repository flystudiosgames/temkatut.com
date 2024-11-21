<?php

namespace Victor\Mollie;

use Mollie\Api\MollieApiClient;

class PaymentHandler
{
    private $mollie;

    public function __construct()
    {
        $this->mollie = new MollieApiClient();
        $this->mollie->setApiKey("your_api_key"); // Înlocuiește cu cheia ta API Mollie
    }

    public function createPayment($amount, $description, $redirectUrl, $webhookUrl)
    {
        return $this->mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => number_format($amount, 2, '.', '') // Asigură formatul corect
            ],
            "description" => $description,
            "redirectUrl" => $redirectUrl,
            "webhookUrl" => $webhookUrl,
        ]);
    }
}
