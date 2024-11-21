<?php
require 'vendor/autoload.php'; // Include Mollie API autoload

// Configurează Mollie API
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey("test_qfNTnuSK2FQjm4cjKS2HwJ5yzdWed7"); // Înlocuiește cu cheia ta de test de la Mollie

try {
    // Creează o plată de $10
    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "USD",
            "value" => "10.00" // Suma plății
        ],
        "description" => "Test Payment",
        "redirectUrl" => "thank-you.html", // Redirecționează utilizatorul după plată
        "webhookUrl" => "webhook.php",    // Webhook pentru notificări
    ]);

    // Redirecționează utilizatorul către pagina de plată Mollie
    header("Location: " . $payment->getCheckoutUrl(), true, 303);
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "Mollie API Error: " . htmlspecialchars($e->getMessage());
}
