<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Action;
use App\Model\Page;
use App\Model\Permission;
use App\Model\Role;
use App\Model\User as UserModel;

class Admin
{
    public function dashboard()
    {
        $view = new View("home", "back");
    }

	public function configuration()
	{
		echo "Ceci est un beau dashboard";
	}
	
	public function usermanagement()
	{
		$user = new User();
//		$usersList = [];
//		$usersIdList = $user->select(['id', 'idRole'], []);
//
//		for($i = 0 ; $i < count($usersIdList) ; $i++){
//			$user = new User();
//			$user = $user->setId($usersIdList[$i]['id']);
//			$user->setIdRole($usersIdList[$i]['idRole']);
//			$usersList[] = $user;
//		}
//
//		$view = new View("userManagement", "back");
//		$view->assign("usersList", $usersList);
		
		
		/* Display users HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "display"){
			$usersList = $user->select(["id", "lastname", "firstname", "email", "idRole"], []);
			$htmlContent = "";
			
			foreach($usersList as $user){
				$htmlContent .= "<tr>";
					$htmlContent .= "<td><input class='idUser' type='checkbox' name='" . $user["id"] . "'></td>";
					
					$htmlContent .= "<td id='" . $user["id"] . "'>" . $user["firstname"] . strtoupper($user["lastname"]) . "</td>";
					$htmlContent .= "<td>" . $user["email"] . "</td>";
					
					$htmlContent .= "<td><button class='btn' onclick='openForm(\"" . $user["id"] . "\")'>Editer</button></td>";
				$htmlContent .= "</tr>";
			}
			
			echo $htmlContent;
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "insert"){
			
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
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "update"){
			if((isset($_POST["userId"]) && $_POST["UserId"] != "")
				&& (isset($_POST["userFirstname"]) && $_POST["userFirstname"] != "")
				&& (isset($_POST["userLastname"]) && $_POST["userLastname"] != "")
				&& (isset($_POST["userEmail"]) && $_POST["userEmail"] != "")
				&& (isset($_POST["userIdRole"]) && $_POST["userIdRole"] != "")
				&& (isset($_POST["userPassword"]) && $_POST["userPassword"] != "")){
				
				/* Update of user information */
				$object = $user->setId(intval($_POST["userId"]));
				if($object != false){
					$user = $object;
				}
				$user->setFirstname($_POST["userFirstname"]);
				$user->setLastname($_POST["userLastname"]);
				$user->setEmail($_POST["userEmail"]);
				$user->setIdRole($_POST["userIdRole"]);
				$user->save();
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "delete"){
			if(isset($_POST["userIdList"]) && $_POST["userIdList"] == ""){
				/* Delete users */
				$userIdList = explode(",", $_POST["userIdList"]);
				
				for($i = 0 ; $i < count($userIdList) ; $i++){
					/* Deletion of the user */
					$object = $user->setId($userIdList[$i]);
					if($object != false){
						$user = $object;
					}
					$user->delete();
				}
			}
		}else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForm"){
			$role = new Role();
			$roleList = $role->select(["id", "name"], []);
			$htmlContent = "";
			
			if(isset($_POST["userId"]) && $_POST["userId"] != ""){
				$user = $user->setId(intval($_POST["userId"]));
			}
			
			$htmlContent .= "<form class='form'>";
			
			if($user->getId() != null){
				$htmlContent .= "<h1>Modification de l\'utilisateur : n°" . $user->getId() . " " . $user->getFirstname() . " " . strtoupper($user->getLastname()) . "</h1>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label>Nom</label>";
					$htmlContent .= "<input id='input-lastname' type='text' name='lastname' value='" . $user->getLastname() . "'>";
					$htmlContent .= "<label>Prénom</label>";
					$htmlContent .= "<input id='input-firstname' type='text' name='firstname' value='" . $user->getFirstname() . "'>";
					$htmlContent .= "<label>Email</label>";
					$htmlContent .= "<input id='input-email' type='text' name='email' value='" . $user->getEmail() . "'>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='field'>";
					$htmlContent .= "<label for='roles'>Rôles</label>";
					$htmlContent .= "<select name='input-idRole' id='roles'>";
					foreach($roleList as $role){
						$htmlContent .= "<option value='" . $role->getId() . "'>" . $role->getName() . "</option>";
					}
					$htmlContent .= "</select>";
				$htmlContent .= "</div>";
				
				$htmlContent .= "<input class='btn' onclick='closeForm()' type='button' value='Annuler'>";
				$htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $user->getId() . "'>";
				$htmlContent .= "<input class='btn' onclick='updateUser()' type='button' value='Modifier'>";
				
			}else{
				$htmlContent .= "<h1>Attention ! Vous n'avez pas sélectionner d'utilisateur</h1>";
			}
			
			$htmlContent .= "</form>";
			
