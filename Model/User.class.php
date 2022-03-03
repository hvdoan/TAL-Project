<?php
namespace App\Model;

use App\Core\Sql;

class User extends Sql
{
    protected $id = null;
    protected $idRole = null;
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
        return $this->lastname;
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
     */
    public function setActiveAccount(bool $flag): void
    {
        $this->activeAccount = (int)$flag;
    }

    public function getRegisterForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"S'inscrire",
                "classForm"=>"form",
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
                "classForm"=>"form",
                "classSubmit"=>"submit",
                "title"=>"Connexion",
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
                ]
            ]
        ];
    }
}