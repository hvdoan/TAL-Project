<?php

namespace App\Core;

abstract class Sql
{
    private $pdo;
    private $table;

    public function __construct()
    {
        //Se connecter à la bdd
        //il faudra mettre en place le singleton
        try{
            $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
                ,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
        }catch (\Exception $e){
            die("Erreur SQL : ".$e->getMessage());
        }

        //Si l'id n'est pas null alors on fait un update sinon on fait un insert
        $calledClassExploded = explode("\\",get_called_class());
        $this->table = DBPREFIXE.end($calledClassExploded);

    }

    /**
     * @param int $id
     */
    public function setId(?int $id): object
    {
        $sql = "SELECT * FROM ".$this->table." WHERE idUser = ".$id;
        $query = $this->pdo->query($sql);
        return $query->fetchObject(get_called_class());
    }

    public function save()
    {
        $columns = get_object_vars($this);
        $columns = array_diff_key($columns, get_class_vars(get_class()));

        if($this->getId() == null)
        {
            $sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($columns)).") 
            		    VALUES ( :".implode(",:",array_keys($columns)).")";
        }
        else
        {
            $update = [];
            foreach ($columns as $column=>$value)
                $update[] = $column." = :".$column;
          
            $sql = "UPDATE ".$this->table." SET ".implode(",",$update)." WHERE idUser = ".$this->getId() ;

        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( $columns );
    }
	
    public function delete()
    {
        $sql = "DELETE FROM " . $this->table . " WHERE idUser=" . $this->getId();
        $queryPrepared = $this->pdo->query($sql);
    }

    public function select(array $values,array $params)
    {
        $calledClassExploded = explode("\\",get_called_class());
        $table = strtolower(DBPREFIXE.end($calledClassExploded));

        $sql = "SELECT ".implode(", ", $values)." FROM ".$table." WHERE ";

        foreach ($params as $key => $values) {
            $sql .= $key." = :".$key." AND ";
        }

        $sql = substr($sql,0,-4);

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( $params );

        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }
}