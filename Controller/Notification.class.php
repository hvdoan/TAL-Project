<?php

namespace App\Controller;

use App\Core\Notification as NotificationCore;

class Notification
{
    public function notification()
    {
        if(isset($_POST["requestType"]) ? $_POST["requestType"] === "display" : false) {
            NotificationCore::displayNotifications();
        }

        if(isset($_POST["requestType"]) ? $_POST["requestType"] === "createNotification" : false) {
            NotificationCore::CreateNotification($_POST["type"],$_POST["message"]);
        }
    }
}