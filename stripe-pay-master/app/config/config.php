<?php

// Misc
$config['SITE_TITLE'] = 'Danonek';

// Prices (Prices in cents)
$config['PACKAGE_NAME_1'] = 'Product 1';
$config['PACKAGE_PRICE_1'] = 1000;

$config['PACKAGE_NAME_2'] = 'Product 2';
$config['PACKAGE_PRICE_2'] = 2000;

$config['PACKAGE_NAME_3'] = 'Product 3';
$config['PACKAGE_PRICE_3'] = 3000;

// Stripe config
$config['STRIPE_PUBLISH_KEY'] = 'YOUR PUB KEY HERE';
$config['STRIPE_SECRET_KEY'] = 'YOUR SECRET KEY HERE';

// Currencyies
$config['STRIPE_CURRENCY'] = 'eur';
$config['STRIPE_CURRENCY_SYMBOL'] = '€';

// Database Config
$config['MYSQL_HOST'] = 'localhost';
$config['MYSQL_LOGIN'] = 'root';
$config['MYSQL_PASSWORD'] = 'localhost';
$config['MYSQL_DATABASE_NAME'] = 'stripe';

// TEMPLATE PAGES
$config['HOME_TEMPLATE'] = 'home.php';
$config['PAYMENT_TEMPLATE'] = 'payment.php';
$config['LOGIN_TEMPLATE'] = 'login.php';
$config['ERROR_TEMPLATE'] = 'error.php';
$config['RULES_TEMPLATE'] = 'rules.php';


?>