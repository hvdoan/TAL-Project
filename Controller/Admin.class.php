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
//		$user = new User();
//		$usersList = $user->select();
		
		$view = new View("userManagement", "back");
//		$view->assign("usersList", $usersList);
	}
}