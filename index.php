<?php

namespace App;

use App\Controller\Main;
use App\Controller\User;
use App\Core\View;
use App\Model\Page;
use App\Model\TotalVisitor;

session_start();

/*
 * AUTOLOADER
 */
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

function saveConnexion() {
    $totalVisitor = new TotalVisitor();
    $current_time=time();

    $VisitorParams = $totalVisitor->select(['id'], ['session' => session_id()]);
    if (count($VisitorParams) != 0) {
        $totalVisitor = $totalVisitor->setId(intval($VisitorParams[0]['id'], 10));
    }

    $totalVisitor->setSession(session_id());
    $totalVisitor->setTime($current_time);
    $totalVisitor->save();
}

/*
 * CHECK WEBSITE CONFIG FILE
 */
$checkConfig = true;

if(file_exists("ini.yml"))
{
    $ini = yaml_parse_file("ini.yml");

    if (empty($ini["websiteName"])          ||
        empty($ini["database"]["user"])     || empty($ini["database"]["password"])  || empty($ini["database"]["host"]) || empty($ini["database"]["port"]) ||
        empty($ini["paypal"]["clientKey"])  || empty($ini["paypal"]["currency"])    ||
        empty($ini["phpmailer"]["email"])   || empty($ini["phpmailer"]["password"]) || empty($ini["phpmailer"]["port"]))
    {
        $checkConfig = false;
    }
}
else
{
    $checkConfig = false;
}

// Set URI
$uri		= $_SERVER["REQUEST_URI"];
$offset 	= strpos($uri, '?');

// Remove GET data on URI
if ($offset)
    $uri = substr($uri, 0, $offset);

if(!$checkConfig && $uri != "/config")
    header("Location: /config");
if($checkConfig && $uri == "/config")
    header("Location: /home");
if($uri != "/config")
	require_once "conf.inc.php";


// Check existing route file
$routeFile = "routes.yml";
if(!file_exists($routeFile))
    die("Le fichier " . $routeFile . " n'existe pas");

$routes = yaml_parse_file($routeFile);

/*
 * CONTROLLER
 */
if(empty($routes[$uri]) || empty($routes[$uri]["controller"]) || empty($routes[$uri]["action"])){
    $page = new Page();
    $idPage = $page->select(["id"], ["uri" => $uri]);

	if($idPage)
    	$object = $page->setId(intval($idPage[0]["id"]));
	else
		$object = false;

    if ($object)
    {
        $page = $object;

        $controller = new Main();
        $controller->generic($page->getContent());
    }
    else {
        http_response_code(404);
        include('View/404.view.php');
        die();
    }
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
    if(!file_exists($controllerFile))
        die("Le controller " . $controllerFile . " n'existe pas");

    //Dans l'idée on doit faire un require parce vital au fonctionnement
    //Mais comme on fait vérification avant du fichier le include est plus rapide a executer
    require $controllerFile;

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
    saveConnexion();
    $objectController->$action();
}
