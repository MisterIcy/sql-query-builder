<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

class From extends Expression
{
    private string $table;
    private string $alias;

    public function __construct(string $table, string $alias = 't')
    {
        parent::__construct(self::PRIORITY_FROM);
        $this->table = $table;
        $this->alias = $alias;
    }

    public function __toString(): string
    {
        return sprintf("FROM %s %s", $this->table, $this->alias);
    }
}
