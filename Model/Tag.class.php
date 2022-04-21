<?php

namespace App\Model;

use App\Core\Sql;

class Tag extends Sql{
	protected $id = null;
	protected $name = null;
	protected $description = null;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * @return null
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return null
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param null $name
	 */
	public function setName($name): void
	{
		$this->name = $name;
	}
	
	/**
	 * @return null
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	 * @param null $description
	 */
	public function setDescription($description): void
	{
		$this->description = $description;
	}
}