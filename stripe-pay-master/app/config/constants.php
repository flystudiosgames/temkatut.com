<?php

/*
	--------------------------------
	 Autoload modules from composer
	--------------------------------
*/
require_once '../app/vendor/autoload.php';

/*
	-----------------
	 Global Defines
	-----------------
*/

define ('TEMPLATES_FOLDER', '/../../templates/');
session_start();

/*
	------------------------------
	 Set enviroment (dev or live)
	------------------------------
*/
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'dev');

switch (ENVIRONMENT)
{
	case 'dev':
	{
		\Tracy\Debugger::enable();
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;
	}

	case 'live':
	{				
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) 
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} 
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;
	}

	default:
	{
		http_response_code(503);
		die('The application environment is not set correctly.');
	}
}

/*
	-------------------------
	 Base path (base folder)
	-------------------------
*/
define('BASEPATH', '/');

/*
	-------------------
	 Time Zone of PHP
	-------------------
*/
date_default_timezone_set("Europe/Dublin");

?>