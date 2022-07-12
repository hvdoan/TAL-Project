<?php

namespace App\Core;

use App\Core\QueryBuilder;

class MySqlBuilder implements QueryBuilder
{
    protected $query;
    private $params;
    private $lastParamWhere;

    public function init() {
        $this->query = new \StdClass;
    }

    public function insert(string $table, array $columns, array $values): QueryBuilder
    {
        $this->init();

        $this->query->base = "INSERT INTO " . DBPREFIXE.$table . " (" . implode(',', $columns) . ") VALUES ( :" . implode(', :', $columns) . ")";
        for ($i = 0; $i < sizeof($columns); $i++)
            $this->params[$columns[$i]] = $values[$i];
        return $this;
    }

    public function update(string $table, array $columns, array $values): QueryBuilder
    {
        $this->init();

        $update = [];
        foreach ($columns as $column=>$value)
            $update[] = $value." = :".$value;

        $this->query->base = "UPDATE " . DBPREFIXE.$table . " SET " . implode(", ", $update);
        for ($i = 0; $i < sizeof($columns); $i++)
            $this->params[$columns[$i]] = $values[$i];
        return $this;
    }

    public function select2(string $table, array $columns): QueryBuilder
    {
        $this->init();

        $this->query->base = "SELECT " . implode(', ', $columns) . " FROM " . DBPREFIXE.$table;
        return $this;
    }

    public function delete2(string $table): QueryBuilder
    {
        $this->init();

        $this->query->base = "DELETE FROM " . DBPREFIXE.$table;
        return $this;
    }

    public function where(string $column, string $value, string $operator = '=', string $type = 'AND'): QueryBuilder
    {
        $this->query->where[] = $column . ' ' . $operator . " :" . $column . ' '.trim($type).' ';
        $this->params[$column] = $value;
        $this->lastParamWhere = strlen(trim($type));
        return $this;
    }

    public function limit(int $from, int $offset): QueryBuilder
    {
        $this->query->limit = ' LIMIT ' . $from . ', ' . $offset;
        return $this;
    }

    public function orderBy(string $value, string $order = 'ASC'): QueryBuilder
    {
        $this->query->orderBy = ' ORDER BY ' . $value . ' ' . $order;
        return $this;
    }

    public function leftJoin(string $table1, string $table2, string $paramTable1, string $paramTable2): QueryBuilder
    {
        $this->query->leftJoin = ' LEFT JOIN ' . DBPREFIXE.$table1 . ' ON ' . DBPREFIXE.$table2 . '.' . $paramTable2 . ' = ' . DBPREFIXE.$table1 . '.' . $paramTable1;
        return $this;
    }

    public function getQuery()
    {
        $sql = $this->query->base;

        if (!empty($this->query->where)) {
            $sql .= " WHERE " . implode("", $this->query->where);
            $sql = substr($sql,0,-($this->lastParamWhere + 2));
        }

        if (isset($this->query->leftJoin)) {
            $sql .= " " . $this->query->leftJoin;
        }

        if (isset($this->query->orderBy)) {
            $sql .= " " . $this->query->orderBy;
        }

        if (isset($this->query->limit)) {
            $sql .= " " . $this->query->limit;
        }

        $sql .= ';';

        return $sql;
    }

    public function getParams()
    {
       return $this->params;
    }

    public function resetParams()
    {
       $this->params = [];
    }


}