<?php

namespace Danonek\Stripe;

use Danonek\Stripe\BodyException;
use Danonek\Tools\Configurator as Config;
use Danonek\Stripe\StripeHelper;
use Stripe\Stripe;
use Exception;

class StripePayIntent
{
	public static function stripePayment($cart, $product)
	{
		header('Content-Type: application/json');
		
		try 
		{
			Stripe::setApiKey(Config::config_item('STRIPE_SECRET_KEY'));

			$amount = StripeHelper::calculateAmountFromCart($cart);

			$body = StripeHelper::buildBodyFromRequest();
			$intent = StripeHelper::createPaymentIntent($body, $amount);

			if (StripeHelper::isPaymentIntentCompleted($intent)) 
			{
				StripeHelper::logPayment($intent);

				// TODO
				// Update something in the datatase relevant to the $product that the customer bought.
			}
			
			echo json_encode(StripeHelper::generateResponse($intent));
			die();
		}

		catch (BodyException $e) 
		{
			http_response_code(400);

			echo json_encode(
				[
					'error' => $e->getMessage(),
				]
			);

			die;
		}
		catch (Exception $e) 
		{
			echo json_encode(
				[
					'error' => $e->getMessage(),
				]
			);
		}
	}
}
