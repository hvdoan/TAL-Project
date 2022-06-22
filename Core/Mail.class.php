<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

require 'API/vendor/autoload.php';

class Mail
{
	private		$email;
	protected	$content;

	public function __construct()
	{
		try
        {
			$this->email = new PHPMailer(true);
			$this->prepareSetting();
		}
        catch (\Exception $e)
        {
			die("Erreur Mail : ".$e->getMessage());
		}
	}

	private function prepareSetting()
	{
		//Server settings
        $this->email->isSMTP();                                      	    //Send using SMTP
        $this->email->Host          = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->email->SMTPAuth      = true;                                 //Enable SMTP authentication
        $this->email->AuthType      = 'XOAUTH2';                            //Set AuthType to use XOAUTH2
        $this->email->Username      = PHPMAILEREMAIL;                       //SMTP username
		$this->email->Password      = PHPMAILERPASSWORD;                    //SMTP password
		$this->email->SMTPSecure    = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
		$this->email->Port          = PHPMAILERPORT;                        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $refreshToken = "1//09uxhTVC1SksrCgYIARAAGAkSNwF-L9IrJ0_56VWk1K8WADEpMqBW-sPvvDBmHWOJrx4hkosazQkJrkxIOckF267V6d8NR-kIdWI";

        $provider = new Google(
            [
                'clientId' => PHPMAILERCLIENTID,
                'clientSecret' => PHPMAILERCLIENTSECRET
            ]
        );

        $this->email->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => PHPMAILERCLIENTID,
                    'clientSecret' => PHPMAILERCLIENTSECRET,
                    'refreshToken' => PHPMAILERTOKEN,
                    'userName' => PHPMAILEREMAIL
                ]
            )
        );

		//Recipients
		$this->email->setFrom('no-reply@tal.com', 'Admin');

		//Content
		$this->email->isHTML(true);                                  //Set email format to HTML
	}

	public function prepareContent($recipient, $subject, $content, $altContent)
	{
		$this->email->addAddress($recipient);
		$this->email->Subject = $subject;
		$this->email->Body    = $content;
		$this->email->AltBody = $altContent;
	}

	public function send()
	{
		try
		{
			$this->email->send();
		}
		catch(Exception $e)
		{
			die("Erreur Mail : ".$e->getMessage());
		}
	}
}