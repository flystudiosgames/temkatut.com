<?php

namespace Danonek\Controllers;

use Danonek\Providers\Render as Render;
use Danonek\Tools\Configurator as Config;
use Danonek\Tools\Tools as Tools;
use Danonek\Providers\StripeAPI as StripeAPI;

class Controller
{
	public static function showPage($page)
	{
		Render::getInstance()->renderPage($page);
	}

	public static function doLogout()
	{
		if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true))
		{
			$_SESSION = array();
			session_destroy();
			
			header('Location: /');
			die();
		}
		else
		{
			header('Location: /error');
			die();
		}
	}
}
?>