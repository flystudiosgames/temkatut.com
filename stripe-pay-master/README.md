# stripe-pay

## Info
Simple payment gateway

## Installation
```
cd app && composer update
```

Go into app/config/config.php and change:
```php
// Stripe config
$config['STRIPE_PUBLISH_KEY'] = 'YOUR PUB KEY HERE';
$config['STRIPE_SECRET_KEY'] = 'YOUR SECRET KEY HERE';
```

import ```stripe.sql``` into your database

Defaults:
Login - ```demo```
Password - ```demo```

## Features
* Login system.
* Easy configuration.
* AJAX requests for payments.

![stripe-pay](https://i.imgur.com/1x868u2.gif)

## Prerequisites
* php
* composer
* web server

## Third Party Software
* [Bootstrap](https://getbootstrap.com/ "Bootstrap") 
* [stripe-php](https://github.com/stripe/stripe-php "stripe-php") 
