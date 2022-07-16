<?php

namespace App\Controller;

use App\Core\Notification;
use App\Core\PDO;
use App\Core\View;
use App\Model\Page;

class Config
{
    public function config()
    {
        if(isset($_POST["requestType"]) ? $_POST["requestType"] == "initialization" : false)
        {
//            if((isset($_SESSION["BONSOIR_THEO"]) && isset($_POST["token"])) ? ($_SESSION["BONSOIR_THEO"] == $_POST["token"]) : false)
//            {
                if(isset($_POST["websiteName"]) &&
                    isset($_POST["dbHost"]) && isset($_POST["dbPort"]) && isset($_POST["dbUser"]) && isset($_POST["dbPassword"]) &&
                    isset($_POST["paypalClientKey"]) && isset($_POST["paypalCurrency"]) &&
                    isset($_POST["phpmailerClientId"]) && isset($_POST["phpmailerClientSecret"]) && isset($_POST["phpmailerEmail"]) && isset($_POST["phpmailerPassword"]) && isset($_POST["phpmailerPort"]))
                {
                    // Protection injection SQL
                    $websiteName                = addslashes($_POST["websiteName"]);

                    $dbHost                     = addslashes($_POST["dbHost"]);
                    $dbPort                     = addslashes($_POST["dbPort"]);
                    $dbUser                     = addslashes($_POST["dbUser"]);
                    $dbPassword                 = addslashes($_POST["dbPassword"]);

                    $paypalClientKey            = addslashes($_POST["paypalClientKey"]);
                    $paypalCurrency             = addslashes($_POST["paypalCurrency"]);

                    $phpmailerClientId          = addslashes($_POST["phpmailerClientId"]);
                    $phpmailerClientSecret      = addslashes($_POST["phpmailerClientSecret"]);
                    $phpmailerEmail             = addslashes($_POST["phpmailerEmail"]);
                    $phpmailerPassword          = addslashes($_POST["phpmailerPassword"]);
                    $phpmailerPort              = addslashes($_POST["phpmailerPort"]);

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
                            "clientId" => $phpmailerClientId,
                            "clientSecret" => $phpmailerClientSecret,
                            "refreshToken" => "",
                            "email" => $phpmailerEmail,
                            "password" => $phpmailerPassword,
                            "port" => $phpmailerPort
                        ]
                    ];

                    $pdo = null;

                    try
                    {
                        $pdo = new \PDO( $config["database"]["driver"].":host=".$config["database"]["host"].";port=".$config["database"]["port"].";charset=".$config["database"]["charset"],
                                         $config["database"]["user"], $config["database"]["password"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
                    }
                    catch (\Exception $e)
                    {
                        Notification::CreateNotification("error", "Impossible de se connecter à la Base de donnée.");
                    }

                    if($pdo)
                    {
                        $configFile = fopen("ini.yml", "w");
                        yaml_emit_file("ini.yml", $config);
                        fclose($configFile);

                        $mysqlStatements = require_once "mysqlInitStatements.php";

                        foreach($mysqlStatements as $statement)
							$pdo->exec($statement);

                        header("Location: login");
                    }
                }
            }

//            Notification::CreateNotification("error", "Une erreur est survenue.");
//        }

        $view = new View("config", "config");
//        $view->assign("token", $token);
    }

    public function sitemapGeneration()
    {
        $pageModel = new Page();
        $pages = $pageModel->select2("Page", ["uri", "dateModification"])
            ->getResult();

        $sitemap = fopen("sitemap.xml", "w+");

        fwrite($sitemap, "<?xml version=\"1.0\"  encoding=\"UTF-8\"?>\n");
        fwrite($sitemap, "<urlset xmlns=\"".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].".xml\">\n");
        foreach ($pages as $page)
        {
            $date = explode(" ", $page["dateModification"])[0];

            fwrite($sitemap, "\t<url>\n");
            fwrite($sitemap, "\t\t<loc>".$_SERVER["HTTP_HOST"].$page["uri"]."</loc>\n");
            fwrite($sitemap, "\t\t<lastmod>".$date."</lastmod>\n");
            fwrite($sitemap, "\t</url>\n");
        }
        fwrite($sitemap, "</urlset>\n");

        fclose($sitemap);

        $xml = file_get_contents("sitemap.xml");

        echo "<pre>";
        echo $xml;
        echo "</pre>";
    }
}