<?php

use Danonek\Tools\Configurator as Config;
use Danonek\Stripe\StripeHelper as StripeHelper;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inputLogin'], $_POST['inputPassword']))
{
	$error = Danonek\Tools\DatabaseConnector::accountLogin($_POST['inputLogin'], $_POST['inputPassword']);
}

?>
<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Danonek"">
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/fa-all.min.css" rel="stylesheet">
	<link href="/assets/css/floating-labels.css" rel="stylesheet">
	<title><?= Config::config_item('SITE_TITLE'); ?> - Login</title>
</head>

<body>
	<a class="top-link" href="/"><i class="fas fa-arrow-left"></i></a>
	<form class="form-signin" method="POST" action="/login">
		<div class="text-center mb-4">
			<h1 class="h2 mb-3 font-weight-normal">Client Area</h1>
		</div>

		<div class="form-label-group">
			<input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Login" required autofocus>
			<label for="inputLogin">Login</label>
		</div>

		<div class="form-label-group">
			<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
			<label for="inputPassword">Password</label>
		</div>

		<?php
		if (isset($error))
		{
			echo '<p style="color: red;font-weight: bold;text-align: center;">' . $error . '</p>';
		}
		?>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		<p class="mt-5 mb-3 text-muted text-center">&copy; <?= "danonek.dev " . date('Y'); ?></p>
	</form>
</body>
</html>
