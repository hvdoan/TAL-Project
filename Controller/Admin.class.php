<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User;

class Admin{
	
	public function dashboard()
	{
		echo "Ceci est un beau dashboard";
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
}