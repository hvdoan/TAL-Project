<?php

namespace App\Controller;

use App\Core\View;

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
}