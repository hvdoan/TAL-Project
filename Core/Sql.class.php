<?php

namespace App\Core;

abstract class Sql extends MySqlBuilder
{
	private $pdoInstance;
	private $table;
	private $table2;

	public function __construct()
	{
		$this->pdoInstance = PDO::getIntance();

		//Si l'id n'est pas null alors on fait un update sinon on fait un insert
		$calledClassExploded = explode("\\",get_called_class());
		$this->table = DBPREFIXE.ucwords(end($calledClassExploded));
		$this->table2 = ucwords(end($calledClassExploded));
	}

	/**
	 * @param int|null $id
	 *
	 * @return false|mixed|object
	 */
	public function setId(?int $id)
	{
        $this->resetParams();
        $this->select2($this->table2, ['*'])->where('id', $id);
        $queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
        $queryPrepared->execute( $this->getParams() );

        return $queryPrepared->fetchObject(get_called_class());
	}

	/**
	 * @return void
	 */
	public function save()
	{
        $this->resetParams();

		$columns = get_object_vars($this);
		$columns = array_diff_key($columns, get_class_vars(get_class()));

		if($this->getId() == null){
            $this->insert($this->table2, array_keys($columns), array_values($columns));
		}else{
            $this->update($this->table2, array_keys($columns), array_values($columns))->where('id',$this->getId());
        }

		$queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
		$queryPrepared->execute( $this->getParams() );
	}

	/**
	 * @return void
	 */
	public function delete()
	{
        $this->resetParams();

        $this->delete2($this->table2)->where('id',$this->getId());
		$queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
        $queryPrepared->execute( $this->getParams() );
	}

	/**
	 * @param array $values
	 * @param array $params
	 *
	 * @return bool|array
	 */
	public function select(array $values, array $params)
	{
        $this->resetParams();

        $this->select2($this->table2, $values);
        foreach ($params as $key => $value) {
           $this->where($key, $value);
        }

		$queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
		$queryPrepared->execute( $this->getParams() );


		return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
	}

    public function selectLikeString(array $values, array $params, $searchString, $searchParam)
    {
        $this->resetParams();

        $this->select2($this->table2, $values);
        foreach ($searchParam as $param) {
            $this->where($param, '%'.$searchString.'%', 'LIKE', 'OR');
        }

        $queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
        $queryPrepared->execute( $this->getParams() );


        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getResult() {
        $queryPrepared = $this->pdoInstance->getPDO()->prepare($this->getQuery());
        $queryPrepared->execute( $this->getParams() );

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
