<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;

class User{
	
	public function login()
	{
		$user = new UserModel();
		if(!empty($_POST)){
			
			$userLoggedIn = $user->select(['idUser', 'password'], ['email' => $_POST['email']]);
			
			if(!empty($userLoggedIn)){
				if(password_verify($_POST['password'], $userLoggedIn[0]['password'])){
					$user = $user->setId($userLoggedIn[0]['idUser']);
					$user->generateToken();
					$_SESSION['token'] = $user->getToken();
					setcookie("token", $_SESSION['token'], time() + (60 * 15));
					$user->save();
					header("Location: /");
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





