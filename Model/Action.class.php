<?php

namespace App\Model;

use App\Core\Sql;

class Action extends Sql
{
	protected $id	= null;
	protected $code	= null;

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
	public function getCode(): ?string
	{
		return $this->code;
	}

	/**
	 * @param null|string
	 */
	public function setCode(?string $code): void
	{
		$this->code = $code;
	}
}