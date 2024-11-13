<?php

namespace Danonek\Stripe;

use Danonek\Stripe\BodyException;
use Danonek\Tools\Configurator as Config;

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Exception;

class StripeHelper
{
	public static function createPaymentIntent(object $body, int $amount): PaymentIntent
	{
		try 
		{
			if (!empty($body->paymentMethodId)) 
			{
				return PaymentIntent::create(
					[
						'amount' => $amount,
						'currency' => Config::config_item('STRIPE_CURRENCY'),
						'payment_method' => $body->paymentMethodId,
						'confirmation_method' => 'manual',
						'confirm' => true,
					]
				);
			}
			else if (!empty($body->paymentIntentId)) 
			{
				$intent = PaymentIntent::retrieve($body->paymentIntentId);
				$intent->confirm();

				return $intent;
			}
		}
		catch (ApiErrorException $e) 
		{
			throw new Exception("An error occurred when proccessing payment. Please retry later");
		}

		throw new Exception("An error occurred when proccessing payment. Please retry later");
	}

	public static function generateResponse(PaymentIntent $intent): array
	{
		switch ($intent->status) 
		{
			case PaymentIntent::STATUS_REQUIRES_ACTION:
			case 'requires_source_action':
				return 
				[
					'requiresAction' => true,
					'paymentIntentId' => $intent->id,
					'clientSecret' => $intent->client_secret,
				];

			case PaymentIntent::STATUS_REQUIRES_PAYMENT_METHOD:
			case 'requires_source':
				return [
					'error' => "Your card was denied, please provide a new payment method",
				];

			case PaymentIntent::STATUS_SUCCEEDED:
				return 
				[
					'clientSecret' => $intent->client_secret,
				];

			case PaymentIntent::STATUS_CANCELED:
				return 
				[
					'error' => "The payment has been canceled, please retry later"
				];

			default:
				return
				[
					'error' => "An error has occurred, please retry later",
				];
		}
	}

	public static function isPaymentIntentCompleted(PaymentIntent $intent): bool
	{
		return $intent->status === 'succeeded';
	}

	public static function buildBodyFromRequest(): object
	{
		$input = file_get_contents('php://input');
		$body = json_decode($input);

		if (json_last_error() !== JSON_ERROR_NONE) 
		{
			throw new BodyException('Invalid request.');
		}

		return $body;
	}

	public static function convertToHumanReadablePrice(int $amount): string
	{
		return number_format(($amount / 100), 2, ',', ' ');
	}

	public static function calculateAmountFromCart(array $cart): int
	{
		$total = 0;

		foreach ($cart['items'] as $item) {
			$total += $item['amount'] * $item['quantity'];
		}

		return $total;
	}

	public static function logPayment(PaymentIntent $intent): void
	{
		$file = __DIR__ . '../../../../payments.log';

		$methodId = $intent->id;
		$currency = $intent->currency;
		$createdAt = $intent->created;
		$paymentMethod = $intent->payment_method;
		$price = StripeHelper::convertToHumanReadablePrice($intent->amount);

		$log = "[{$createdAt}] Payment intent registered: {$methodId} | Price: {$price} ({$currency}) | Payment method: {$paymentMethod}\n";

		file_put_contents($file, $log, FILE_APPEND);
	}
}