<?php

namespace App\Model;

use App\Core\Sql;

class Message extends Sql{
	protected $id = null;
	protected $idUser = null;
	protected $idForum = null;
	protected $idMessage = null;
	protected $content = null;
	protected $creationDate = null;
	protected $updateDate = null;
	
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
	
	/**
	 * @return null|int
	 */
	public function getIdForum(): ?int
	{
		return $this->idForum;
	}
	
	/**
	 * @param null|int
	 */
	public function setIdForum(?int $idForum): void
	{
		$this->idForum = $idForum;
	}
	
	/**
	 * @return null|int
	 */
	public function getIdMessage(): ?int
	{
		return $this->idMessage;
	}
	
	/**
	 * @param null|int
	 */
	public function setIdMessage(?int $idMessage): void
	{
		$this->idMessage = $idMessage;
	}
	
	/**
	 * @return null
	 */
	public function getContent()
	{
		return htmlspecialchars($this->content, ENT_QUOTES);
	}
	
	/**
	 * @param null $content
	 */
	public function setContent($content): void
	{
		$this->content = $content;
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
		$this->updateDate = date("Y-m-d");
	}
}