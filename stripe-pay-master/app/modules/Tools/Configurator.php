<?php

namespace Danonek\Tools;

class Configurator
{
	private static function get_config(Array $replace = array())
	{
		static $config;

		if (empty($config))
		{
			$file_path =  __DIR__ . '/../../config/config.php';
			$found = false;
			if (file_exists($file_path))
			{
				$found = true;
				require($file_path);
			}

			if (!$found)
			{
				die('Configuration file does not exist.');
			}

			if (!isset($config) || !is_array($config))
			{
				die('Format failed.');
			}
		}
		foreach ($replace as $key => $val)
		{
			$config[$key] = $val;
		}

		return $config;
	}

	public static function config_item($item)
	{
		static $_config;

		if (empty($_config))
		{
			$_config[0] = self::get_config();
		}

		return isset($_config[0][$item]) ? $_config[0][$item] : null;
	}
}
?>