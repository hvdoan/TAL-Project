<?php

namespace App\Model;

use App\Core\Sql;

class Rate extends Sql{
	protected $id = null;
	protected $idUser = null;
	protected $rate = null;
	protected $description = null;
	protected $creationDate = null;
	protected $updateDate = null;
	
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
	public function getIdUser()
	{
		return $this->idUser;
	}
	
	/**
	 * @param null $idUser
	 */
	public function setIdUser($idUser): void
	{
		$this->idUser = $idUser;
	}
	
	/**
	 * @return null
	 */
	public function getRate()
	{
		return $this->rate;
	}
	
	/**
	 * @param null $rate
	 */
	public function setRate($rate): void
	{
		$this->rate = $rate;
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
		$this->description = htmlspecialchars(addslashes($description));
	}
	
	/**
	 * @return null
	 */
	public function getCreationDate()
	{
		return $this->creationDate;
	}
	
	/**
	 * @param string
	 */
	public function creationDate(): void {
		$this->creationDate = date("Y-m-d H:i:s");
	}
	
	/**
	 * @return null
	 */
	public function getUpdateDate()
	{
		return $this->updateDate;
	}
	
	/**
	 * @param string
	 */
	public function updateDate(): void {
		$this->updateDate = date("Y-m-d H:i:s");
	}
}