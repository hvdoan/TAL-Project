<?php
namespace App\Model;

use App\Core\Mail;
use App\Core\Sql;

class User extends Sql
{
    public $id = null;
    protected $idRole = null;
    protected $avatar = null;
    protected $firstname = null;
    protected $lastname = null;
    protected $email;
    protected $password;
    protected $token = null;
    protected $creationDate = null;
    protected $verifyAccount = null;
    protected $activeAccount = null;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return null|int
	 */
	public function getIdRole(): ?int
	{
		return $this->idRole;
	}

	/**
	 * @param null|int
	 */
	public function setIdRole(?int $idRole): void
	{
		$this->idRole = $idRole;
	}

    /**
     * @return null|string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param null|string
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return htmlspecialchars($this->lastname, ENT_QUOTES);
    }

    /**
     * @param null|string
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * length : 255
     */
    public function generateToken(): void
    {
        $this->token = substr(bin2hex(random_bytes(128)), 0, 255);
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    /**
     * @param string
     */
    public function creationDate(): void {
        $this->creationDate = date("Y-m-d");
    }

    /**
     * @return bool
     */
    public function getVerifyAccount(): bool
    {
        return $this->verifyAccount;
    }

    /**
     * @param bool
     */
    public function setVerifyAccount(bool $flag): void
    {
        $this->verifyAccount = (int)$flag;
    }

    /**
     * @return bool
     */
    public function getActiveAccount(): bool
    {
        return $this->activeAccount;
    }

    /**
     * @param bool
     * @return void
     */
    public function setActiveAccount(bool $flag): void
    {
        $this->activeAccount = (int)$flag;
    }
	
	/**
	 * @return void
	 */
	public function sendNotificationMail(Message $message, User $user): void
	{
		$actualURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$mail = new Mail();
		$mail->prepareContent($user->getEmail(), $user->getFirstname() . " vous avez une nouvelle réponse dans le forum", "Le contenu de cette réponse est : " . $message->getContent() . "<br>Vous pouvez vous rendre sur la page du forum avec ce <a href='" . $actualURL . "'> lien</a>", "Datant de : " . $message->getUpdateDate());
		$mail->send();
	}

    public function getRegisterForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"S'inscrire",
                "classForm"=>"",
                "classSubmit"=>"submit",
                "title"=>"Inscription",
            ],
            'inputs'=>[
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email",
                    "placeholder"=>"Votre email ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "error"=>"Email incorrect",
                    "unicity"=>"true",
                    "errorUnicity"=>"Email déjà en bdd",
                ],
                "password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe",
                    "placeholder"=>"Votre mot de passe ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdForm",
                    "error"=>"Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "label"=>"Confirmer Mot de passe",
                    "placeholder"=>"Confirmation ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdConfirmForm",
                    "confirm"=>"password",
                    "error"=>"Votre mot de passe de confirmation ne correspond pas",
                ],
                "firstname"=>[
                    "type"=>"text",
                    "label"=>"Prénom",
                    "placeholder"=>"Votre prénom ...",
                    "class"=>"inputForm",
                    "id"=>"firstnameForm",
                    "min"=>2,
                    "max"=>50,
                    "error"=>"Prénom incorrect"
                ],
                "lastname"=>[
                    "type"=>"text",
                    "label"=>"Nom",
                    "placeholder"=>"Votre nom ...",
                    "class"=>"inputForm",
                    "id"=>"lastnameForm",
                    "min"=>2,
                    "max"=>100,
                    "error"=>"Nom incorrect"
                ],
                "tokenForm"=>[
                    "type"=>"hidden",
                    "class"=>"hiddenToken",
                    "value"=>$_SESSION["tokenForm"]
                ]
            ]
        ];
    }

    public function getLoginForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Se connecter",
                "classForm"=>"",
                "classSubmit"=>"submit",
                "title"=>"Connexion",
                "pwdForget"=>true
            ],
            'inputs'=>[
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email",
                    "placeholder"=>"Votre email ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "error"=>"Email incorrect"
                ],
                "password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe",
                    "placeholder"=>"Votre mot de passe ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdForm"
                ],
                "tokenForm"=>[
                    "type"=>"hidden",
                    "class"=>"hiddenToken",
                    "value"=>$_SESSION["tokenForm"]
                ]
            ]
        ];
    }

    public function getUserSettingForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Enregistrer",
                "classForm"=>"formSetting",
                "classPartial"=>false,
                "classSubmit"=>"btn btn-validate",
                "title"=>"",
            ],
            'inputs'=>[
                "lastname"=>[
                    "type"=>"text",
                    "label"=>"Nom",
                    "placeholder"=>"Votre Nom ...",
                    "value"=>$this->getLastname(),
                    "class"=>"inputForm",
                    "id"=>"nomForm",
                    "error"=>"Nom incorrect"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "label"=>"Prénom",
                    "placeholder"=>"Votre Prénom ...",
                    "value"=>$this->getFirstname(),
                    "class"=>"inputForm",
                    "id"=>"prenomForm",
                    "error"=>"Prénom incorrect"
                ],
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email",
                    "placeholder"=>"Votre email ...",
                    "value"=>$this->getEmail(),
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "disabled"=>true,
                    "error"=>"Email incorrect"
                ],
                "password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe",
                    "placeholder"=>"Votre mot de passe ...",
                    "class"=>"inputForm",
                    "id"=>"pwdForm"
                ],
                "newpassword"=>[
                    "type"=>"password",
                    "label"=>"Nouveau Mot de passe",
                    "placeholder"=>"Nouveau mot de passe ...",
                    "class"=>"inputForm",
                    "id"=>"pwdConfirmForm",
                    "error"=>"Votre nouveau mot de passe n'est pas valide",
                ],
            ]
        ];
    }
  
    public function getForgotPasswordForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"M'envoyer un mail",
                "classForm"=>"formPwdForget",
                "classSubmit"=>"submit",
                "title"=>"Récupération du compte",
            ],
            'inputs'=>[
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email",
                    "placeholder"=>"Votre email ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "error"=>"Email incorrect"
                ],
                "tokenForm"=>[
                    "type"=>"hidden",
                    "class"=>"hiddenToken",
                    "value"=>$_SESSION["tokenForm"]
                ]
            ],
        ];
    }

    public function getResetPassword(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Changer mon mot de passe",
                "classForm"=>"formPwdForget",
                "classSubmit"=>"submit",
                "title"=>"Changement mot de passe",
            ],
            'inputs'=>[
                "password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe",
                    "placeholder"=>"Votre mot de passe ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdForm",
                    "error"=>"Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "label"=>"Confirmer Mot de passe",
                    "placeholder"=>"Confirmation ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdConfirmForm",
                    "confirm"=>"password",
                    "error"=>"Votre mot de passe de confirmation ne correspond pas",
                ]
            ]
        ];
    }
}