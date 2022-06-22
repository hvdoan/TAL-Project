<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Mail;
use App\Core\Notification;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Action;
use App\Model\Log;
use App\Model\Permission;
use App\Model\Role;
use App\Model\User as UserModel;

class User{
	public function login()
	{
		$isConnected = Verificator::checkConnection();
		/* Reload the login session time if connexion status is true else redirect to login */
		if($isConnected)
			header("Location: /home");
		else
			Verificator::reloadConnection();
		
		if(isset($_SESSION['flash'])){
			foreach($_SESSION['flash'] as $type => $message){
				echo "<div class='alert alert-$type'>" . $message . "</div>";
			}
			unset($_SESSION['flash']);
		}
		$user = new UserModel();
		
		if(!empty($_POST)){
			$userLoggedIn = $user->select(['id', 'idRole', 'password', 'verifyAccount', 'firstname', 'lastname', 'email', 'avatar'], ['email' => $_POST['email']]);
			
			if(!empty($userLoggedIn)){
				if(password_verify($_POST['password'], $userLoggedIn[0]['password'])){
					if($userLoggedIn[0]['verifyAccount']){
						/*   GET USER ROLE   */
						$role   = new Role();
						$object = $role->setId(intval($userLoggedIn[0]['idRole']));
						
						if($object)
							$role = $object;
						
						$_SESSION['id']         = $userLoggedIn[0]["id"];
						$_SESSION['role']       = $role->getName();
						$_SESSION['firstname']   = $userLoggedIn[0]["firstname"];
						$_SESSION['lastname']   = $userLoggedIn[0]["lastname"];
						$_SESSION['email']      = $userLoggedIn[0]["email"];
						$_SESSION['avatar']     = $userLoggedIn[0]["avatar"];




						/*   GET USER PERMISSION ACTION   */
						$_SESSION["permission"] = [];
						$permission = new Permission();
						$actionList = $permission->select(["idAction"], ["idRole" => $userLoggedIn[0]['idRole']]);
						
						for($i = 0 ; $i < count($actionList) ; $i++){
							$action = new Action();
							$object = $action->setId(intval($actionList[$i]["idAction"]));
							
							if($object){
								$action = $object;
								$_SESSION["permission"][] = $action->getCode();
							}
						}
						
						$user = $user->setId($userLoggedIn[0]['id']);
                        $user->setIdrole(intval($userLoggedIn[0]['idRole']));
						$user->generateToken();
						
						$_SESSION["token"] = $user->getToken();
                        setcookie("token", $user->getToken(), time() + (60 * 15), "", "", true);

						$user->save();

                        $logs = new Log();
                        $logs->setIdUser($userLoggedIn[0]["id"]);
                        $logs->setAction('login');
                        $logs->setTime();

                        $logs->save();
                        header("Location: /dashboard");
					}else{
						Notification::CreateNotification("error", 'Compte non vérifié');
					}
				}else{
					Notification::CreateNotification("error", 'Mot de passe incorrect');
				}
			}else{
				Notification::CreateNotification("error", 'Identifiant incorrect');
			}
		}
		
		$view = new View("login", "front");
		$view->assign("user", $user);
		$view->assign("isConnected", $isConnected);
	}
	
	public function register()
	{
		$isConnected = Verificator::checkConnection();
		/* Reload the login session time if connexion status is true else redirect to login */
		if($isConnected)
			header("Location: /home");
		else
			Verificator::reloadConnection();
		
		$user = new UserModel();
		
		if(!empty($_POST)){
			$role = new Role();
			$userRole = $role->select(["id"], ["name" => "Utilisateur"]);
			
			if(count($userRole) > 0){
				
				$AccountExist = $user->select(['id'], ['email' => $_POST['email']]);
				$result = Verificator::checkForm($user->getRegisterForm(), $_POST);
				
				if(empty($result) && empty($AccountExist[0])){
					$user->setIdRole($userRole[0]["id"]);
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
                    <a href='localhost/activation?email=" . $user->getEmail() . "&token=" . $user->getToken() . "'>Activation de votre compte.</a>
                ";
					
					$email = new Mail();
					$email->prepareContent($user->getEmail(), "Vérification du compte", $content, "Test");
					$email->send();
					
					Notification::CreateNotification("success", "Inscription réussie, un email vient de vous etre envoyés");
					//$_SESSION['flash']['success'] = 'Inscription réussie, un email vient de vous etre envoyés';
					header('Location: /login');
					exit();
				}else{
					$msg = "";
					if(!empty($AccountExist)){
						$msg .= "- Email déjà existant";
					}
					foreach($result as $item){
						$msg .= "-" . $item . "<br>";
					}
					Notification::CreateNotification("error", $msg);
				}
			}else{
				$msg = "Une erreur est survenue";
				Notification::CreateNotification("error", $msg);
			}
		}
		
		$view = new View("register");
		$view->assign("user", $user);
		$view->assign("isConnected", $isConnected);
	}
	
