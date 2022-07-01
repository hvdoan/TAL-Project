<?php

namespace App\Core;

class Logger {

    private static $instance = null;
    private $handle = null;

    private function __construct() {
        $this->handle = fopen('log/logFile.log', 'a+');
    }

    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new Logger();
        }

        return self::$instance;
    }

    public function writeLogLogin($userLastName, $userFirstName, $userId): void
    {
        fwrite($this->handle, "[". date("Y-m-d g:i:s") ."] Login user : " . $userLastName . " " . $userFirstName . " // id : " . $userId);
        fwrite($this->handle, PHP_EOL);
    }

    public function writeLogRegister($userLastName, $userFirstName, $userId): void
    {
        fwrite($this->handle, "[". date("Y-m-d g:i:s") ."] Register user : " . $userLastName . " " . $userFirstName . " // id : " . $userId);
        fwrite($this->handle, PHP_EOL);
    }

    public function writeLogMailSend($about): void
    {
        fwrite($this->handle, "[". date("Y-m-d g:i:s") ."] Email send / subject : " . $about);
        fwrite($this->handle, PHP_EOL);
    }

    public function writeLogNewMessage($userId, $content): void
    {
        fwrite($this->handle, "[". date("Y-m-d g:i:s") ."] New message from user id : " . $userId . " // content : " . $content);
        fwrite($this->handle, PHP_EOL);
    }
}