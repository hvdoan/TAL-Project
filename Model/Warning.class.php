<?php

namespace App\Model;

use App\Core\Sql;

class Warning extends Sql{
	protected $id = null;
	protected $idMessage = null;
	protected $idUser = null;
	protected $status = null;
	protected $creationDate = null;
	protected $updateDate = null;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getIdMessage()
	{
		return $this->idMessage;
	}
	
	public function setIdMessage($idMessage)
	{
		$this->idMessage = $idMessage;
	}
	
	/**
	 * @return null|int
	 */
	public function getIdUser(): ?int
	{
		return $this->idUser;
	}
	
	/**
	 * @param null|int
	 */
	public function setIdUser(?int $idUser): void
	{
		$this->idUser = $idUser;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
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