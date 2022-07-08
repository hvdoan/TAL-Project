<?php

namespace App\Core;

interface QueryBuilder
{

    public function insert(string $table, array $columns, array $values): QueryBuilder;

    public function select(string $table, array $columns): QueryBuilder;

    public function delete(string $table): QueryBuilder;

    public function wherePrepare(string $column, string $operator = '='): QueryBuilder;

    public function whereNoPrepare(string $column, string $value, string $operator = '='): QueryBuilder;

    public function limit(int $from, int $offset): QueryBuilder;

    public function orderBy(string $value, string $order = 'ASC'): QueryBuilder;

    public function leftJoin(string $table1, string $table2, string $paramTable1, string $paramTable2): QueryBuilder;

    public function getQuery();
}