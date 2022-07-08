<?php

namespace App\Core;

use App\Core\QueryBuilder;

class MySqlBuilder implements QueryBuilder
{
    private $query;

    public function init() {
        $this->query = new \StdClass;
    }

    public function insert(string $table, array $columns, array $values): QueryBuilder
    {
        $this->init();

        $this->query->base = "INSERT INTO " . $table . " (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
        return $this;
    }

    public function select(string $table, array $columns): QueryBuilder
    {
        $this->init();

        $this->query->base = "SELECT " . implode(', ', $columns) . " FROM ".$table;
        return $this;
    }

    public function delete(string $table): QueryBuilder
    {
        $this->init();

        $this->query->base = "DELETE FROM " . $table;
        return $this;
    }


    public function wherePrepare(string $column, string $operator = '='): QueryBuilder
    {
        $this->query->where[] = ' ' . $column . $operator . ":" . $column ;
        return $this;
    }

    public function whereNoPrepare(string $column, string $value, string $operator = '='): QueryBuilder
    {
        $this->query->where[] = $column . $operator . "'" . $value ."'";
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
        $this->query->leftJoin = ' LEFT JOIN ' . $table1 . ' ON ' . $table2 . '.' . $paramTable2 . ' = ' . $table1 . '.' . $paramTable1;
        return $this;
    }

    public function getQuery()
    {
        $sql = $this->query->base;

        if (!empty($this->query->where)) {
            $sql .= " WHERE " . implode(" AND ", $this->query->where);
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


}