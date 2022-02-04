<?php
namespace App\Controller;

use App\Core\CleanWords;
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

        if( !empty($_POST)){

            $result = Verificator::checkForm($user->getRegisterForm(), $_POST);
            if (empty($result)) {
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword($_POST["password"]);
            $user->generateToken();
            $user->creationDate();

            $user->save();
            echo "Inscription réussie, un email vient de vous être envoyés";
            } else {
                echo "ERREUR : <br>";
                foreach ($result as $item) {
                    echo "-" . $item . "<br>";
                }
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
        echo "Mot de passe oublié";
    }

}





