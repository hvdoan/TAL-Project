<?php

namespace App\Controller;

use App\Core\View;

class Main {

    public function home()
    {
        header("Location: /home");
    }


    public function contact()
    {
        $view = new View("contact");
    }

    public function generic($data)
    {
        $view = new View("generic");
        $view->assign("data", $data);
    }
}