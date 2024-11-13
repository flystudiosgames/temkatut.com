<?php

use Danonek\Tools\Configurator as Config;
use Danonek\Stripe\StripeHelper as StripeHelper;

?>
<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Danonek">
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/pricing.css" rel="stylesheet">
	<title><?= Config::config_item('SITE_TITLE'); ?> - Shop</title>
</head>

<body>
	<?php include_once("@header.php"); ?>

	<div class="container">

	<?php
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
		{
	?>
	<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-3">Stripe Pay</h1>
		<br>
		<p class="lead">This is a demo of the store.</p>
		<p class="lead">All legitimate transactions won't validate through this site.</p>
	</div>

		<div class="card-deck mb-3 text-center">

			<div class="card mb-4 shadow-sm">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal"><?= Config::config_item('PACKAGE_NAME_1'); ?></h4>
				</div>

				<div class="card-body">
					<h1 class="card-title pricing-card-title"><?= StripeHelper::convertToHumanReadablePrice(Config::config_item('PACKAGE_PRICE_1')) . " " . Config::config_item('STRIPE_CURRENCY_SYMBOL'); ?></h1>
					<a class="btn btn-lg btn-block btn-primary" href="/payment?product=1">Buy</a>
				</div>
			</div>

			<div class="card mb-4 shadow-sm">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal"><?= Config::config_item('PACKAGE_NAME_2'); ?></h4>
				</div>

			<div class="card-body">
				<h1 class="card-title pricing-card-title"><?= StripeHelper::convertToHumanReadablePrice(Config::config_item('PACKAGE_PRICE_2')) . " " . Config::config_item('STRIPE_CURRENCY_SYMBOL'); ?></h1>
				<a class="btn btn-lg btn-block btn-primary" href="/payment?product=2">Buy</a>
			</div>

		</div>

		<div class="card mb-4 shadow-sm">
			<div class="card-header">
				<h4 class="my-0 font-weight-normal"><?= Config::config_item('PACKAGE_NAME_3'); ?></h4>
			</div>

			<div class="card-body">
				<h1 class="card-title pricing-card-title"><?= StripeHelper::convertToHumanReadablePrice(Config::config_item('PACKAGE_PRICE_3')) . " " . Config::config_item('STRIPE_CURRENCY_SYMBOL'); ?></h1>
				<a class="btn btn-lg btn-block btn-primary" href="/payment?product=3">Buy</a>
			</div>
		</div>

	</div>
	<?php
		}
		else
		{
	?>
		<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
			<h1 class="display-3">Stripe Pay</h1>
			<br>
			<p class="lead">This is a demo of the store.</p>
			<p class="lead">All transactions through this website won't actually validate.</p>
			<br>
			<p class="lead">To test the store you need to be <a href="/login">logged in</a>.</p>
		</div>
	<?php
		}
	?>

	<?php include_once('@footer.php'); ?>

	</div>
</body>
</html>