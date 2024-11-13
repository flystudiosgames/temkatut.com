<?php
require_once __DIR__ . '/../app/config/constants.php';

use Danonek\Tools\Configurator as Config;
use Danonek\Controllers\Router as Route;
use Danonek\Controllers\Controller as Controller;
use Danonek\Providers\StripeAPI;

Route::add('/', function()
{
	Controller::showPage(Config::config_item('HOME_TEMPLATE'));
}, ['GET']);

Route::add('/login', function()
{
	Controller::showPage(Config::config_item('LOGIN_TEMPLATE'));
}, ['GET', 'POST']);

Route::add('/logout', function()
{
	Controller::doLogout();
}, ['GET']);

Route::add('/payment', function()
{	
	Controller::showPage(Config::config_item('PAYMENT_TEMPLATE'));
}, ['GET', 'POST']);

Route::add('/error', function()
{
	Controller::showPage(Config::config_item('ERROR_TEMPLATE'));
}, ['GET']);

Route::pathNotFound(function()
{
	http_response_code(404);
	Controller::showPage(Config::config_item('ERROR_TEMPLATE'));
});

Route::methodNotAllowed(function() 
{
	http_response_code(405);
	Controller::showPage(Config::config_item('ERROR_TEMPLATE'));
});

Route::run(BASEPATH);