	public function logout()
	{
		unset($_SESSION['token']);
		unset($_SESSION['id']);
		unset($_SESSION['permission']);
		unset($_SESSION['role']);
		header('Location: /login');
	}
	
	public function pwdforget()
	{
        $user = new UserModel();

        if(!empty($_POST)){
            $result = Verificator::checkForm($user->getForgotPasswordForm(), $_POST);

            if(empty($result)) {
                $user->generateToken();
                $user->setEmail($_POST["email"]);

                $content = "
                    <h1>Cliquez sur le lien ci-dessous pour changer votre mot de passe :</h1>
                    <a href='localhost/activation?email=" . $user->getEmail() . "&token=" . $user->getToken() . "'>Changer le mot de passe.</a>
                ";

                $email = new Mail();
                $email->prepareContent($_POST['email'], "Reinitialisation du mot de passe", $content, "Test");
                $email->send();

                Notification::CreateNotification("success", "Si le compte existe, un mail vient de vous etre envoyé");

            } else {
                $msg = "";
                foreach ($result as $item) {
                    $msg .= "-" . $item . "<br>";
                }
                Notification::CreateNotification("error", $msg);
            }
        }

        $view = new View("forgot-password");
        $view->assign("user", $user);
	}

    public function pwdReset()
    {
        $user = new UserModel();

        if(isset($_GET['email']) && isset($_GET['token'])){

            $userParams = $user->select(['id'], ['email' => $_GET['email']]);

            $user = $user->setId(intval($userParams[0]['id'], 10));

            if($user->getToken() == $_GET['token']){
                if(!empty($_POST)){
                    $result = Verificator::checkForm($user->getResetPassword(), $_POST);
                    if(empty($result)) {
                        $user->setPassword($_POST["password"]);
                        $user->save();
                        Notification::CreateNotification("success", "Mot de passe modifié avec succès");
                        header('Location: /login');
                    }
                }

                $view = new View("reset-password");
                $view->assign("user", $user);
            }

        } else {
            http_response_code(404);
            include('View/404.view.php');
            die();
        }
    }
	
	public function activatedaccount()
	{
		if(isset($_GET['email']) && isset($_GET['token'])){
			$view = new View("validateAccount");
			
			$user = new UserModel();
			$userParams = $user->select(['id', 'idRole'], ['email' => $_GET['email']]);
			
			$user = $user->setId(intval($userParams[0]['id'], 10));
			$user->setIdRole($userParams[0]['idRole']);
			
			if($user->getToken() == $_GET['token']){
				$user->setVerifyAccount(true);
				$user->save();
			}
		} else {
            http_response_code(404);
            include('View/404.view.php');
            die();
        }
	}

    public function userSetting()
    {
        /* Get the connexion status */
        $isConnected = Verificator::checkConnection();

        if(!$isConnected)
        {
            Verificator::unsetSession();
            header("Location: /home");
        }

        $user = new UserModel();

        $object = $user->setId(intval($_SESSION["id"]));

        if($object)
            $user = $object;

        if(!empty($_POST)){

            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $_SESSION['firstname']   = $_POST['firstname'];
            $_SESSION['lastname']   = $_POST['lastname'];

            if($_POST['password'] == "" && $_POST['newpassword'] == ""){
                $user->save();
                Notification::CreateNotification("success", "Modification des parametres sauvegardé");
            } else {
                if ($_POST['newpassword'] != "" && $_POST['password'] == "") {
                    Notification::CreateNotification('error', 'Entrer votre mot de passe actuel pour avoir enregistrer votre nouveau mot de passe ');
                } else if (password_verify($_POST['password'], $user->getPassword())) {
                    $result = Verificator::checkForm($user->getUserSettingForm(), $_POST);
                    if(empty($result)) {
                        $user->setPassword($_POST['newpassword']);
                        $user->save();
                        Notification::CreateNotification("success", "Modification des parametres sauvegardé");
                    } else {
                        $msg = "";
                        foreach($result as $item){
                            $msg .= "-" . $item . "<br>";
                        }
                        Notification::CreateNotification("error", $msg);
                    }
                } else {
                    Notification::CreateNotification('error', 'Mot de passe incorrect');
                }
            }
        }

        $view = new View("userSetting");
        $view->assign("user", $user);
        $view->assign("isConnected", $isConnected);
    }
}
