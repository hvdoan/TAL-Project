<?php

namespace App\Core;

abstract class Sql extends MySqlBuilder
{
	private $pdoInstance;
	private $table;
    private $query;

	public function __construct()
	{
		$this->pdoInstance = PDO::getIntance();

		//Si l'id n'est pas null alors on fait un update sinon on fait un insert
		$calledClassExploded = explode("\\",get_called_class());
		$this->table = DBPREFIXE.ucwords(end($calledClassExploded));
        $this->query = new MySqlBuilder();
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
			$sql = "INSERT INTO ".$this->table." (".implode(", ",array_keys($columns)).") VALUES ( :".implode(", :",array_keys($columns)).")";
		}else{
			$update = [];
			foreach ($columns as $column=>$value)
				$update[] = $column." = :".$column;

			$sql = "UPDATE ".$this->table." SET ".implode(", ",$update)." WHERE id = ".$this->getId();
		}

		$queryPrepared = $this->pdoInstance->getPDO()->prepare($sql);
		$queryPrepared->execute( $columns );
	}

	/**
	 * @return void
	 */
	/*public function delete()
	{
        $this->query->delete($this->table)->whereNoPrepare('id', $this->getId());

		//$sql = "DELETE FROM " . $this->table . " WHERE id=" . $this->getId();
		$queryPrepared = $this->pdoInstance->getPDO()->query($this->query->getQuery());
	}*/

	/**
	 * @param array $values
	 * @param array $params
	 *
	 * @return bool|array
	 */
	/*public function select(array $values, array $params, bool $left = false, $left1 = false )
	{
        $this->query->select($this->table, $values);

        foreach ($params as $key => $values) {
            $this->query->wherePrepare($key);
        }

        if ($left) {
            $this->query->leftJoin(DBPREFIXE .'User',  DBPREFIXE .'Log', 'id', 'idUser');
            $this->query->orderBy('time', 'DESC');
            $this->query->limit(0, 5);
        }

        if ($left1) {
            $this->query->leftJoin(DBPREFIXE .'User',  DBPREFIXE .'Message', 'id', 'idUser');
            $this->query->orderBy('creationDate', 'DESC');
            $this->query->limit(0, 5);
        }

        //echo $mySql->getQuery();

		$queryPrepared = $this->pdoInstance->getPDO()->prepare($this->query->getQuery());
		$queryPrepared->execute( $params );


		return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
	}*/

    public function fetchAll() {
        $queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
        $queryPrepared->execute( $params );


        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectLikeString(array $values, array $params, $searchString, $searchParam)
    {
        $query = "";

        if (count($params) == 0)
            $query .= " WHERE ";

        /* Build query */
        foreach ($searchParam as $param)
            $query .= $param . " LIKE '%" . $searchString . "%' OR ";

        /* Remove the last "AND" */
        $query = substr($query,0,-4);

        return $this->select($values, $params, $query);
    }

	/**
	 * @return bool|string
	 */
	public function getLastInsertId()
	{
		return $this->pdoInstance->getPDO()->lastInsertId();
	}
}
