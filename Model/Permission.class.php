<?php

namespace App\Model;

use App\Core\Sql;

class Permission extends Sql
{
	protected $id		= null;
	protected $idRole	= null;
	protected $idAction	= null;

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
	public function getIdRole(): ?string
	{
		return $this->idRole;
	}

	/**
	 * @param null|string
	 */
	public function setIdRole(?string $idRole): void
	{
		$this->idRole = $idRole;
	}

	/**
	 * @return null|string
	 */
	public function getIdAction(): ?string
	{
		return $this->idAction;
	}

	/**
	 * @param null|string
	 */
	public function setIdAction(?string $idAction): void
	{
		$this->idAction = $idAction;
	}
}