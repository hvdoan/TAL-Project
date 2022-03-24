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
        $page   = new Page();

        if(isset($_POST["requestType"]) ? ($_POST["requestType"] == "update") : false)
        {
            if(isset($_POST["pageId"]) ? ($_POST["pageId"] != "") : false &&
                isset($_POST["data"]) ? ($_POST["data"] != "") : false)
            {
                /* Update of the page information */
                $page = $page->setId(intval($_POST["pageId"]));
                $page->setContent($_POST["data"]);
                var_dump($page);
                $page->save();
            }
        }
        else if(!isset($_POST["requestType"]))
        {
            $view   = new View("pageCreation", "back");

            if(isset($_GET["page"]))
            {
                $object = $page->setId(intval($_GET["page"]));

                if ($object != false)
                    $page = $object;
            }

            $view->assign("page", $page);
        }
    }
}