<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Action;
use App\Model\Permission;
use App\Model\Role;

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
						$htmlContent .= "<td><button onclick='openForm(\"" . $role["id"] . "\")'>Editer</button></td>";
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
				$role->setName($_POST["roleName"]);
				$role->setDescription($_POST["roleDescription"]);
				$role->save();
				$role = $role->setId($role->getLastInsertId());

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
			$roleIdList = explode(",", $_POST["roleIdList"]);

			for($i = 0; $i < count($roleIdList); $i++)
			{
				$permission		= new Permission();
				$permissionList = $permission->select(["id"], ["idRole" => $roleIdList[$i]]);

				for($j = 0; $j < count($permissionList); $j++)
				{
					$permission = $permission->setId($permissionList[$j]["id"]);
					$permission->delete();
				}

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

				if ($isFind)
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
				$htmlContent .= "<input class='btn' onclick='updateRole()' type='button' value='Modifier'>";
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
}