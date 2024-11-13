<?php

use Danonek\Tools\Configurator as Config;
use Danonek\Stripe\StripeHelper as StripeHelper;

?>
<!doctype html>
<<html lang="pl"><head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Danonek">
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/pricing.css" rel="stylesheet">
	<title><?= Config::config_item('SITE_TITLE'); ?> - Error</title>
</head>

<body>

	<?php include_once("@header.php"); ?>

	<div class="container">
			
		<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
			<h1 class="display-3">Stripe Pay</h1>
			<br>
			<p class="lead">Something went wrong :/</p>
		</div>

			<div class="col text-center" style="margin-bottom: 50px; margin-top: 50px;">
				<a class="btn btn-primary btn-lg" href="/">Home</a>
			</div>

		<?php include_once("@footer.php"); ?>

	</div>

</body>
</html>