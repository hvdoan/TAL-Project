<?php

namespace App\Controller;

use App\Core\Notification;
use App\Core\PDO;
use App\Core\View;

class Config
{
    public function config()
    {
        if(isset($_POST["requestType"]) ? $_POST["requestType"] == "initialization" : false)
        {
            echo "<pre>";
            echo "Token formulaire précédant\n";
            var_dump("SESSION = " . $_SESSION["BONSOIR_THEO"]);
            var_dump("POST    = " . $_POST["token"]);
            var_dump("TEST    = " . $_SESSION["test"]);

//            if((isset($_SESSION["BONSOIR_THEO"]) && isset($_POST["token"])) ? ($_SESSION["BONSOIR_THEO"] == $_POST["token"]) : false)
//            {
                if(isset($_POST["websiteName"]) &&
                    isset($_POST["dbHost"]) && isset($_POST["dbPort"]) && isset($_POST["dbUser"]) && isset($_POST["dbPassword"]) &&
                    isset($_POST["paypalClientKey"]) && isset($_POST["paypalCurrency"]) &&
                    isset($_POST["phpmailerEmail"]) && isset($_POST["phpmailerPassword"]) && isset($_POST["phpmailerPort"]))
                {
                    // Protection injection SQL
                    $websiteName        = addslashes($_POST["websiteName"]);

                    $dbHost             = addslashes($_POST["dbHost"]);
                    $dbPort             = addslashes($_POST["dbPort"]);
                    $dbUser             = addslashes($_POST["dbUser"]);
                    $dbPassword         = addslashes($_POST["dbPassword"]);

                    $paypalClientKey    = addslashes($_POST["paypalClientKey"]);
                    $paypalCurrency     = addslashes($_POST["paypalCurrency"]);

                    $phpmailerEmail     = addslashes($_POST["phpmailerEmail"]);
                    $phpmailerPassword  = addslashes($_POST["phpmailerPassword"]);
                    $phpmailerPort      = addslashes($_POST["phpmailerPort"]);

                    // Formatage YAML
                    $config = [
                        "websiteName" => $websiteName,
                        "database" => [
                            "host" => $dbHost,
                            "port" => $dbPort,
                            "user" => $dbUser,
                            "password" => $dbPassword,
	                        "driver" => "mysql",
	                        "charset" => "utf8"
                        ],
                        "paypal" => [
                            "clientKey" => $paypalClientKey,
                            "currency" => $paypalCurrency
                        ],
                        "phpmailer" => [
                            "email" => $phpmailerEmail,
                            "password" => $phpmailerPassword,
                            "port" => $phpmailerPort
                        ]
                    ];

                    $result = true;
                    try
                    {
                        $pdo = new \PDO( $config["database"]["driver"].":host=".$config["database"]["host"].";port=".$config["database"]["port"].";charset=".$config["database"]["charset"],
                                         $config["database"]["user"], $config["database"]["password"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
                    }
                    catch (\Exception $e)
                    {
                        $result = false;
                        Notification::CreateNotification("error", "Impossible de se connecter à la Base de donnée.");
                    }

                    if($result)
                    {
                        $configFile = fopen("ini.yml", "w");
                        yaml_emit_file("ini.yml", $config);
                        fclose($configFile);

                        header("Location: login");
                    }
                }
            }

//            Notification::CreateNotification("error", "Une erreur est survenue.");
//        }

        $token                      = md5(uniqid());
        $_SESSION["BONSOIR_THEO"]   = $token;
        $_SESSION["test"]           = "test";

        echo "\nNouveau token\n";
        var_dump("token   = " . $token);
        var_dump("SESSION = " . $_SESSION["BONSOIR_THEO"]);
        var_dump("TEST    = " . $_SESSION["test"]);
        echo "</pre>";

        $view = new View("config", "config");
        $view->assign("token", $token);
    }
}