<?php

namespace Danonek\Providers;

use Danonek\Tools\Configurator as Config;

class Render
{
	private static $instace = null;

	public static function getInstance()
	{
		if (self::$instace == null)
		{
			self::$instace = new self();
		}
		return self::$instace;
	}

	public function renderPage($page)
	{
		switch ($page)
		{
			case Config::config_item('HOME_TEMPLATE'):
			{
				include_once(__DIR__ . TEMPLATES_FOLDER .  Config::config_item('HOME_TEMPLATE'));
				break;
			}

			case Config::config_item('PAYMENT_TEMPLATE'):
			{
				include_once(__DIR__ . TEMPLATES_FOLDER .  Config::config_item('PAYMENT_TEMPLATE'));
				break;
			}
			
			case Config::config_item('LOGIN_TEMPLATE'):
			{
				include_once(__DIR__ . TEMPLATES_FOLDER .  Config::config_item('LOGIN_TEMPLATE'));
				break;
			}
			
			default:
			{
				include_once(__DIR__ . TEMPLATES_FOLDER .  Config::config_item('ERROR_TEMPLATE'));
				break;
			}
		}
	}
}
?>