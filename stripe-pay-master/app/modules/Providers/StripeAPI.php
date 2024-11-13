<?php

namespace Danonek\Providers;

use Danonek\Tools\Configurator as Config;

class StripeAPI
{
	private $productId = null;
	private $amount = null;
	private $cart = [];

	private static $instance = null;

	private function __construct($productName) 
	{
		switch ($productName)
		{
			case Config::config_item('PACKAGE_NAME_1'):
			{
				$this->productId = Config::config_item('PACKAGE_NAME_1');
				$this->price = Config::config_item('PACKAGE_PRICE_1');
				$this->amount = 1;
				break;
			}

			case Config::config_item('PACKAGE_NAME_2'):
			{
				$this->productId = Config::config_item('PACKAGE_NAME_2');
				$this->price = Config::config_item('PACKAGE_PRICE_2');
				$this->amount = 1;
				break;
			}
			
			case Config::config_item('PACKAGE_NAME_3'):
			{
				$this->productId = Config::config_item('PACKAGE_NAME_3');
				$this->price = Config::config_item('PACKAGE_PRICE_3');
				$this->amount = 1;
				break;
			}

			default:
			{
				$this->productId = 'UNDEFINED';
				$this->price = 0;
				$this->amount = 0;
			}
		}

		$this->cart = 
		[
			'items' => 
			[
				[
					'id' => $this->productId,
					'amount' => $this->price,
					'quantity' => $this->amount,
				],
			],
		];
	}

	public static function getInstance($productName)
	{
		if (self::$instance == null)
		{
			self::$instance = new self($productName);
		}
		return self::$instance;
	}

	public function getCart()
	{
		return $this->cart;
	}

	public static function cartProduct($productId)
	{
		switch ($productId)
		{
			case 1:
			{
				$productId = Config::config_item('PACKAGE_NAME_1');
				$price = Config::config_item('PACKAGE_PRICE_1');
				$amount = 1;
				break;
			}

			case 2:
			{
				$productId = Config::config_item('PACKAGE_NAME_2');
				$price = Config::config_item('PACKAGE_PRICE_2');
				$amount = 1;
				break;
			}
			
			case 3:
			{
				$productId = Config::config_item('PACKAGE_NAME_3');
				$price = Config::config_item('PACKAGE_PRICE_3');
				$amount = 1;
				break;
			}	

			default:
			{
				$productId = 'UNDEFINED';
				$price = 0;
				$amount = 0;
			}
		}

		return 
		[
			'items' => 
			[
				[
					'id' => $productId,
					'amount' => $price,
					'quantity' => $amount,
				],
			],
		];
	}
}
?>