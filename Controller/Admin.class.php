<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Model\Action;
use App\Model\Forum;
use App\Model\Message;
use App\Model\Page;
use App\Model\Permission;
use App\Model\Role;
use App\Model\Tag;
use App\Model\User as UserModel;
use DateTime;
use App\Model\DonationTier;

class Admin
{
    public function dashboard()
    {
        /* Reload the login session time if connexion status is true else redirect to login */
    	if(!Verificator::checkConnection())
    		header("Location: /login");
        else
            Verificator::reloadConnection();

        /* Display users HTML Structure */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "ADMIN_ACCESS"))
			header("Location: /home");

        $view = new View("home", "back");
    }

	public function configuration()
	{
        /* Reload the login session time if connexion status is true else redirect to login */
		if(!Verificator::checkConnection())
			header("Location: /login");
        else
            Verificator::reloadConnection();

        /* Display users HTML Structure */
        // ...

		echo "Ceci est un beau dashboard";
	}
	
	public function usermanagement()
	{
        /* Get the connexion status */
        $isConnected = Verificator::checkConnection();

        /* Reload the login session time if connexion status is true */
        if($isConnected)
            Verificator::reloadConnection();

        /* Check access permission */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_USER"))
			header("Location: /dashboard");

		$user = new UserModel();
		$role = new Role();
		
		/* Display users HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "display")
        {
            if(!$isConnected)
                echo "login";
            else
            {
                $usersList = $user->select(["id", "lastname", "firstname", "email", "idRole"], []);
                $htmlContent = "";

                foreach($usersList as $user)
                {
                    $htmlContent .= "<tr>";
                    $htmlContent .= "<td><input class='idUser' type='checkbox' name='" . $user["id"] . "'></td>";
                    $htmlContent .= "<td>" . $user["id"] . "</td>";
                    $htmlContent .= "<td id='" . $user["id"] . "'>" . $user["firstname"] . " " . strtoupper($user["lastname"]) . "</td>";
                    $htmlContent .= "<td>" . $user["email"] . "</td>";

                    $object = $role->setId(intval($user["idRole"]));

                    if($object != false){
                        $role = $object;
                    }
                    $htmlContent .= "<td>" . $role->getName() . "</td>";
                    $htmlContent .= "<td><button class='btn btn-edit' onclick='openUserForm(\"" . $user["id"] . "\")'>Editer</button></td>";
                    $htmlContent .= "</tr>";
                }

                echo $htmlContent;
            }
        }
        else if((isset($_POST["requestType"]) && $_POST["requestType"] == "insert") &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
			
//			if((isset($_POST["userFirstname"]) && $_POST["userFirstname"] != "")
//				&& (isset($_POST["userLastname"]) && $_POST["userLastname"] != "")
//				&& (isset($_POST["userEmail"]) && $_POST["userEmail"] != "")
//				&& (isset($_POST["userIdRole"]) && $_POST["userIdRole"] != "")
//				&& (isset($_POST["userPassword"]) && $_POST["userPassword"] != "")){
//				/* Creation of a user */
//				$user->setFirstname($_POST["userFirstname"]);
//				$user->setLastname($_POST["userLastname"]);
//				$user->setEmail($_POST["userEmail"]);
//				$user->setIdRole($_POST["userIdRole"]);
//				$user->setPassword($_POST["userPassword"]);
//				$user->generateToken();
//				$user->creationDate();
//				$user->setVerifyAccount(false);
//				$user->setActiveAccount(true);
//
//				$user->save();
//				$object = $user->setId(intval($user->getLastInsertId()));
//				if($object != false){
//					$user = $object;
//				}
//			}
		}
        else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "update" : false) &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!$isConnected)
                echo "login";
		    else
            {
                if(!empty($_POST["userId"])
                    && !empty($_POST["userLastname"])
                    && !empty($_POST["userFirstname"])
                    && !empty($_POST["userEmail"])
                    && !empty($_POST["userIdRole"]))
                {
                    $avatarToSet = 0;

                    if (!empty($_FILES["avatar"]))
                    {
                        $avatarToSet = 1;

                        /* Get avatar file info */
                        $fileName   = basename($_FILES["avatar"]["name"]);
                        $fileType   = pathinfo($fileName, PATHINFO_EXTENSION);

                        $imageContent       = "";

                        $allowTypes = array("jpg","png","jpeg","gif");

                        if(in_array($fileType, $allowTypes))
                        {
                            $image          = $_FILES['avatar']['tmp_name'];
                            $imageContent   = base64_encode(file_get_contents($image));
                        }
                    }

                    /* Escape SQL injection */
                    $lastname       = addslashes($_POST["userLastname"]);
                    $firstname      = addslashes($_POST["userFirstname"]);
                    $email          = addslashes($_POST["userEmail"]);
                    $idRole         = addslashes($_POST["userIdRole"]);

                    /* Update of user information */
                    $object = $user->setId(intval($_POST["userId"]));

                    if($object != false)
                        $user = $object;

                    if ($avatarToSet)
                        $user->setAvatar($imageContent);

                    $user->setFirstname($firstname);
                    $user->setLastname($lastname);
                    $user->setEmail($email);
                    $user->setIdRole(intval($idRole));
                    $user->save();

                    echo "1";
                }
            }
		}
        else if((isset($_POST["requestType"]) && $_POST["requestType"] == "delete"))
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if (isset($_POST["userIdList"]) && $_POST["userIdList"] != "") {
                    /* Delete users */
                    $userIdList = explode(",", $_POST["userIdList"]);

                    for ($i = 0; $i < count($userIdList); $i++) {
                        /* Deletion of the user */
                        $object = $user->setId($userIdList[$i]);
                        if ($object != false) {
                            $user = $object;
                        }
                        $user->delete();
                    }
                }
            }
		}
        else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm")
        {
            $canChangeRole      = true;
            $noPermissionType   = 0;

            if(!$isConnected)
                echo "login";
            else
            {
                $roleList = $role->select(["id", "name"], []);
                $htmlContent = "";

                if (isset($_POST["userId"]) && $_POST["userId"] != "")
                {
                    $getUserIdRole = $user->select(["idRole"], ["id" => $_POST["userId"]]);
                    $object = $user->setId(intval($_POST["userId"]));

                    if ($object != false)
                    {
                        $user = $object;
                        $user->setIdRole($getUserIdRole[0]["idRole"]);

                        $role = new Role();
                        $object = $role->setId($user->getIdRole());

						if ($object != false)
						{
							$role       = $object;
                            $listAction = $role->getAction();

                            foreach($listAction as $action)
                            {
                                /*
                                 * Permission not granted in the following cases:
                                 *   - Change of own role
                                 *   - Change of role of an administrator
                                 *   - Change of role that has user management rights as non-super admin
                                 * */
                                if($_SESSION["id"] == $user->getId())
                                {
                                    $canChangeRole = false;
                                    $noPermissionType = 1;
                                }
                                else if($action->getCode() == "MANAGE_USER" && $_SESSION["role"] != "Administrateur")
                                {
                                    $canChangeRole = false;
                                    $noPermissionType = 2;
                                }
                                else if($role->getName() == "Administrateur")
                                {
                                    $canChangeRole = false;
                                    $noPermissionType = 2;
                                }
                            }
						}
                    }
                }

                $token = md5(uniqid());
                $_SESSION["tokenForm"] = $token;

                if ($user->getId() != null)
                {
					$htmlContent .= "<form class='form'>";

					/* @CSRF */
					$htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";

                    /* Header */
					$htmlContent .= "<div class='field-row'>";
					$htmlContent .= "<div class='field'>";
                    $htmlContent .= "<h1>Modification de l'utilisateur : " . $user->getFirstname() . " " . strtoupper($user->getLastname()) . "</h1>";
					$htmlContent .= "</div>";

					$htmlContent .= "<div id='role-ctn' class='field'>";
                    $htmlContent .= "<span>" . $role->getName() . "</span>";
					$htmlContent .= "</div>";
					$htmlContent .= "</div>";

					$htmlContent .= "<div class='field-row'>";
					$htmlContent .= "<hr>";
					$htmlContent .= "</div>";

                    /* Name field */
					$htmlContent .= "<div class='field-row'>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Nom *</label>";
                    $htmlContent .= "<input id='input-lastname' class='input' type='text' name='lastname' value='" . $user->getLastname() . "'>";
					$htmlContent .= "</div>";

					$htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Prénom *</label>";
                    $htmlContent .= "<input id='input-firstname' class='input' type='text' name='firstname' value='" . $user->getFirstname() . "'>";
					$htmlContent .= "</div>";
					$htmlContent .= "</div>";

                    /* Email field */
					$htmlContent .= "<div class='field-row'>";
					$htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Email *</label>";
                    $htmlContent .= "<input id='input-email' class='input disabled' type='text' name='email' value='" . $user->getEmail() . "' disabled>";
                    $htmlContent .= "</div>";
					$htmlContent .= "</div>";

                    /* Role field */
					$htmlContent .= "<div class='field-row'>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label for='input-idRole'>Rôles *</label>";
                    $htmlContent .= "<div id='select-ctn'>";

                    if($noPermissionType)
                        $htmlContent .= "<select class='disabled' name='userIdRole' id='input-idRole' disabled>";
                    else
                        $htmlContent .= "<select name='userIdRole' id='input-idRole'>";

                    foreach ($roleList as $role)
                    {
                        $htmlContent .= "<option value='" . $role["id"] . "'";
                        $htmlContent .= ($role["id"] == $user->getIdRole()) ? "selected>" : ">";
                        $htmlContent .= $role["name"] . "</option>";
                    }

                    $htmlContent .= "</select>";

                    if($noPermissionType == 1)
                        $htmlContent .= "<i class='fa-solid fa-circle-exclamation questionMark' data-toggle='tooltip' title='Impossible de changer son propre rôle.'></i>";
                    else if($noPermissionType == 2)
                        $htmlContent .= "<i class='fa-solid fa-circle-exclamation questionMark' data-toggle='tooltip' title='Modification du rôle impossible, permission pas assez élevé.'></i>";

                    $htmlContent .= "</div>";
                    $htmlContent .= "</div>";
					$htmlContent .= "</div>";

                    /* avatar field */
					$htmlContent .= "<div class='field-row'>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Avatar</label>";
                    $htmlContent .= "<div id='select-avatar-ctn'>";
                    $htmlContent .= "<div id='avatar-preview'><i class='fa-solid fa-plus'></i></div>";
                    $htmlContent .= "<label for='input-avatar'>Choisir une image</label>";
                    $htmlContent .= "<input id='input-avatar' class='hide' type='file' name='avatar' onchange='displayUserAvatar()'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "</div>";
					$htmlContent .= "</div>";

                    /* cta */
					$htmlContent .= "<div class='field-row field-cta'>";
					$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $user->getId() . "'>";
					$htmlContent .= "<input class='btn-form btn-form-cancel' onclick='closeUserForm()' type='button' value='Annuler'>";
					$htmlContent .= "<input class='btn-form btn-form-validate' onclick='updateUser()' type='button' value='Modifier'>";
					$htmlContent .= "</div>";

					$htmlContent .= "</form>";
                }

                echo $htmlContent;
            }
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "displayAvatar" : false) /* &&
			(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false)*/)
		{
			if(!$isConnected)
				echo "login";
			else
			{
				if(!empty($_FILES["avatar"]))
				{
					/* Get avatar file info */
					$fileName   = basename($_FILES["avatar"]["name"]);
					$fileType   = pathinfo($fileName, PATHINFO_EXTENSION);

					$allowTypes = array("jpg","png","jpeg","gif");

					if(in_array($fileType, $allowTypes))
					{
						$image          = $_FILES['avatar']['tmp_name'];
						$imageContent   = base64_encode(file_get_contents($image));
					}

					echo "<img class='icon' src='data:<?=mime_content_type(" . $fileType . ")?>>;base64, " . $imageContent . "'>";
				}
			}
		}
        else
		{
            if(!$isConnected)
                header("Location: /login");

			if(!isset($_POST["requestType"])){
				$view = new View("userManagement", "back");
			}
		}
	}

	public function managerole()
	{
        /* Get the connexion status */
        $isConnected = Verificator::checkConnection();

        /* Reload the login session time if connexion status is true */
        if($isConnected)
            Verificator::reloadConnection();

        /* Check access permission */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_ROLE"))
			header("Location: /dashboard");

        /* Format HTML structure for display role */
		$role = new Role();

		if(isset($_POST["requestType"]) ? $_POST["requestType"] == "display" : false)
		{
            if(!$isConnected)
                echo "login";
            else
            {
                $roleList = $role->select(["id", "name", "description"], []);
                $htmlContent = "";

                foreach ($roleList as $role) {
                    $htmlContent .= "<tr>";

                    if ($role["name"] == "Utilisateur" || $role["name"] == "Administrateur")
                        $htmlContent .= "<td></td>";
                    else
                        $htmlContent .= "<td><input class='idRole' type='checkbox' name='" . $role["id"] . "'></td>";

                    $htmlContent .= "<td id='" . $role["id"] . "'>" . $role["name"] . "</td>";
                    $htmlContent .= "<td>" . $role["description"] . "</td>";

                    if ($role["name"] == "Utilisateur" || $role["name"] == "Administrateur")
                        $htmlContent .= "<td></td>";
                    else
                        $htmlContent .= "<td><button class='btn btn-edit' onclick='openRoleForm(\"" . $role["id"] . "\")'>Editer</button></td>";

                    $htmlContent .= "</tr>";
                }

                echo $htmlContent;
            }
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "insert" : false) &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
		{
            if(!$isConnected)
                echo "login";
            else
            {
                if ((isset($_POST["roleName"]) ? $_POST["roleName"] != "" : false) &&
                    (isset($_POST["roleDescription"]) ? $_POST["roleDescription"] != "" : false) &&
                    isset($_POST["actionList"])) {
                    /* Creation of the role */
                    $role->setName($_POST["roleName"]);
                    $role->setDescription($_POST["roleDescription"]);
                    $role->save();
                    $role = $role->setId($role->getLastInsertId());

                    /* Creation of permissions related to the role */
                    $actionList = explode(",", $_POST["actionList"]);

                    for ($i = 0; $i < count($actionList); $i++) {
                        $permission = new Permission();
                        $permission->setIdRole($role->getId());
                        $permission->setIdAction(intval($actionList[$i]));
                        $permission->save();
                    }
                }
            }
		}
        else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "update" : false) &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if ((isset($_POST["roleId"]) ? ($_POST["roleId"] != "") : false) &&
                    (isset($_POST["roleName"]) ? ($_POST["roleName"] != "") : false) &&
                    (isset($_POST["roleDescription"]) ? ($_POST["roleDescription"] != "") : false) &&
                    isset($_POST["actionList"])) {
                    /* Update of the role information */
                    $role = $role->setId(intval($_POST["roleId"]));
                    $role->setName($_POST["roleName"]);
                    $role->setDescription($_POST["roleDescription"]);
                    $role->save();

                    /* Removal of role-related permissions */
                    $permission = new Permission();
                    $permissionList = $permission->select(["id"], ["idRole" => $role->getId()]);

                    for ($j = 0; $j < count($permissionList); $j++) {
                        $permission = $permission->setId($permissionList[$j]["id"]);
                        $permission->delete();
                    }

                    /* Recreate updated permissions related to the role */
                    $actionList = explode(",", $_POST["actionList"]);

                    for ($i = 0; $i < count($actionList); $i++) {
                        $permission = new Permission();
                        $permission->setIdRole($role->getId());
                        $permission->setIdAction(intval($actionList[$i]));
                        $permission->save();
                    }
                }
            }
        }
		else if(isset($_POST["requestType"]) ? $_POST["requestType"] == "delete" : false)
		{
            if(!$isConnected)
                echo "login";
            else {
                /* Processing of role deletion */
                $roleIdList = explode(",", $_POST["roleIdList"]);

                for ($i = 0; $i < count($roleIdList); $i++) {
                    $permission = new Permission();
                    $permissionList = $permission->select(["id"], ["idRole" => $roleIdList[$i]]);

                    /* Removal of role-related permissions */
                    for ($j = 0; $j < count($permissionList); $j++) {
                        $permission = $permission->setId($permissionList[$j]["id"]);
                        $permission->delete();
                    }

                    /* Deletion of the role */
                    $role = $role->setId($roleIdList[$i]);
                    $role->delete();
                }
            }
		}
		else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm")
		{
            if(!$isConnected)
                echo "login";
            else
            {
                $action = new Action();
                $actionList = $action->select(["id", "code", "description"], []);
                $htmlContent = "";
                $permissionList = [];

                if ($_POST["roleId"] != "")
                    $role = $role->setId(intval($_POST["roleId"]));

                $permission = new Permission();
                $permissionList = $permission->select(["idAction"], ["idRole" => $role->getId()]);

                $token = md5(uniqid());
                $_SESSION["tokenForm"] = $token;

                $htmlContent .= "<form class='form'>";

                // @CSRF
                $htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";

                /* Header */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<h1>Paramétrage du rôle : " . $role->getName() . "</h1>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* Separator */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<hr>";
                $htmlContent .= "</div>";

                /* Name field */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<label>Nom du rôle</label>";
                $htmlContent .= "<input id='input-name' class='input' type='text' name='name' value='" . $role->getName() . "'>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* Description field */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<label>Description</label>";
                $htmlContent .= "<input id='input-description' class='input' type='text' name='description' value='" . $role->getDescription() . "'>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* Permission field */
                for ($i = 0; $i < count($actionList); $i++) {
                    $htmlContent .= "<div class='field-row permissions'>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>" . $actionList[$i]["description"] . "</label>";
                    $isFind = false;

                    for ($j = 0; $j < count($permissionList) && !$isFind; $j++) {
                        if (in_array($actionList[$i]["id"], $permissionList[$j]))
                            $isFind = true;
                    }

                    $htmlContent .= "<label for='switch-" . $actionList[$i]["id"] . "' class='btn-switch'>";

                    if ($isFind)
                    {
                        $htmlContent .= "<input id='switch-" . $actionList[$i]["id"] . "' class='input-permission' type='checkbox' name='" . $actionList[$i]["id"] . "' checked>";
//                        $htmlContent .= "<input class='input-permission' type='radio' name='" . $actionList[$i]["id"] . "' value='1' checked>";
//                        $htmlContent .= "<input type='radio' name='" . $actionList[$i]["id"] . "' value='0'>";
                    }
                    else
                    {
                        $htmlContent .= "<input id='switch-" . $actionList[$i]["id"] . "' class='input-permission' type='checkbox' name='" . $actionList[$i]["id"] . "'>";
//                        $htmlContent .= "<input class='input-permission' type='radio' name='" . $actionList[$i]["id"] . "' value='1'>";
//                        $htmlContent .= "<input type='radio' name='" . $actionList[$i]["id"] . "' value='0' checked>";
                    }

                    $htmlContent .= "<span class='slider'></span>";
                    $htmlContent .= "</label>";

                    $htmlContent .= "</div>";
                    $htmlContent .= "</div>";
                }

                /* cta */
                $htmlContent .= "<div class='field-cta'>";
                $htmlContent .= "<input class='btn-form btn-form-cancel' onclick='closeRoleForm()' type='button' value='Annuler'>";

                if ($role->getId() != null) {
                    $htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $role->getId() . "'>";
                    $htmlContent .= "<input class='btn-form btn-form-validate' onclick='updateRole()' type='button' value='Modifier'>";
                } else
                    $htmlContent .= "<input class='btn-form btn-form-validate' onclick='insertRole()' type='button' value='Créer'>";
                $htmlContent .= "</div>";
                $htmlContent .= "</form>";

                echo $htmlContent;
            }
		}
		else if(!isset($_POST["requestType"]))
		{
            if(!$isConnected)
                header("Location: /login");

			$view = new View("roleManagement", "back");
		}
	}

    public function managepage()
    {
        /* Get the connexion status */
        $isConnected = Verificator::checkConnection();

        /* Reload the login session time if connexion status is true */
        if($isConnected)
            Verificator::reloadConnection();

        /* Check access permission */
        if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_PAGE"))
            header("Location: /dashboard");

        define("PERMANENT_PAGE", [
            "home",
            "presentation",
            "galerie",
            "faq",
            "forum",
            "donation"
        ]);

        /* Format HTML structure for display page */
        $page = new Page();

        if(isset($_POST["requestType"]) && $_POST["requestType"] == "display")
        {
            if(!$isConnected)
                echo "login";
            else
            {
                $pageList = $page->select(["id", "idUser", "uri", "description", "dateModification"], []);
                $htmlContent = "";

                foreach ($pageList as $page) {
                    $user = new UserModel();
                    $user = $user->setId(intval($page["idUser"]));

                    $date = new DateTime($page["dateModification"]);

                    $htmlContent .= "<tr>";

                    if (in_array(str_replace("/", "", $page["uri"]), PERMANENT_PAGE))
                        $htmlContent .= "<td></td>";
                    else
                        $htmlContent .= "<td><input class='idPage' type='checkbox' name='" . $page["id"] . "'></td>";

                    $htmlContent .= "<td>" . $user->getLastname() . " " . $user->getFirstname() . "</td>";
                    $htmlContent .= "<td id='" . $page["id"] . "'>" . $page["uri"] . "</td>";
                    $htmlContent .= "<td>" . $page["description"] . "</td>";
                    $htmlContent .= "<td>Le " . $date->format("d/m/Y à H\hi") . "</td>";
                    $htmlContent .= "<td><a class='btn' href='/page-creation?page=" . $page["id"] . "'>Editer</a></td>";
                    $htmlContent .= "</tr>";
                }

                echo $htmlContent;
            }
        }
        else if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "delete") : false)
        {
            if(!$isConnected)
                echo "login";
            else
            {
                /* Processing of page deletion */
                $pageIdList = explode(",", $_POST["pageIdList"]);

                for($i = 0; $i < count($pageIdList); $i++)
                {
                    /* Deletion of the page */
                    $object = $page->setId($pageIdList[$i]);

                    if ($object != false)
                    {
                        $page = $object;
                        $page->delete();
                    }
                }
            }
        }
        else if(!isset($_POST["requestType"]))
        {
            if(!$isConnected)
                header("Location: /login");

            $view = new View("pageManagement", "back");
        }
    }

    public function creationpage()
    {
        /* Get the connexion status */
        $isConnected = Verificator::checkConnection();

        /* Reload the login session time if connexion status is true */
        if($isConnected)
            Verificator::reloadConnection();

        /* Check access permission */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_PAGE"))
			header("Location: /dashboard");

        $isNew  = true;
        $page   = new Page();

        if((isset($_POST["requestType"]) ? ($_POST["requestType"] == "insert") : false) &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if((isset($_POST["data"]) ? ($_POST["data"] != "") : false) &&
                    (isset($_POST["pageUri"]) ? ($_POST["pageUri"] != "") : false) &&
                    (isset($_POST["pageDescription"]) ? ($_POST["pageDescription"] != "") : false))
                {
                    $uri        = str_replace("/", "", $_POST["pageUri"]);
                    $uri        = "/" . $uri;
                    $pageList   = $page->select(["id"], ["uri" => $uri]);

                    if(count($pageList) <= 0)
                    {
                        $page->setIdUser(1);            //===<> TEMPORAIRE
                        $page->setUri($uri);
                        $page->setDescription($_POST["pageDescription"]);
                        $page->setContent($_POST["data"]);
                        $page->setDateModification(date("Y-m-d H:i:s"));
                        $page->save();
                    }
                }
            }
        }
        else if((isset($_POST["requestType"]) ? ($_POST["requestType"] == "update") : false) &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if((isset($_POST["pageId"]) ? ($_POST["pageId"] != "") : false) &&
                    (isset($_POST["data"]) ? ($_POST["data"] != "") : false) &&
                    (isset($_POST["pageUri"]) ? ($_POST["pageUri"] != "") : false) &&
                    (isset($_POST["pageDescription"]) ? ($_POST["pageDescription"] != "") : false))
                {
                    /* Update of the page information */
                    $object = $page->setId(intval($_POST["pageId"]));

                    if ($object != false)
                    {
                        $page = $object;
                        $uri = str_replace("/", "", $_POST["pageUri"]);
                        $uri = "/" . $uri;

                        $page->setIdUser($_SESSION["id"]);
                        $page->setUri($uri);
                        $page->setDescription($_POST["pageDescription"]);
                        $page->setContent($_POST["data"]);
                        $page->setDateModification(date("Y-m-d H:i:s"));
                        $page->save();
                    }
                }
            }
        }
        else if(!isset($_POST["requestType"]))
        {
            if(!$isConnected)
                header("Location: /login");

            $view   = new View("pageCreation", "back");

            if(isset($_GET["page"]))
            {
                $object = $page->setId(intval($_GET["page"]));

                if ($object != false)
                    $page = $object;
            }

            $token = md5(uniqid());
            $_SESSION["tokenForm"] = $token;

            $view->assign("tokenForm", $token);
            $view->assign("page", $page);
        }
    }
	
	public function palierdonation()
	{
        /* Get the connexion status */
        $isConnected = Verificator::checkConnection();

        /* Reload the login session time if connexion status is true */
        if($isConnected)
            Verificator::reloadConnection();

        /* Check access permission */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_DONATION_TIER"))
			header("Location: /dashboard");
		
		$donationTier = new DonationTier();
		
		/* Display donationTier HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "display")
        {
            if(!$isConnected)
                echo "login";
            else
            {
                $donationTierList = $donationTier->select(["id", "name", "description", "price"], []);
                $htmlContent = "";

                foreach($donationTierList as $donationTier){
                    $htmlContent .= "<tr>";
                    $htmlContent .= "<td><input class='idDonationTier' type='checkbox' name='" . $donationTier["id"] . "'></td>";
                    $htmlContent .= "<td>" . $donationTier["id"] . "</td>";
                    $htmlContent .= "<td id='" . $donationTier["id"] . "'>" . $donationTier["name"] . "</td>";
                    $htmlContent .= "<td>" . $donationTier["description"] . "</td>";
                    $htmlContent .= "<td>" . intval(($donationTier['price'] / 100)) . "," . ($donationTier['price'] % 100) . "</td>";

                    $htmlContent .= "<td><button class='btn btn-edit' onclick='openDonationForm(\"" . $donationTier["id"] . "\")'>Editer</button></td>";
                    $htmlContent .= "</tr>";
                }

                echo $htmlContent;
            }
		}
        else if((isset($_POST["requestType"]) && $_POST["requestType"] == "insert") &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if( (isset($_POST["donationTierName"]) ? $_POST["donationTierName"] != "" : false) &&
	                (isset($_POST["donationTierDescription"]) ? $_POST["donationTierDescription"] != "" : false) &&
	                (isset($_POST["donationTierPrice"]) ? $_POST["donationTierPrice"] != "" : false) ){

                    /* Creation of a donationTier */
                    $donationTier->setName($_POST["donationTierName"]);
                    $donationTier->setDescription($_POST["donationTierDescription"]);
                    $donationTier->setPrice($_POST["donationTierPrice"]);
                    $donationTier->save();
                }
            }
		}
        else if((isset($_POST["requestType"]) && $_POST["requestType"] == "update") &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if( (isset($_POST["donationTierId"]) ? $_POST["donationTierId"] != "" : false) &&
	                (isset($_POST["donationTierName"]) ? $_POST["donationTierName"] != "" : false) &&
	                (isset($_POST["donationTierDescription"]) ? $_POST["donationTierDescription"] != "" : false) &&
	                (isset($_POST["donationTierPrice"]) ? $_POST["donationTierPrice"] != "" : false) ){

                    /* Update of donationTier information */
                    $object = $donationTier->setId(intval($_POST["donationTierId"]));
                    if($object != false){
                        $donationTier = $object;
                    }
                    $donationTier->setName($_POST["donationTierName"]);
                    $donationTier->setDescription($_POST["donationTierDescription"]);
                    $donationTier->setPrice($_POST["donationTierPrice"]);
                    $donationTier->save();
                }
            }
		}
        else if(isset($_POST["requestType"]) && $_POST["requestType"] == "delete")
        {
            if(!$isConnected)
                echo "login";
            else
            {
                if(isset($_POST["donationTierIdList"]) && $_POST["donationTierIdList"] != ""){
                    /* Delete donationTier */
                    $donationTierIdList = explode(",", $_POST["donationTierIdList"]);

                    for($i = 0 ; $i < count($donationTierIdList) ; $i++){
                        /* Deletion of the donationTier */
                        $object = $donationTier->setId($donationTierIdList[$i]);
                        if($object != false){
                            $donationTier = $object;
                        }
                        $donationTier->delete();
                    }
                }
            }
		}
        else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm")
        {
            if(!$isConnected)
                echo "login";
            else
            {
                $htmlContent = "";

                if(isset($_POST["donationTierId"]) && $_POST["donationTierId"] != "")
                {
                    $object = $donationTier->setId(intval($_POST["donationTierId"]));

                    if($object != false)
                        $donationTier = $object;
                }

                $token = md5(uniqid());
                $_SESSION["tokenForm"] = $token;

                $htmlContent .= "<form class='form'>";

                // @CSRF
                $htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";

                /* Header */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<h1>Paramétrage du rôle : " . $donationTier->getName() . "</h1>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* Separator */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<hr>";
                $htmlContent .= "</div>";

                /* Name field */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<label>Nom</label>";
                $htmlContent .= "<input id='input-name' class='input' type='text' name='name' value='" . $donationTier->getName() . "'>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* Description field */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<label>Description</label>";
                $htmlContent .= "<input id='input-description' class='input' type='text' name='description' value='" . $donationTier->getDescription() . "'>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* Price field */
                $htmlContent .= "<div class='field-row'>";
                $htmlContent .= "<div class='field'>";
                $htmlContent .= "<label>Prix (en centimes)</label>";
                $htmlContent .= "<input id='input-price' class='input' type='text' name='price' value='" . $donationTier->getPrice() . "'>";
                $htmlContent .= "</div>";
                $htmlContent .= "</div>";

                /* cta */
                $htmlContent .= "<div class='field-cta'>";
                $htmlContent .= "<input class='btn-form btn-form-cancel' onclick='closeDonationForm()' type='button' value='Annuler'>";

                if($donationTier->getId() != null)
                {
                    $htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $donationTier->getId() . "'>";
                    $htmlContent .= "<input class='btn-form btn-form-validate' onclick='updateDonationTier()' type='button' value='Modifier'>";
                }
                else
                    $htmlContent .= "<input class='btn-form btn-form-validate' onclick='insertDonationTier()' type='button' value='Créer'>";

                $htmlContent .= "</div>";
                $htmlContent .= "</form>";

                echo $htmlContent;
            }
		}
        else
        {
            if(!$isConnected)
                header("Location: /login");

			if(!isset($_POST["requestType"]))
				$view = new View("donationTier", "back");
		}
	}
	
	public function tag()
	{
		if(!Verificator::checkConnection())
			header("Location: /login");
		
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_FORUM"))
			header("Location: /dashboard");
		
		$tag = new Tag();
		
		/* Display donationTier HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "display"){
			$tags = $tag->select(["id", "name", "description"], []);
			$htmlContent = "";
			
			foreach($tags as $tag){
				$htmlContent .= "<tr>";
					$htmlContent .= "<td><input class='idTag' type='checkbox' name='" . $tag["id"] . "'></td>";
					$htmlContent .= "<td>" . $tag["id"] . "</td>";
					$htmlContent .= "<td id='" . $tag["id"] . "'>" . $tag["name"] . "</td>";
					$htmlContent .= "<td>" . $tag["description"] . "</td>";
					
					$htmlContent .= "<td><button class='btn btn-edit' onclick='openForm(\"" . $tag["id"] . "\")'>Editer</button></td>";
				$htmlContent .= "</tr>";
			}
			
			echo $htmlContent;
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "insert"){
			if( (isset($_POST["tagName"]) ? $_POST["tagName"] != "" : false) &&
				(isset($_POST["tagDescription"]) ? $_POST["tagDescription"] != "" : false) ){
				
				/* Creation of a donationTier */
				$tag->setName($_POST["tagName"]);
				$tag->setDescription($_POST["tagDescription"]);
				$tag->save();
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "update"){
			if( (isset($_POST["tagId"]) ? $_POST["tagId"] != "" : false) &&
				(isset($_POST["tagName"]) ? $_POST["tagName"] != "" : false) &&
				(isset($_POST["tagDescription"]) ? $_POST["tagDescription"] != "" : false) ){
				
				/* Update of donationTier information */
				$object = $tag->setId(intval($_POST["tagId"]));
				if($object != false)
					$tag = $object;
				$tag->setName($_POST["tagName"]);
				$tag->setDescription($_POST["tagDescription"]);
				$tag->save();
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "delete"){
			if(isset($_POST["tagIdList"]) && $_POST["tagIdList"] != ""){
				/* Delete tag */
				$tagIdList = explode(",", $_POST["tagIdList"]);
				
				for($i = 0 ; $i < count($tagIdList) ; $i++){
					/* Deletion of the tag */
					$object = $tag->setId($tagIdList[$i]);
					if($object != false)
						$tag = $object;
					$tag->delete();
				}
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm"){
			$htmlContent = "";
			
			if(isset($_POST["tagId"]) && $_POST["tagId"] != ""){
				$object = $tag->setId(intval($_POST["tagId"]));
				if($object != false)
					$tag = $object;
			}
			
			$htmlContent .= "<form class='form'>";

            /* Header */
            $htmlContent .= "<div class='field-row'>";
            $htmlContent .= "<div class='field'>";
            $htmlContent .= "<h1>Paramétrage de la catégorie : " . $tag->getName() . "</h1>";
            $htmlContent .= "</div>";
            $htmlContent .= "</div>";

            /* Separator */
            $htmlContent .= "<div class='field-row'>";
            $htmlContent .= "<hr>";
            $htmlContent .= "</div>";

            /* Name field */
            $htmlContent .= "<div class='field-row'>";
            $htmlContent .= "<div class='field'>";
            $htmlContent .= "<label>Nom</label>";
            $htmlContent .= "<input id='input-name' class='input' type='text' name='name' value='" . $tag->getName() . "'>";
            $htmlContent .= "</div>";
            $htmlContent .= "</div>";

            /* Description field */
            $htmlContent .= "<div class='field-row'>";
            $htmlContent .= "<div class='field'>";
            $htmlContent .= "<label>Description</label>";
            $htmlContent .= "<input id='input-description' class='input' type='text' name='description' value='" . $tag->getDescription() . "'>";
            $htmlContent .= "</div>";
            $htmlContent .= "</div>";

            /* cta */
            $htmlContent .= "<div class='field-cta'>";
            $htmlContent .= "<input class='btn-form btn-form-cancel' onclick='closeForm()' type='button' value='Annuler'>";
			
			if($tag->getId() != null){
				$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $tag->getId() . "'>";
				$htmlContent .= "<input class='btn-form btn-form-validate' onclick='updateTag()' type='button' value='Modifier'>";
			}else
				$htmlContent .= "<input class='btn-form btn-form-validate' onclick='insertTag()' type='button' value='Créer'>";
			$htmlContent .= "</div>";
			$htmlContent .= "</form>";
			
			echo $htmlContent;
		}else
			if(!isset($_POST["requestType"]))
				$view = new View("tag", "back");
	}

    public function api()
    {
        /* Reload the login session time if connexion status is true */
        if(Verificator::checkConnection())
            Verificator::reloadConnection();
        else
            header("Location: /login");

        /* Check access permission */
        if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_USER"))
            header("Location: /dashboard");

        if((isset($_POST["requestType"]) && $_POST["requestType"] == "updatePaypal") &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!empty($_POST["clientKey"]) && !empty($_POST["currency"]))
            {
                $config = yaml_parse_file("ini.yml");

                $clientKey  = addslashes($_POST["clientKey"]);
                $currency   = addslashes($_POST["currency"]);

                $config["paypal"]["clientKey"]     = $clientKey;
                $config["paypal"]["currency"]      = $currency;

                $configFile = fopen("ini.yml", "w");
                yaml_emit_file("ini.yml", $config);
                fclose($configFile);

                header("Location: /api-configuration");
            }
        }
        else if((isset($_POST["requestType"]) && $_POST["requestType"] == "updateEmail") &&
            (isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
        {
            if(!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["port"]))
            {
                $config = yaml_parse_file("ini.yml");

                $email      = addslashes($_POST["email"]);
                $password   = addslashes($_POST["password"]);
                $port       = addslashes($_POST["port"]);

                $config["phpmailer"]["email"]       = $email;
                $config["phpmailer"]["password"]    = $password;
                $config["phpmailer"]["port"]        = $port;

                $configFile = fopen("ini.yml", "w");
                yaml_emit_file("ini.yml", $config);
                fclose($configFile);

                header("Location: /api-configuration");
            }
        }

        $view = new View("api_configuration", "back");

        $token = md5(uniqid());
        $_SESSION["tokenForm"] = $token;
        $view->assign("tokenForm", $token);
    }
	
	public function forumManagement()
	{
		/* Get the connexion status */
		$isConnected = Verificator::checkConnection();
		
		/* Reload the login session time if connexion status is true */
		if($isConnected)
			Verificator::reloadConnection();
		
		/* Check access permission */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_FORUM"))
			header("Location: /dashboard");
		
		$forum = new Forum();
		$user = new UserModel();
		$tag = new Tag();
		
		/* Display users HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "display")
		{
			if(!$isConnected)
				echo "login";
			else
			{
				$forumList = $forum->select(["id", "idUser", "idTag", "title", "content", "creationDate", "updateDate"], []);
				$htmlContent = "";
				
				foreach($forumList as $forum)
				{
					$htmlContent .= "<tr>";
					$htmlContent .= "<td><input class='idForum' type='checkbox' name='" . $forum["id"] . "'></td>";
					$htmlContent .= "<td>" . $forum["id"] . "</td>";
					$htmlContent .= "<td id='" . $forum["id"] . "'>" . $forum["title"] . "</td>";
					$htmlContent .= "<td>" . $forum["content"] . "</td>";
					
					$object = $tag->setId(intval($forum["idTag"]));
					if($object != false){
						$tag = $object;
					}
					$htmlContent .= "<td>" . $tag->getName() . "</td>";
					
					$object = $user->setId(intval($forum["idUser"]));
					if($object != false){
						$user = $object;
					}
					$htmlContent .= "<td>" . $user->getFirstname() . " " . $user->getLastname() . "</td>";
					
					$htmlContent .= "<td>" . $forum["creationDate"] . "</td>";
					$htmlContent .= "<td>" . $forum["updateDate"] . "</td>";
					
					$htmlContent .= "<td><button class='btn btn-edit' onclick='openForumForm(\"" . $forum["id"] . "\")'>Editer</button></td>";
					$htmlContent .= "</tr>";
				}
				
				echo $htmlContent;
			}
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "insert" : false) &&
			(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
		{
			if(!$isConnected)
				echo "login";
			else{
				if( (isset($_POST["forumTitle"]) ? $_POST["forumTitle"] != "" : false) &&
					(isset($_POST["forumContent"]) ? $_POST["forumContent"] != "" : false) &&
					(isset($_POST["forumIdUser"]) ? $_POST["forumIdUser"] != "" : false) &&
					(isset($_POST["forumIdTag"]) ? $_POST["forumIdTag"] != "" : false)){
					/* Creation of a forum */
					$forum->setTitle($_POST["forumTitle"]);
					$forum->setContent($_POST["forumContent"]);
					$forum->setIdUser($_POST["forumIdUser"]);
					$forum->setIdTag($_POST["forumIdTag"]);
					$forum->creationDate();
					$forum->updateDate();
					$forum->save();
					
					$object = $forum->setId(intval($forum->getLastInsertId()));
					if($object != false){
						$forum = $object;
					}
					
				}
			}
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "update" : false) &&
			(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
		{
			if(!$isConnected)
				echo "login";
			else
			{
				if((isset($_POST["forumId"]) ? $_POST["forumId"] != "" : false)
					&& (isset($_POST["forumTitle"]) ? $_POST["forumTitle"] != "" : false)
					&& (isset($_POST["forumContent"]) ? $_POST["forumContent"] != "" : false)
					&& (isset($_POST["forumIdUser"]) ? $_POST["forumIdUser"] != "" : false)
					&& (isset($_POST["forumIdTag"]) ? $_POST["forumIdTag"] != "" : false))
				{
					/* Update of forum information */
					$object = $forum->setId(intval($_POST["forumId"]));
					
					if($object != false)
						$forum = $object;
					
					$forum->setTitle($_POST["forumTitle"]);
					$forum->setContent($_POST["forumContent"]);
					$forum->setIdUser($_POST["forumIdUser"]);
					$forum->setIdTag($_POST["forumIdTag"]);
					$forum->updateDate();
					$forum->save();
				}
			}
		}
		else if((isset($_POST["requestType"]) && $_POST["requestType"] == "delete"))
		{
			if(!$isConnected)
				echo "login";
			else
			{
				if (isset($_POST["forumIdList"]) && $_POST["forumIdList"] != "") {
					/* Delete forums */
					$forumIdList = explode(",", $_POST["forumIdList"]);
					
					for ($i = 0; $i < count($forumIdList); $i++) {
						/* Deletion of the forum */
						$object = $forum->setId($forumIdList[$i]);
						if ($object != false) {
							$forum = $object;
						}
						$forum->delete();
					}
				}
			}
		}
		
		else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm")
		{
			if(!$isConnected)
				echo "login";
			else
			{
				
				if(isset($_POST["forumId"]) && $_POST["forumId"] != ""){
					$object = $forum->setId(intval($_POST["forumId"]));
					if($object != false)
						$forum = $object;
				}
				
				$tagList = $tag->select(["id", "name"], []);
				$htmlContent = "";
				
				$object = $user->setId(intval($forum->getIdUser()));
				if($object != false){
					$user = $object;
				}
				
				$token = md5(uniqid());
				$_SESSION["tokenForm"] = $token;
				
				$htmlContent .= "<form class='form'>";
				
				// @CSRF
				$htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";
				
				if ($forum->getId() != null){
					$htmlContent .= "<h1>Modification du forum : n°" . $forum->getId() . "</h1>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<label>Titre</label>";
						$htmlContent .= "<input id='input-title' type='text' name='title' value='" . $forum->getTitle() . "'>";
						$htmlContent .= "<label>Contenu</label>";
						$htmlContent .= "<input id='input-content' type='text' name='content' value='" . $forum->getContent() . "'>";
						$htmlContent .= "<label>Auteur</label>";
						$htmlContent .= "<input type='text' value='" . $user->getFirstname() . " " . $user->getLastname() . "' disabled>";
						$htmlContent .= "<input id='input-idUser' type='hidden' name='idUser' value='" . $user->getId() . "'>";
					$htmlContent .= "</div>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<label for='input-idTag'>Catégorie</label>";
						$htmlContent .= "<select name='forumIdTag' id='input-idTag'>";
							foreach($tagList as $tag){
								$htmlContent .= "<option value='" . $tag["id"] . "'";
								$htmlContent .= ($tag["id"] == $forum->getIdTag()) ? "selected>" : ">";
								$htmlContent .= $tag["name"] . "</option>";
							}
						$htmlContent .= "</select>";
					$htmlContent .= "</div>";
					$htmlContent .= "<div class='section'>";
						$htmlContent .= "<input class='btn btn-delete' onclick='closeForumForm()' type='button' value='Annuler'>";
				}else
				{
					$htmlContent .= "<h1>Création d'un nouveau forum</h1>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<label>Titre du forum</label>";
						$htmlContent .= "<input id='input-title' type='text' name='title'>";
					$htmlContent .= "</div>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<label>Contenu du forum</label>";
						$htmlContent .= "<input id='input-content' type='text' name='content'>";
					$htmlContent .= "</div>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<select name='forumIdTag' id='input-idTag'>";
						foreach($tagList as $tag){
							$htmlContent .= "<option value='" . $tag["id"] . "'>" . $tag["name"] . "</option>";
						}
						$htmlContent .= "</select>";
					$htmlContent .= "</div>";
					$htmlContent .= "<input id='input-idUser' type='hidden' name='idUser' value='" . $_SESSION['id'] . "'>";
					$htmlContent .= "<div class='section'>";
						$htmlContent .= "<input class='btn btn-delete' onclick='closeForumForm()' type='button' value='Annuler'>";
				}
				
				if($forum->getId() != null)
				{
					$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $forum->getId() . "'>";
					$htmlContent .= "<input class='btn btn-validate' onclick='updateForum()' type='button' value='Modifier'>";
				}
				else
					$htmlContent .= "<input class='btn btn-validate' onclick='insertForum()' type='button' value='Créer'>";
				
				$htmlContent .= "</div>";
				}
				$htmlContent .= "</form>";
				echo $htmlContent;
			
		}else{
			if(!$isConnected)
				header("Location: /login");
			
			if(!isset($_POST["requestType"])){
				$view = new View("forumManagement", "back");
			}
		}
	}
	
	public function messageManagement()
	{
		/* Get the connexion status */
		$isConnected = Verificator::checkConnection();
		
		/* Reload the login session time if connexion status is true */
		if($isConnected)
			Verificator::reloadConnection();
		
		/* Check access permission */
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_FORUM"))
			header("Location: /dashboard");
		
		$message = new Message();
		$user = new UserModel();
		$forum = new Forum();
		
		/* Display users HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "display")
		{
			if(!$isConnected)
				echo "login";
			else
			{
				$messageList = $message->select(["id", "idUser", "idForum", "idMessage", "content", "creationDate", "updateDate"], []);
				$htmlContent = "";
				
				foreach($messageList as $message)
				{
					$htmlContent .= "<tr>";
						$htmlContent .= "<td><input id='" . $message['id'] . "' class='idMessage' type='checkbox' name='" . $message["id"] . "'></td>";
						$htmlContent .= "<td>" . $message["id"] . "</td>";
						
						$object = $user->setId(intval($message["idUser"]));
						if($object != false){
							$user = $object;
						}
						$htmlContent .= "<td>" . $user->getFirstname() . " " . $user->getLastname() . "</td>";
						
						$htmlContent .= "<td>" . $message["idForum"] . "</td>";
						$htmlContent .= "<td>" . $message["idMessage"] . "</td>";
						$htmlContent .= "<td>" . $message["content"] . "</td>";
						$htmlContent .= "<td>" . $message["creationDate"] . "</td>";
						$htmlContent .= "<td>" . $message["updateDate"] . "</td>";
						
						$htmlContent .= "<td><button class='btn btn-edit' onclick='openMessageForm(\"" . $message["id"] . "\")'>Editer</button></td>";
					$htmlContent .= "</tr>";
				}
				
				echo $htmlContent;
			}
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "insert" : false) &&
			(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
		{
			if(!$isConnected)
				echo "login";
			else{
				if( (isset($_POST["messageIdUser"]) ? $_POST["messageIdUser"] != "" : false) &&
					(isset($_POST["messageIdForum"]) ? $_POST["messageIdForum"] != "" : false) &&
					isset($_POST["messageIdMessage"]) &&
					(isset($_POST["messageContent"]) ? $_POST["messageContent"] != "" : false)){
					/* Creation of a forum */
					$message->setIdUser($_POST["messageIdUser"]);
					$message->setIdForum($_POST["messageIdForum"]);
					$message->setIdMessage(intval($_POST["messageIdMessage"]));
					$message->setContent($_POST["messageContent"]);
					$message->creationDate();
					$message->updateDate();
					$message->save();
					
					$object = $message->setId(intval($message->getLastInsertId()));
					if($object != false){
						$message = $object;
					}
				}
			}
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "update" : false) &&
			(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false))
		{
			if(!$isConnected)
				echo "login";
			else
			{
				if( (isset($_POST["messageId"]) ? $_POST["messageId"] != "" : false)
					&& (isset($_POST["messageIdUser"]) ? $_POST["messageIdUser"] != "" : false)
					&& (isset($_POST["messageIdForum"]) ? $_POST["messageIdForum"] != "" : false)
					&& (isset($_POST["messageIdMessage"]) ? $_POST["messageIdMessage"] != "" : false)
					&& (isset($_POST["messageContent"]) ? $_POST["messageContent"] != "" : false)){
					/* Update of message information */
					$object = $message->setId(intval($_POST["messageId"]));
					if($object != false)
						$message = $object;
					
					$message->setIdUser($_POST["messageIdUser"]);
					$message->setIdForum($_POST["messageIdForum"]);
					$message->setIdMessage(intval($_POST["messageIdMessage"]));
					$message->setContent($_POST["messageContent"]);
					$message->updateDate();
					$message->save();
				}
			}
		}
		else if((isset($_POST["requestType"]) && $_POST["requestType"] == "delete"))
		{
			if(!$isConnected)
				echo "login";
			else
			{
				if (isset($_POST["messageIdList"]) && $_POST["messageIdList"] != "") {
					/* Delete messages */
					$messageIdList = explode(",", $_POST["messageIdList"]);
					
					for ($i = 0; $i < count($messageIdList); $i++) {
						/* Deletion of the message */
						$object = $message->setId($messageIdList[$i]);
						if ($object != false) {
							$message = $object;
						}
						$message->delete();
					}
				}
			}
		}
		
		else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm")
		{
			if(!$isConnected)
				echo "login";
			else
			{
				if(isset($_POST["messageId"]) && $_POST["messageId"] != ""){
					$object = $message->setId(intval($_POST["messageId"]));
					if($object != false)
						$message = $object;
				}
				
				$htmlContent = "";
				
				$object = $user->setId(intval($message->getIdUser()));
				if($object != false){
					$user = $object;
				}
				
				$forumList = $forum->select(["id", "title"], []);
				
				$token = md5(uniqid());
				$_SESSION["tokenForm"] = $token;
				
				$htmlContent .= "<form class='form'>";
				
				// @CSRF
				$htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";
				
				if ($message->getId() != null){
					$htmlContent .= "<h1>Modification du message : n°" . $message->getId() . "</h1>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<label>Contenu</label>";
						$htmlContent .= "<input id='input-content' type='text' name='content' value='" . $message->getContent() . "'>";
						$htmlContent .= "<input id='input-idUser' type='hidden' name='idUser' value='" . $message->getIdUser() . "'>";
						$htmlContent .= "<input id='input-idForum' type='hidden' name='idForum' value='" . $message->getIdForum() . "'>";
						$htmlContent .= "<input id='input-idMessage' type='hidden' name='idMessage' value='" . $message->getIdMessage() . "'>";
					$htmlContent .= "</div>";
					$htmlContent .= "<div class='section'>";
						$htmlContent .= "<input class='btn btn-delete' onclick='closeMessageForm()' type='button' value='Annuler'>";
				}
				else
				{
					$htmlContent .= "<h1>Création d'un nouveau message</h1>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<label>Contenu du message</label>";
						$htmlContent .= "<input id='input-content' type='text' name='content'>";
					$htmlContent .= "</div>";
					$htmlContent .= "<input id='input-idUser' type='hidden' name='idUser' value='" . $_SESSION['id'] . "'>";
					$htmlContent .= "<input id='input-idMessage' type='hidden' name='idUser'>";
					$htmlContent .= "<div class='field'>";
						$htmlContent .= "<select name='messageIdForum' id='input-idForum'>";
						foreach($forumList as $forum){
							$htmlContent .= "<option value='" . $forum["id"] . "'>" . $forum["title"] . "</option>";
						}
						$htmlContent .= "</select>";
					$htmlContent .= "</div>";
					$htmlContent .= "<div class='section'>";
						$htmlContent .= "<input class='btn btn-delete' onclick='closeMessageForm()' type='button' value='Annuler'>";
				}
				
				if($message->getId() != null)
				{
					$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $message->getId() . "'>";
					$htmlContent .= "<input class='btn btn-validate' onclick='updateMessage()' type='button' value='Modifier'>";
				}
				else
					$htmlContent .= "<input class='btn btn-validate' onclick='insertMessage()' type='button' value='Créer'>";
				
				$htmlContent .= "</div>";
				}
				$htmlContent .= "</form>";
				echo $htmlContent;
			
		}else{
			if(!$isConnected)
				header("Location: /login");
			
			if(!isset($_POST["requestType"])){
				$view = new View("messageManagement", "back");
			}
		}
	}
	
}