<?php

use Danonek\Tools\Configurator as Config;
use Danonek\Providers\StripeAPI as StripeAPI;
use Danonek\Stripe\StripeHelper as StripeHelper;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$data = json_decode(file_get_contents('php://input'));
	Danonek\Stripe\StripePayIntent::stripePayment(StripeAPI::cartProduct($data->{'product'}), $data->{'product'});
}
else if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
{

	$product = null;

	if (isset($_GET['product']))
	{
		switch ($_GET['product'])
		{
			case 1:
			{
				$product = Config::config_item('PACKAGE_NAME_1');
				break;	
			}

			case 2:
			{
				$product = Config::config_item('PACKAGE_NAME_2');
				break;	
			}
			
			case 3:
			{
				$product = Config::config_item('PACKAGE_NAME_3');
				break;	
			}

			default:
			{
				header("Location: /error");
				die();
			}
		}
	}
	else
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			die();
		}

		header("Location: /error");
		die();
	}

	$cart = StripeAPI::getInstance($product)->getCart();
	$amount = StripeHelper::calculateAmountFromCart($cart); 
	$price = StripeHelper::convertToHumanReadablePrice($amount);
}
else
{
	header("Location: /error");
	die();
}

?>
<!doctype html>
<html lang="pl">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Danonek">
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/global.css"/>
	<script src="https://js.stripe.com/v3/"></script>
	<title> <?= Config::config_item('SITE_TITLE') ?> - Payment</title>
</head>

<body>
	<?php include_once("@header.php"); ?>

		<div class="container">
		<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
			<p class="lead text-center"><strong>CVC</strong> is any 3 digits and the <strong>expiry date</strong> is any future date.</p>
		</div>

		<table class="table table-bordered">
			<thead>
				<tr>
				<th scope="col">Card Number</th>
				<th scope="col">Type</th>
				<th scope="col">Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>4242424242424242</td>
					<td>VISA</td>
					<td>Basic test card with no authentication.</td>
				</tr>
				<tr>
					<td>5555555555554444</td>
					<td>Mastercard</td>
					<td>Basic test card with no authentication.</td>
				</tr>
				<tr>
					<td>4000002500003155</td>
					<td>VISA</td>
					<td>This card requires authentication for one-time payments.</td>
				</tr>
				<tr>
					<td>4000008260003178</td>
					<td>VISA</td>
					<td>All payments will be declined with this card as it has no sufficient funds.</td>
				</tr>
			</tbody>
		</table>

		<div class="sr-main" style="margin: 0 auto;">
			<form id="payment-form" data-stripe-public-key="<?= Config::config_item('STRIPE_PUBLISH_KEY') ?>">
				<div class="sr-combo-inputs-row">
					<div class="sr-input sr-card-element" id="card-element"></div>
					<div id="card-errors"></div>
				</div>

				<div class="sr-field-error" id="card-errors" role="alert"></div>

				<button id="submit" type="submit">
					<div class="spinner hidden" id="spinner"></div>

					<span id="button-text">
						Pay
						<span id="order-amount"><?= $price ?> <?= Config::config_item('STRIPE_CURRENCY_SYMBOL') ?></span>
					</span>
				</button>
			</form>

			<div class="sr-result hidden">
				<p>Success!<br>The payment went through :)<br/></p>
			</div>
		</div>

		<script src="/assets/js/script.js"></script>

		<?php include_once('@footer.php'); ?>

	</div>

</body>
</html>