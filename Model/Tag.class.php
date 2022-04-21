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
		return htmlspecialchars($this->name, ENT_QUOTES);
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
		return htmlspecialchars($this->description, ENT_QUOTES);
	}
	
	/**
	 * @param null $description
	 */
	public function setDescription($description): void
	{
		$this->description = $description;
	}
}