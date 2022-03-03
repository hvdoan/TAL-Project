<?php

namespace App\Controller;

use App\Core\View;
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
		$role		= new Role();
		$roleList	= $role->select(['id', "name", "description"], []);

		$view = new View("roleManagement", "back");
		$view->assign("roleList", $roleList);
	}
}