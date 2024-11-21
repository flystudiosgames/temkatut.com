<?php

require 'vendor/autoload.php'; // Include autoloader-ul Composer

use Mollie\Api\MollieApiClient;

// Configurează Mollie API
$mollie = new MollieApiClient();
$mollie->setApiKey("test_qfNTnuSK2FQjm4cjKS2HwJ5yzdWed7"); // Înlocuiește cu cheia ta API din Mollie Dashboard

// Creează o plată
try {
    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR", // Moneda
            "value" => "10.00"   // Suma (format corect)
        ],
        "description" => "Test Payment", // Descrierea plății
        "redirectUrl" => "http://localhost/WebGlGames/Mollie/success.php", // URL-ul de succes
        "webhookUrl" => "http://localhost/WebGlGames/Mollie/webhook.php", // URL-ul webhook-ului (opțional)
    ]);

    // Redirecționează utilizatorul către pagina de plată Mollie
    header("Location: " . $payment->getCheckoutUrl());
    exit;

} catch (\Exception $e) {
    // Gestionează erorile
    echo "Eroare: " . htmlspecialchars($e->getMessage());
}
