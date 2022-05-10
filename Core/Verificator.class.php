<?php

namespace App\Core;

use App\Controller\User;


class Verificator
{
    public static function checkForm($config, $data): array
    {
        $result = [];
        //Le nb de inputs envoyés ?
        if( count($data) != count($config['inputs'])){
            die("Tentative de hack !!!!");
        }

        foreach ($config['inputs'] as $name=>$input){

            if(!isset($data[$name]) ){
                $result[] = "Le champs ".$name." n'existe pas";
            }

            if(empty($data[$name]) && !empty($input["required"]) ){
                $result[] = "Le champs ".$name." ne peut pas être vide";
            }

            if($input["type"] == "email" && !self::checkEmail($data[$name]) ){
                $result[] = $input["error"];
            }

            if($input["type"] == "password" && empty($input["confirm"]) && !self::checkPassword($data[$name]) ){
                $result[] = $input["error"];
            }

            if(!empty($input["confirm"]) && $data[$name] != $data[$input["confirm"]]){
                $result[] = $input["error"];
            }
        }

        return $result;
    }

    public static function checkEmail($email): bool
    {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function checkPassword($password): bool
    {

        return strlen($password)>=8
            && preg_match("/[0-9]/", $password, $match)
            && preg_match("/[a-z]/", $password, $match)
            && preg_match("/[A-Z]/", $password, $match)
            ;
    }

	public static function checkConnection(): bool
	{
		$isConnected = false;
//        echo "<pre>";
//        var_dump($_SESSION["token"]);
//        var_dump($_COOKIE["token"]);
//        echo "</pre>";
//        die();

		if(isset($_SESSION["token"]) && isset($_COOKIE["token"]) && isset($_SESSION["id"]))
        {
            if($_SESSION["token"] == $_COOKIE["token"] && $_SESSION["id"] != "")
                $isConnected = true;
        }

		return $isConnected;
	}
    
    public static function reloadConnection(): void
    {
        if(self::checkConnection())
        {
            unset($_SESSION["token"]);
            unset($_COOKIE["token"]);

            $token = md5(uniqid());

            $_SESSION["token"] = $token;
            setcookie("token", $token, time() + (60 * 15), "", "", true);
        }
    }
	
	public static function unsetSession(): void{
		if(!self::checkConnection()){
//			var_dump("bonsoir");
//			unset($_SESSION['token']);
//			unset($_SESSION['id']);
//			unset($_SESSION['permission']);
//			unset($_SESSION['role']);
		}
	}

	public static function checkPageAccess($userAutorisations, $permissionNeeded)
	{
		return in_array($permissionNeeded, $userAutorisations);
	}
}