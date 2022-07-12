<?php

namespace App\Core;

class Notification
{
    public static function CreateNotification($type, $message): void {
        $_SESSION['flash'][$type] = $message;
    }

    public static function displayNotifications(): void {
        if(isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $message) {
                echo "<div id='alert' class='alert alert-$type' onclick='removeNotification()'>".$message."</div>";
            }
            unset($_SESSION['flash']);
        }
    }
}