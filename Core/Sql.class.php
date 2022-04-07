<?php

namespace App\Core;

abstract class Sql
{
	private $pdoInstance;
	private $table;

	public function __construct()
	{
		$this->pdoInstance = PDO::getIntance();

		//Si l'id n'est pas null alors on fait un update sinon on fait un insert
		$calledClassExploded = explode("\\",get_called_class());
		$this->table = DBPREFIXE.ucwords(end($calledClassExploded));
	}

	/**
	 * @param int|null $id
	 *
	 * @return false|mixed|object
	 */
	public function setId(?int $id)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE id = ".$id;
		$query = $this->pdoInstance->getPDO()->query($sql);

        return $query->fetchObject(get_called_class());
	}

	/**
	 * @return void
	 */
	public function save()
	{
		$columns = get_object_vars($this);
		$columns = array_diff_key($columns, get_class_vars(get_class()));

		if($this->getId() == null){
			$sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($columns)).") VALUES ( :".implode(",:",array_keys($columns)).")";
		}else{
			$update = [];
			foreach ($columns as $column=>$value)
				$update[] = $column." = :".$column;

			$sql = "UPDATE ".$this->table." SET ".implode(",",$update)." WHERE id = ".$this->getId();
		}

		$queryPrepared = $this->pdoInstance->getPDO()->prepare($sql);
		$queryPrepared->execute( $columns );
	}

	/**
	 * @return void
	 */
	public function delete()
	{
		$sql = "DELETE FROM " . $this->table . " WHERE id=" . $this->getId();
		$queryPrepared = $this->pdoInstance->getPDO()->query($sql);
	}

	/**
	 * @param array $values
	 * @param array $params
	 *
	 * @return bool|array
	 */
	public function select(array $values,array $params)
	{
		$sql = "SELECT ".implode(", ", $values)." FROM ".$this->table." WHERE ";

		foreach ($params as $key => $values) {
			$sql .= $key." = :".$key." AND ";
		}

		$sql = substr($sql,0,-4);

		$queryPrepared = $this->pdoInstance->getPDO()->prepare($sql);
		$queryPrepared->execute( $params );

		return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * @return bool|string
	 */
	public function getLastInsertId()
	{
		return $this->pdoInstance->getPDO()->lastInsertId();
	}
}
