<?php

use Danonek\Tools\Configurator as Config;

?>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
	<h5 class="my-0 mr-md-auto font-weight-normal"><a class="p-2 text-dark" style="text-decoration: none;" href="/"><?= Config::config_item('SITE_TITLE'); ?></a></h5>
	<?php
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
		{
	?>
		<nav class="my-2 my-md-0 mr-md-3">
			<p class="my-0 mr-md-auto font-weight-normal">Hello <?= $_SESSION['user_login']; ?>!</p>
		</nav>
		<a class="btn btn-outline-danger" href="/logout">Logout</a>
	<?php
		}
		else
		{
	?>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 text-dark" href="#">Register</a>
		</nav>
		<a class="btn btn-outline-primary" href="/login">Login</a>

	<?php
		}
	?>
</div>