<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Model\Action;
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

                    if($user["id"] != $_SESSION["id"])
                        $htmlContent .= "<td><button class='btn btn-edit' onclick='openUserForm(\"" . $user["id"] . "\")'>Editer</button></td>";
                    else
                        $htmlContent .= "<td></td>";
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
                if((isset($_POST["userId"]) && $_POST["userId"] != "")
                    && (isset($_POST["userLastname"]) && $_POST["userLastname"] != "")
                    && (isset($_POST["userFirstname"]) && $_POST["userFirstname"] != "")
                    && (isset($_POST["userEmail"]) && $_POST["userEmail"] != "")
                    && (isset($_POST["userIdRole"]) && $_POST["userIdRole"] != ""))
                {
                    /* Update of user information */
                    $object = $user->setId(intval($_POST["userId"]));

                    if($object != false)
                        $user = $object;

                    $user->setFirstname($_POST["userFirstname"]);
                    $user->setLastname($_POST["userLastname"]);
                    $user->setEmail($_POST["userEmail"]);
                    $user->setIdRole(intval($_POST["userIdRole"]));
                    $user->save();
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
                    }
                }

                $token = md5(uniqid());
                $_SESSION["tokenForm"] = $token;

                $htmlContent .= "<form class='form'>";

                // @CSRF
                $htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";

                if ($user->getId() != null)
                {
                    $htmlContent .= "<h1>Modification de l'utilisateur : n°" . $user->getId() . " " . $user->getFirstname() . " " . strtoupper($user->getLastname()) . "</h1>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Nom</label>";
                    $htmlContent .= "<input id='input-lastname' type='text' name='lastname' value='" . $user->getLastname() . "'>";
                    $htmlContent .= "<label>Prénom</label>";
                    $htmlContent .= "<input id='input-firstname' type='text' name='firstname' value='" . $user->getFirstname() . "'>";
                    $htmlContent .= "<label>Email</label>";
                    $htmlContent .= "<input id='input-email' type='text' name='email' value='" . $user->getEmail() . "'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label for='input-idRole'>Rôles</label>";
                    $htmlContent .= "<select name='userIdRole' id='input-idRole'>";
                    foreach ($roleList as $role) {
                        $htmlContent .= "<option value='" . $role["id"] . "'";
                        $htmlContent .= ($role["id"] == $user->getIdRole()) ? "selected>" : ">";
                        $htmlContent .= $role["name"] . "</option>";
                    }
                    $htmlContent .= "</select>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='section'>";
                    $htmlContent .= "<input class='btn btn-delete' onclick='closeUserForm()' type='button' value='Annuler'>";
                    $htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $user->getId() . "'>";
                    $htmlContent .= "<input class='btn btn-validate' onclick='updateUser()' type='button' value='Modifier'>";
                    $htmlContent .= "</div>";

                } else {
                    $htmlContent .= "<h1>Attention ! Vous n'avez pas sélectionné d'utilisateur</h1>";
                }

                $htmlContent .= "</form>";

                echo $htmlContent;
            }
		}else{
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

                $token = md5(uniqid());
                $_SESSION["tokenForm"] = $token;

                $htmlContent .= "<form class='form'>";

                // @CSRF
                $htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";

                if ($role->getId() != null) {
                    $permission = new Permission();
                    $permissionList = $permission->select(["idAction"], ["idRole" => $role->getId()]);

                    $htmlContent .= "<h1>Modification du rôle : " . $role->getName() . "</h1>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Nom du rôle</label>";
                    $htmlContent .= "<input id='input-name' type='text' name='name' value='" . $role->getName() . "'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Description</label>";
                    $htmlContent .= "<input id='input-description' type='text' name='description' value='" . $role->getDescription() . "'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='fieldHeader'>";
                    $htmlContent .= "<label>Gestions</label>";
                    $htmlContent .= "<label>Autoriser</label>";
                    $htmlContent .= "<label>Refuser</label>";
                    $htmlContent .= "</div>";
                } else {
                    $htmlContent .= "<h1>Création d'un nouveau rôle</h1>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Nom du rôle</label>";
                    $htmlContent .= "<input id='input-name' type='text' name='name'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='field'>";
                    $htmlContent .= "<label>Description</label>";
                    $htmlContent .= "<input id='input-description' type='text' name='description'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='fieldHeader'>";
                    $htmlContent .= "<label>Gestions</label>";
                    $htmlContent .= "<label>Autoriser</label>";
                    $htmlContent .= "<label>Refuser</label>";
                    $htmlContent .= "</div>";
                }

                for ($i = 0; $i < count($actionList); $i++) {
                    $htmlContent .= "<div class='fieldRow'>";
                    $htmlContent .= "<label>" . $actionList[$i]["description"] . "</label>";
                    $isFind = false;

                    for ($j = 0; $j < count($permissionList) && !$isFind; $j++) {
                        if (in_array($actionList[$i]["id"], $permissionList[$j]))
                            $isFind = true;
                    }

                    if ($isFind) {
                        //					$htmlContent .= "<label>Autoriser</label>";
                        $htmlContent .= "<input class='input-permission' type='radio' name='" . $actionList[$i]["id"] . "' value='1' checked>";
                        //					$htmlContent .= "<label>Refuser</label>";
                        $htmlContent .= "<input type='radio' name='" . $actionList[$i]["id"] . "' value='0'>";
                    } else {
                        //					$htmlContent .= "<label>Autoriser</label>";
                        $htmlContent .= "<input class='input-permission' type='radio' name='" . $actionList[$i]["id"] . "' value='1'>";
                        //					$htmlContent .= "<label>Refuser</label>";
                        $htmlContent .= "<input type='radio' name='" . $actionList[$i]["id"] . "' value='0' checked>";
                    }
                    $htmlContent .= "</div>";
                }

                $htmlContent .= "<div class='section'>";
                $htmlContent .= "<input class='btn btn-delete' onclick='closeRoleForm()' type='button' value='Annuler'>";

                if ($role->getId() != null) {
                    $htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $role->getId() . "'>";
                    $htmlContent .= "<input class='btn btn-validate' onclick='updateRole()' type='button' value='Modifier'>";
                } else
                    $htmlContent .= "<input class='btn btn-validate' onclick='insertRole()' type='button' value='Créer'>";
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
                if((isset($_POST["donationTierName"]) && $_POST["donationTierName"] != "")
                    && (isset($_POST["donationTierDescription"]) && $_POST["donationTierDescription"] != "")
                    && (isset($_POST["donationTierPrice"]) && $_POST["donationTierPrice"] != "")){

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
                if((isset($_POST["donationTierId"]) && $_POST["donationTierId"] != "")
                    && (isset($_POST["donationTierName"]) && $_POST["donationTierName"] != "")
                    && (isset($_POST["donationTierDescription"]) && $_POST["donationTierDescription"] != "")
                    && (isset($_POST["donationTierPrice"]) && $_POST["donationTierPrice"] != "")){

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

                if($donationTier->getId() != null)
                {
                    $htmlContent .= "<h1>Modification du palier : n°" . $donationTier->getId() . " " . $donationTier->getName() . " " . "</h1>";
                    $htmlContent .= "<div class='field'>";
                        $htmlContent .= "<label>Nom</label>";
                        $htmlContent .= "<input id='input-name' type='text' name='name' value='" . $donationTier->getName() . "'>";
                        $htmlContent .= "<label>Description</label>";
                        $htmlContent .= "<input id='input-description' type='text' name='description' value='" . $donationTier->getDescription() . "'>";
                        $htmlContent .= "<label>Prix (en centimes)</label>";
                        $htmlContent .= "<input id='input-price' type='text' name='price' value='" . $donationTier->getPrice() . "'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='section'>";
                        $htmlContent .= "<input class='btn btn-delete' onclick='closeDonationForm()' type='button' value='Annuler'>";
                }
                else
                {
                    $htmlContent .= "<h1>Création d'un nouveau palier</h1>";
                    $htmlContent .= "<div class='field'>";
                        $htmlContent .= "<label>Nom du palier</label>";
                        $htmlContent .= "<input id='input-name' type='text' name='name'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='field'>";
                        $htmlContent .= "<label>Description du palier</label>";
                        $htmlContent .= "<input id='input-description' type='text' name='description'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='field'>";
                        $htmlContent .= "<label>Prix (en centimes)</label>";
                        $htmlContent .= "<input id='input-price' type='text' name='price'>";
                    $htmlContent .= "</div>";
                    $htmlContent .= "<div class='section'>";
                        $htmlContent .= "<input class='btn btn-delete' onclick='closeDonationForm()' type='button' value='Annuler'>";
                }

                if($donationTier->getId() != null)
                {
                    $htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $donationTier->getId() . "'>";
                    $htmlContent .= "<input class='btn btn-validate' onclick='updateDonationTier()' type='button' value='Modifier'>";
                }
                else
                    $htmlContent .= "<input class='btn btn-validate' onclick='insertDonationTier()' type='button' value='Créer'>";

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
		
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_DONATION_TIER"))
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
			if((isset($_POST["tagName"]) && $_POST["tagName"] != "")
				&& (isset($_POST["tagDescription"]) && $_POST["tagDescription"] != "")){
				
				/* Creation of a donationTier */
				$tag->setName($_POST["tagName"]);
				$tag->setDescription($_POST["tagDescription"]);
				$tag->save();
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "update"){
			if((isset($_POST["tagId"]) && $_POST["tagId"] != "")
				&& (isset($_POST["tagName"]) && $_POST["tagName"] != "")
				&& (isset($_POST["tagDescription"]) && $_POST["tagDescription"] != "")){
				
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
			
			if($tag->getId() != null){
				$htmlContent .= "<h1>Modification de la catégorie : n°" . $tag->getId() . " " . $tag->getName() . " " . "</h1>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Nom</label>";
					$htmlContent .= "<input id='input-name' type='text' name='name' value='" . $tag->getName() . "'>";
					$htmlContent .= "<label>Description</label>";
					$htmlContent .= "<input id='input-description' type='text' name='description' value='" . $tag->getDescription() . "'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='section'>";
					$htmlContent .= "<input class='btn btn-delete' onclick='closeForm()' type='button' value='Annuler'>";
			}else{
				$htmlContent .= "<h1>Création d'une nouvelle catégorie</h1>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Nom de la catégorie</label>";
					$htmlContent .= "<input id='input-name' type='text' name='name'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Description de la catégorie</label>";
					$htmlContent .= "<input id='input-description' type='text' name='description'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='section'>";
					$htmlContent .= "<input class='btn btn-delete' onclick='closeForm()' type='button' value='Annuler'>";
			}
			
			if($tag->getId() != null){
				$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $tag->getId() . "'>";
				$htmlContent .= "<input class='btn btn-validate' onclick='updateTag()' type='button' value='Modifier'>";
			}else
				$htmlContent .= "<input class='btn btn-validate' onclick='insertTag()' type='button' value='Créer'>";
			$htmlContent .= "</div>";
			$htmlContent .= "</form>";
			
			echo $htmlContent;
		}else
			if(!isset($_POST["requestType"]))
				$view = new View("tag", "back");
	}
	
	public function forum()
	{
		if(!Verificator::checkConnection())
			header("Location: /login");
		
		if(!Verificator::checkPageAccess($_SESSION["permission"], "MANAGE_DONATION_TIER"))
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
			if((isset($_POST["tagName"]) && $_POST["tagName"] != "")
				&& (isset($_POST["tagDescription"]) && $_POST["tagDescription"] != "")){
				
				/* Creation of a donationTier */
				$tag->setName($_POST["tagName"]);
				$tag->setDescription($_POST["tagDescription"]);
				$tag->save();
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "update"){
			if((isset($_POST["tagId"]) && $_POST["tagId"] != "")
				&& (isset($_POST["tagName"]) && $_POST["tagName"] != "")
				&& (isset($_POST["tagDescription"]) && $_POST["tagDescription"] != "")){
				
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
			
			if($tag->getId() != null){
				$htmlContent .= "<h1>Modification de la catégorie : n°" . $tag->getId() . " " . $tag->getName() . " " . "</h1>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Nom</label>";
					$htmlContent .= "<input id='input-name' type='text' name='name' value='" . $tag->getName() . "'>";
					$htmlContent .= "<label>Description</label>";
					$htmlContent .= "<input id='input-description' type='text' name='description' value='" . $tag->getDescription() . "'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='section'>";
					$htmlContent .= "<input class='btn btn-delete' onclick='closeForm()' type='button' value='Annuler'>";
			}else{
				$htmlContent .= "<h1>Création d'une nouvelle catégorie</h1>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Nom de la catégorie</label>";
					$htmlContent .= "<input id='input-name' type='text' name='name'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Description de la catégorie</label>";
					$htmlContent .= "<input id='input-description' type='text' name='description'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='section'>";
					$htmlContent .= "<input class='btn btn-delete' onclick='closeForm()' type='button' value='Annuler'>";
			}
			
			if($tag->getId() != null){
				$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $tag->getId() . "'>";
				$htmlContent .= "<input class='btn btn-validate' onclick='updateTag()' type='button' value='Modifier'>";
			}else
				$htmlContent .= "<input class='btn btn-validate' onclick='insertTag()' type='button' value='Créer'>";
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
}