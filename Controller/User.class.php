<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Mail;
use App\Core\Notification;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;

class User
{
    public function login()
    {
        if(isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $message) {
                echo "<div class='alert alert-$type'>".$message."</div>";
            }
            unset($_SESSION['flash']);
        }
        $user = new UserModel();
  
        if(!empty($_POST))
        {
            $userLoggedIn = $user->select(['id', 'password', 'verifyAccount'], ['email' => $_POST['email']]);

            if(!empty($userLoggedIn))
            {
                if(password_verify($_POST['password'], $userLoggedIn[0]['password']))
                {
                    if($userLoggedIn[0]['verifyAccount']) {
                        $user = $user->setId($userLoggedIn[0]['id']);
                        $user->generateToken();
                        $_SESSION['token'] = $user->getToken();
                        setcookie("token", $_SESSION['token'], time() + (60 * 15));
                        $user->save();
                        header("Location: /dashboard");
                    } else {
                         Notification::CreateNotification("error", 'Compte non vérifié');
                    }
                } else {
                     Notification::CreateNotification("error", 'Mot de passe incorrect');
                }
            } else {
                 Notification::CreateNotification("error", 'Identifiant incorrect');
            }
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

                Notification::CreateNotification("success", "Inscription réussie, un email vient de vous etre envoyés");
                //$_SESSION['flash']['success'] = 'Inscription réussie, un email vient de vous etre envoyés';
                header('Location: /login');
                exit();
            }
            else
            {
                $msg = "ERREUR : <br><br>";
                foreach ($result as $item)
                    $msg .= "-" . $item . "<br>";
                Notification::CreateNotification("error", $msg);
            }
        }

        $view = new View("register");
        $view->assign("user", $user);
    }

    public function logout()
    {
        unset($_SESSION['token']);
        header('Location: /login');
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