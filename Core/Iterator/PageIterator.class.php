<?php

namespace App\Core\Iterator;

use App\Model\Page;

class PageIterator implements \Iterator
{
	private	$collection	= [];
	private	$position	= 0;

	public function loadCollectionFromDatabase()
	{
		$pageModel = new Page();

		$pages = $pageModel->select2("Page", ["id", "idUser", "uri", "description", "content", "dateModification"])
			->getResult();

		foreach($pages as $page)
		{
			$this->addPage($page["id"], $page["idUser"], $page["uri"], $page["description"], $page["content"], $page["dateModification"]);
		}
	}

	public function addPage($id, $idUser, $uri, $description, $content, $dateModification)
	{
		$page = new Page();

		$page->assign($idUser, $uri, $description, $content, $dateModification, $id);

		$this->collection[] = $page;
	}

	public function current()
	{
		return $this->collection[$this->position];
	}

	public function next()
	{
		$this->position++;
	}

	public function key()
	{
		return $this->position;
	}

	public function valid()
	{
		return isset($this->collection[$this->position]);
	}

	public function rewind()
	{
		$this->position = 0;
	}
}