<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Mail;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;

class User
{
    public function login()
    {
        $user = new UserModel();
  
        if(!empty($_POST))
        {
            $userLoggedIn = $user->select(['id', 'password'], ['email' => $_POST['email']]);

            if(!empty($userLoggedIn))
            {
                if(password_verify($_POST['password'], $userLoggedIn[0]['password']))
                {
                    $user = $user->setId($userLoggedIn[0]['id']);
                    $user->generateToken();
                    $_SESSION['token'] = $user->getToken();
                    setcookie("token", $_SESSION['token'], time() + (60 * 15));
                    $user->save();
                    header("Location: /dashboard");
                }
              
                echo 'Mot de passe incorrect';
            }
          
            echo 'Identifiant incorrect';
        }
  
        $view = new View("Login", "front");
        $view->assign("user", $user);
    }
	
    public function register()
    {
        $user = new UserModel();

        if( !empty($_POST))
        {

            $result = Verificator::checkForm($user->getRegisterForm(), $_POST);

            if (empty($result))
            {
                $user->setIdRole(1);
                $user->setFirstname($_POST["firstname"]);
                $user->setLastname($_POST["lastname"]);
                $user->setEmail($_POST["email"]);
                $user->setPassword($_POST["password"]);
                $user->generateToken();
                $user->creationDate();
                $user->setVerifyAccount(false);
                $user->setActiveAccount(true);

                $user->save();

                $content = "
                    <h1>Cliquez sur le lien ci-dessous pour activer votre compte :</h1>
                    <a href='localhost/activation?email=".$user->getEmail()."&token=".$user->getToken()."'>Activation de votre compte.</a>
                ";

                $email = new Mail();
                $email->prepareContent($user->getEmail(), "Vérification du compte", $content, "Test");
                $email->send();

                echo ('Inscription réussie, un email vient de vous être envoyés');
                header('Location: /login');
            }
            else
            {
                echo "ERREUR : <br>";
                foreach ($result as $item)
                    echo "-" . $item . "<br>";
            }
        }

        $view = new View("register");
        $view->assign("user", $user);
    }

    public function logout()
    {
        echo "Se déco";
    }

    public function pwdforget()
    {
        $user = new UserModel();

        $view = new View("pwdforget", "front");
        $view->assign("user", $user);
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