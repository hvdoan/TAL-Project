<?php

namespace App;

use App\Controller\Main;
use App\Controller\User;
use App\Core\View;
use App\Model\Page;

session_start();

require "conf.inc.php";

function myAutoloader($class)
{
	// $class => CleanWords
	$class = str_replace("App\\", "", $class);
	$class = str_replace("\\", "/", $class);
	if(file_exists($class . ".class.php")){
		include $class . ".class.php";
	}
}

spl_autoload_register("App\myAutoloader");

//Réussir à récupérer l'URI
$uri		= $_SERVER["REQUEST_URI"];
$offset 	= strpos($uri, '?');

if ($offset)
    $uri = substr($uri, 0, $offset);

$routeFile = "routes.yml";
if(!file_exists($routeFile)){
	die("Le fichier " . $routeFile . " n'existe pas");
}

$routes = yaml_parse_file($routeFile);

if(empty($routes[$uri]) || empty($routes[$uri]["controller"]) || empty($routes[$uri]["action"])){
    $page = new Page();
    $idPage = $page->select(["id"], ["uri" => $uri]);
    $object = $page->setId(intval($idPage[0]["id"]));

    if ($object != false)
    {
        $page = $object;

        $controller = new Main();
        $controller->generic($page->getContent());
    }
    else
        die("Erreur 404");
}
else
{

    $controller = ucfirst(strtolower($routes[$uri]["controller"]));
    $action = strtolower($routes[$uri]["action"]);

    /*
     *
     *  Vérfification de la sécurité, est-ce que la route possède le paramètr security
     *  Si oui est-ce que l'utilisation a les droits et surtout est-ce qu'il est connecté ?
     *  Sinon rediriger vers la home ou la page de login
     *
     */


    $controllerFile = "Controller/" . $controller . ".class.php";
    if(!file_exists($controllerFile)){
        die("Le controller " . $controllerFile . " n'existe pas");
    }
    //Dans l'idée on doit faire un require parce vital au fonctionnement
    //Mais comme on fait vérification avant du fichier le include est plus rapide a executer
    include $controllerFile;

    $controller = "App\\Controller\\".$controller;
    if( !class_exists($controller)){
        die("La classe ".$controller." n'existe pas");
    }

    // $controller = User ou $controller = Global
    $objectController = new $controller();

    if(!method_exists($objectController, $action)){
        die("L'action " . $action . " n'existe pas");
    }
    // $action = login ou logout ou register ou home
    $objectController->$action();
}