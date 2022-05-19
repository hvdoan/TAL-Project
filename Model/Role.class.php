<?php

namespace App\Model;

use App\Core\Sql;

class Role extends Sql
{
	protected $id			= null;
	protected $name			= null;
	protected $description	= null;

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
	 * @return null|string
	 */
	public function getName(): ?string
	{
		return htmlspecialchars($this->name, ENT_QUOTES);
	}

	/**
	 * @param null|string
	 */
	public function setName(?string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return null|string
	 */
	public function getDescription(): ?string
	{
		return htmlspecialchars($this->description, ENT_QUOTES);
	}

	/**
	 * @param null|string
	 */
	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}

	public function getAddRoleForm(): array
	{
		return [
			"config"=>[
				"method"=>"POST",
				"action"=>"",
				"submit"=>"Ajouter"
			],
			'inputs'=>[
				"name"=>[
					"type"=>"text",
					"placeholder"=>"Nom du rôle",
					"required"=>true,
					"class"=>"inputForm",
					"id"=>"nameForm",
					"error"=>"Nom incorrect",
					"unicity"=>"true",
					"errorUnicity"=>"Nom déjà en bdd",
				],
				"password"=>[
					"type"=>"password",
					"placeholder"=>"Votre mot de passe ...",
					"required"=>true,
					"class"=>"inputForm",
					"id"=>"pwdForm",
					"error"=>"Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
				],
				"passwordConfirm"=>[
					"type"=>"password",
					"placeholder"=>"Confirmation ...",
					"required"=>true,
					"class"=>"inputForm",
					"id"=>"pwdConfirmForm",
					"confirm"=>"password",
					"error"=>"Votre mot de passe de confirmation ne correspond pas",
				],
				"firstname"=>[
					"type"=>"text",
					"placeholder"=>"Votre prénom ...",
					"class"=>"inputForm",
					"id"=>"firstnameForm",
					"min"=>2,
					"max"=>50,
					"error"=>"Prénom incorrect"
				],
				"lastname"=>[
					"type"=>"text",
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
}