			echo $htmlContent;
		}else{
			if(!isset($_POST["requestType"])){
				$view = new View("userManagement", "back");
			}
		}
	}

	public function managerole()
	{
        /* Format HTML structure for display role */
		$role = new Role();

		if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "display") : false)
		{
			$roleList		= $role->select(["id", "name", "description"], []);
			$htmlContent	= "";

			foreach ($roleList as $role)
			{
				$htmlContent .= "<tr>";

                if($role["name"] == "Utilisateur" || $role["name"] == "Administrateur")
                    $htmlContent .= "<td></td>";
                else
                    $htmlContent .= "<td><input class='idRole' type='checkbox' name='" . $role["id"] . "'></td>";

                $htmlContent .= "<td id='" . $role["id"] . "'>" . $role["name"] . "</td>";
                $htmlContent .= "<td>" . $role["description"] . "</td>";

                if($role["name"] == "Utilisateur" || $role["name"] == "Administrateur")
                    $htmlContent .= "<td></td>";
                else
                    $htmlContent .= "<td><button class='btn' onclick='openForm(\"" . $role["id"] . "\")'>Editer</button></td>";

                $htmlContent .= "</tr>";
			}

			echo $htmlContent;
		}
		else if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "insert") : false)
		{
			if(isset($_POST["roleName"]) ? ($_POST["roleName"] != "") : false &&
				isset($_POST["roleDescription"]) ? ($_POST["roleDescription"] != "") : false &&
				isset($_POST["actionList"]))
			{
                /* Creation of the role */
				$role->setName($_POST["roleName"]);
				$role->setDescription($_POST["roleDescription"]);
				$role->save();
				$role = $role->setId($role->getLastInsertId());

                /* Creation of permissions related to the role */
				$actionList = explode(",", $_POST["actionList"]);

				for($i = 0; $i < count($actionList); $i++)
				{
					$permission = new Permission();
					$permission->setIdRole($role->getId());
					$permission->setIdAction(intval($actionList[$i]));
					$permission->save();
				}
			}
		}
        else if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "update") : false)
        {
            if(isset($_POST["roleId"]) ? ($_POST["roleId"] != "") : false &&
                isset($_POST["roleName"]) ? ($_POST["roleName"] != "") : false &&
                isset($_POST["roleDescription"]) ? ($_POST["roleDescription"] != "") : false &&
                isset($_POST["actionList"]))
            {
                /* Update of the role information */
                $role = $role->setId(intval($_POST["roleId"]));
                $role->setName($_POST["roleName"]);
                $role->setDescription($_POST["roleDescription"]);
                $role->save();

                /* Removal of role-related permissions */
                $permission = new Permission();
                $permissionList = $permission->select(["id"], ["idRole" => $role->getId()]);

                for($j = 0; $j < count($permissionList); $j++)
                {
                    $permission = $permission->setId($permissionList[$j]["id"]);
                    $permission->delete();
                }

                /* Recreate updated permissions related to the role */
                $actionList = explode(",", $_POST["actionList"]);

                for($i = 0; $i < count($actionList); $i++)
                {
                    $permission = new Permission();
                    $permission->setIdRole($role->getId());
                    $permission->setIdAction(intval($actionList[$i]));
                    $permission->save();
                }
            }
        }
		else if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "delete") : false)
		{
            /* Processing of role deletion */
			$roleIdList = explode(",", $_POST["roleIdList"]);

			for($i = 0; $i < count($roleIdList); $i++)
			{
				$permission		= new Permission();
				$permissionList = $permission->select(["id"], ["idRole" => $roleIdList[$i]]);

                /* Removal of role-related permissions */
				for($j = 0; $j < count($permissionList); $j++)
				{
					$permission = $permission->setId($permissionList[$j]["id"]);
					$permission->delete();
				}

                /* Deletion of the role */
				$role = $role->setId($roleIdList[$i]);
				$role->delete();
			}
		}
		else if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "openForm") : false)
		{
			$action			= new Action();
			$actionList		= $action->select(["id", "code", "description"], []);
			$htmlContent	= "";
			$permissionList = [];

			if($_POST["roleId"] != "")
			{
				$role = $role->setId(intval($_POST["roleId"]));
			}

			$htmlContent .= "<form class='form'>";

			if($role->getId() != null)
			{
				$permission		= new Permission();
				$permissionList	= $permission->select(["idAction"], ["idRole" => $role->getId()]);

				$htmlContent	.= "<h1>Modification du rôle : " . $role->getName() . "</h1>";
				$htmlContent	.= "<div class='field'>";
				$htmlContent	.= "<label>Nom du rôle</label>";
				$htmlContent	.= "<input id='input-name' type='text' name='name' value='" . $role->getName() . "'>";
				$htmlContent	.= "</div>";
				$htmlContent	.= "<div class='field'>";
				$htmlContent	.= "<label>Description</label>";
				$htmlContent	.= "<input id='input-description' type='text' name='description' value='" . $role->getDescription() . "'>";
				$htmlContent	.= "</div>";
			}
			else
			{
				$htmlContent	.= "<h1>Création d'un nouveau rôle</h1>";
				$htmlContent	.= "<div class='field'>";
				$htmlContent	.= "<label>Nom du rôle</label>";
				$htmlContent	.= "<input id='input-name' type='text' name='name'>";
				$htmlContent	.= "</div>";
				$htmlContent	.= "<div class='field'>";
				$htmlContent	.= "<label>Description</label>";
				$htmlContent	.= "<input id='input-description' type='text' name='description'>";
				$htmlContent	.= "</div>";
			}

			for($i = 0; $i < count($actionList); $i++)
			{
				$htmlContent	.= "<div class='field'>";
				$htmlContent	.= "<label>" . $actionList[$i]["description"] . "</label>";
				$isFind			= false;

				for($j = 0; $j < count($permissionList) && !$isFind; $j++)
				{
					if (in_array($actionList[$i]["id"], $permissionList[$j]))
						$isFind = true;
				}

				if($isFind)
				{
					$htmlContent .= "<label>Autoriser</label>";
					$htmlContent .= "<input class='input-permission' type='radio' name='" . $actionList[$i]["id"] . "' value='1' checked>";
					$htmlContent .= "<label>Refuser</label>";
					$htmlContent .= "<input type='radio' name='" . $actionList[$i]["id"] . "' value='0'>";
				}
				else
				{
					$htmlContent .= "<label>Autoriser</label>";
					$htmlContent .= "<input class='input-permission' type='radio' name='" . $actionList[$i]["id"] . "' value='1'>";
					$htmlContent .= "<label>Refuser</label>";
					$htmlContent .= "<input type='radio' name='" . $actionList[$i]["id"] . "' value='0' checked>";
				}
				$htmlContent .= "</div>";
			}

			$htmlContent .= "<input class='btn' onclick='closeForm()' type='button' value='Annuler'>";

			if($role->getId() != null)
            {
                $htmlContent .= "<input id='input-id' type='hidden' name='id' value='" . $role->getId() . "'>";
                $htmlContent .= "<input class='btn' onclick='updateRole()' type='button' value='Modifier'>";
            }
			else
				$htmlContent .= "<input class='btn' onclick='insertRole()' type='button' value='Créer'>";
			$htmlContent .= "</form>";

			echo $htmlContent;
		}
		else if(!isset($_POST["requestType"]))
		{
			$view = new View("roleManagement", "back");
		}
	}

    public function managepage()
    {
        /* Format HTML structure for display page */
        $page = new Page();

        if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "display") : false)
        {
            $pageList		= $page->select(["id", "idUser", "uri", "description"], []);
            $htmlContent	= "";

            foreach ($pageList as $page)
            {
                $user = new UserModel();
                $user = $user->setId(intval($page["idUser"]));

                $htmlContent .= "<tr>";
                $htmlContent .= "<td><input class='idRole' type='checkbox' name='" . $page["id"] . "'></td>";
                $htmlContent .= "<td>" . $user->getLastname() . " " . $user->getFirstname() . "</td>";
                $htmlContent .= "<td>" . $page["uri"] . "</td>";
                $htmlContent .= "<td>" . $page["description"] . "</td>";
                $htmlContent .= "<td>";
                $htmlContent .= "<a class='btn' href='/pageCreation?page=" . $page["id"] . "'>Editer</a>";
                $htmlContent .= "</td>";
                $htmlContent .= "</tr>";
            }

            echo $htmlContent;
        }
        else if(!isset($_POST["requestType"]))
        {
            $view = new View("pageManagement", "back");
        }
    }

    public function creationpage()
    {
        $isNew  = true;
        $view   = new View("pageCreation", "back");
        $page   = new Page();

        if(isset($_GET["page"]))
            $page = $page->setId(intval($_GET["page"]));

        $view->assign("page", $page);

    if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "update") : false)
    {
        if(isset($_POST["roleId"]) ? ($_POST["roleId"] != "") : false &&
        isset($_POST["roleName"]) ? ($_POST["roleName"] != "") : false &&
        isset($_POST["roleDescription"]) ? ($_POST["roleDescription"] != "") : false &&
            isset($_POST["actionList"]))
        {
            /* Update of the role information */
            $role = $role->setId(intval($_POST["roleId"]));
            $role->setName($_POST["roleName"]);
            $role->setDescription($_POST["roleDescription"]);
            $role->save();

            /* Removal of role-related permissions */
            $permission = new Permission();
            $permissionList = $permission->select(["id"], ["idRole" => $role->getId()]);

            for($j = 0; $j < count($permissionList); $j++)
            {
                $permission = $permission->setId($permissionList[$j]["id"]);
                $permission->delete();
            }

            /* Recreate updated permissions related to the role */
            $actionList = explode(",", $_POST["actionList"]);

            for($i = 0; $i < count($actionList); $i++)
            {
                $permission = new Permission();
                $permission->setIdRole($role->getId());
                $permission->setIdAction(intval($actionList[$i]));
                $permission->save();
            }
        }
    }
    }
}