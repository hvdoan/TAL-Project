<?php

if(file_exists("ini.yml"))
{
    $credentials = yaml_parse_file("ini.yml");

    if (!empty($credentials["websiteName"]))
        define("WEBSITENAME", $credentials["websiteName"]);

    if (!empty($credentials["database"]["host"]) && !empty($credentials["database"]["port"]) &&
        !empty($credentials["database"]["user"]) && !empty($credentials["database"]["password"]))
    {
        define("DBHOST", $credentials["database"]["host"]);
        define("DBPORT", $credentials["database"]["port"]);
        define("DBUSER", $credentials["database"]["user"]);
        define("DBPWD", $credentials["database"]["password"]);
        define("DBNAME", "TAL_Project_BDD");
        define("DBDRIVER", "mysql");
        define("DBPREFIXE", "TALBDD_");
        define("DBCHARSET", "utf8");
    }
	
    if (!empty($credentials["paypal"]["clientKey"]) && !empty($credentials["paypal"]["currency"]))
    {
        define("PAYPALKEYCLIENT", $credentials["paypal"]["clientKey"]);
        define("PAYPALCURRENCY", $credentials["paypal"]["currency"]);
    }

    if (!empty($credentials["phpmailer"]["clientId"]) && !empty($credentials["phpmailer"]["clientSecret"]) &&
        isset($credentials["phpmailer"]["refreshToken"]) && !empty($credentials["phpmailer"]["email"]) &&
        !empty($credentials["phpmailer"]["password"]) && !empty($credentials["phpmailer"]["port"]))
    {
        define("PHPMAILERCLIENTID", $credentials["phpmailer"]["clientId"]);
        define("PHPMAILERCLIENTSECRET", $credentials["phpmailer"]["clientSecret"]);
        define("PHPMAILERTOKEN", $credentials["phpmailer"]["refreshToken"]);
        define("PHPMAILEREMAIL", $credentials["phpmailer"]["email"]);
        define("PHPMAILERPASSWORD", $credentials["phpmailer"]["password"]);
        define("PHPMAILERPORT", $credentials["phpmailer"]["port"]);
    }
}
else
//    die("erreur 404");
	header("Location: /config");