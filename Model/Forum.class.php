<?php

namespace App\Model;

use App\Core\Sql;

class Forum extends Sql{
	protected $id = null;
	protected $idUser = null;
	protected $idTag = null;
	protected $title = null;
	protected $content = null;
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
	public function getIdTag()
	{
		return $this->idTag;
	}
	
	/**
	 * @param null $idTag
	 */
	public function setIdTag($idTag): void
	{
		$this->idTag = $idTag;
	}
	
	/**
	 * @return null
	 */
	public function getTitle()
	{
		return htmlspecialchars($this->title, ENT_QUOTES);
	}
	
	/**
	 * @param null $title
	 */
	public function setTitle($title): void
	{
		$this->title = $title;
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