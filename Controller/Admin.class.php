<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User;

class Admin
{

    public function dashboard()
    {
        echo "Ceci est un beau dashboard";
    }

	public function configuration()
	{
		echo "Ceci est un beau dashboard";
	}
	
	public function usermanagement(){
		$usersList = [];
		$user = new User();
		$usersIdList = $user->select(['id', 'idRole'], []);
		
		for($i = 0; $i < count($usersIdList); $i++){
			$user = new User();
			$user = $user->setId($usersIdList[$i]['id']);
			$user->setIdRole($usersIdList[$i]['idRole']);
			$usersList[] = $user;
		}
		
		$view = new View("userManagement", "back");
		$view->assign("usersList", $usersList);
	}
}