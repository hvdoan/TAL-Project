<?php

namespace App\Core;

class PDO
{
	private static	$instance	= null;
	private			$pdo		= null;

	public function __construct()
	{
		//Se connecter à la bdd
		//il faudra mettre en place le singleton
		try{
			$this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
				,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
		}catch (\Exception $e){
			die("Erreur SQL : ".$e->getMessage());
		}
	}

	public static function getIntance()
	{
		if(is_null(self::$instance))
		{
			self::$instance = new PDO();
		}

		return self::$instance;
	}

	public function getPDO()
	{
		return $this->pdo;
	}
}