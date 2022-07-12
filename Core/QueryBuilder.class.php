<?php

namespace App\Core;

interface QueryBuilder
{

    public function insert(string $table, array $columns, array $values): QueryBuilder;

    public function update(string $table, array $columns, array $values): QueryBuilder;

    public function select2(string $table, array $columns): QueryBuilder;

    public function delete2(string $table): QueryBuilder;

    public function where(string $column, string $value, string $operator = '=', string $type = 'AND'): QueryBuilder;

    public function limit(int $from, int $offset): QueryBuilder;

    public function orderBy(string $value, string $order = 'ASC'): QueryBuilder;

    public function leftJoin(string $table1, string $table2, string $paramTable1, string $paramTable2): QueryBuilder;

    public function getQuery();

    public function getParams();

    public function resetParams();
}