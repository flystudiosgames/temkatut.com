<?php

namespace Danonek\Tools;

use Danonek\Tools\Configurator as Config;

class DatabaseConnector
{
	private $db_connection = null;
	private static $instance = null;

	private function __construct() 
	{
		$this->db_connection = new \mysqli(Config::config_item('MYSQL_HOST'), Config::config_item('MYSQL_LOGIN'), Config::config_item('MYSQL_PASSWORD'), Config::config_item('MYSQL_DATABASE_NAME'));

		if ($this->db_connection->connect_error) 
		{
			mysqli_close($this->db_connection);
			header('HTTP/1.1 503 Service Unavailable.', true, 503);
			die('Database connection problem.');
		}
	}

	public static function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function getDatabaseConnection()
	{
		return self::getInstance()->db_connection;
	}

	public static function accountLogin($login, $password)
	{
		$db_con = self::getDatabaseConnection();

		if (!$db_con->connect_error)
		{
			$login = $db_con->real_escape_string($login);
			$password = $db_con->real_escape_string($password);
			$query = $db_con->prepare("SELECT * FROM account WHERE login = ?;");
			$query->bind_param('s', $login);
			$query->execute();

			$result_of_login_check = $query->get_result();
			
			if ($result_of_login_check->num_rows == 1)
			{
				$result_row = $result_of_login_check->fetch_object();

				if (password_verify($password, $result_row->password))
				{
					$_SESSION['user_id'] = $result_row->id;
					$_SESSION['user_login'] = $result_row->login;
					$_SESSION['logged_in'] = true;

					header("Location: /");
					die();
				}
				return "Password incorrect.";
			}
			else
			{
				return "No such login found.";
			}
		}
		else
		{
			header('HTTP/1.1 503 Service Unavailable.', true, 503);
			die('Database connection problem.');
		}
		
		mysqli_close($db_con);
	}
}
?>