<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Mail;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;

class User {

    public function login()
    {
        $view = new View("Login", "back");

        $view->assign("pseudo", "Prof");
        $view->assign("firstname", "Yves");
        $view->assign("lastname", "Skrzypczyk");
    }


    public function register()
    {

        $user = new UserModel();

        if( !empty($_POST))
        {
            $result = Verificator::checkForm($user->getRegisterForm(), $_POST);
            print_r($result);
        }

        $user = new UserModel();
        $user->setIdRole(1);
        $user->setFirstname("Hoai-Viet Luc");
        $user->setLastname("DOAN");
        $user->setEmail("hoaivietdoan@gmail.com");
        $user->setPassword("Hoaiviet96");
        $user->generateToken();
        $user->setCreationDate(date("Y-m-d"));
        $user->setVerifyAccount(false);
        $user->setActiveAccount(true);
        $user->save();

        $view = new View("register");
        $view->assign("user", $user);

        $content = "
        	<h1>Cliquez sur le lien ci-dessous pour activer votre compte :</h1>
        	<a href='localhost/activation?email=".$user->getEmail()."&token=".$user->getToken()."'>Activation de votre compte.</a>
        ";

		$email = new Mail();
		$email->prepareContent("hoaivietdoan@gmail.com", "Vérification du compte", $content, "Test");
    	$email->send();
    }


    public function logout()
    {
        echo "Se déco";
    }


    public function pwdforget()
    {
        echo "Mot de passe oublié";
    }

    public function activatedaccount()
	{
        if (isset($_GET['email']) && isset($_GET['token']))
        {
            $view = new View("validateAccount");

            $user = new UserModel();
            $userParams = $user->select(['id', 'idRole'],
                                        ['email' => $_GET['email']]);

            $user = $user->setId(intval($userParams[0]['id'], 10));
            $user->setIdRole($userParams[0]['idRole']);

            if ($user->getToken() == $_GET['token'])
            {
                $user->setVerifyAccount(true);
                $user->save();
            }
        }
	}
}





