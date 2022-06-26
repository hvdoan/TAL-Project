<?php

namespace App\Core;

interface QueryBuilder
{

    public function insert(string $table, array $columns, array $values): QueryBuilder;

    public function select(string $table, array $columns): QueryBuilder;

    public function where(string $column, string $operator = '='): QueryBuilder;

    public function limit(int $from, int $offset): QueryBuilder;

    public function getQuery();
}