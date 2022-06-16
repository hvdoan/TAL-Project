<?php

namespace App\Controller;

use App\Core\Notification as NotificationCore;

class Notification
{
    public function display()
    {
        if(isset($_POST["requestType"]) ? $_POST["requestType"] != "display" : false)
            header("Location: /home");

        NotificationCore::displayNotifications();
    }
}