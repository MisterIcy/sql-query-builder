<?php

namespace MisterIcy\SqlQueryBuilder\Expressions;

use MisterIcy\SqlQueryBuilder\QueryBuilder;

class FromQuery extends Expression
{

    private QueryBuilder $builder;
    private ?string $alias;

    public function __construct(QueryBuilder $builder, ?string $alias = 'c')
    {
        parent::__construct(self::PRIORITY_FROM);
        $this->builder = $builder;
        $this->alias = $alias;
    }

    public function __toString(): string
    {
        $builder = 'FROM ';
        $builder .= sprintf("%s%s%s", $this->preSeparator, $this->builder->getQuery(), $this->postSeparator);
        if (!is_null($this->alias)) {
            $builder .= sprintf(' %s', $this->alias);
        }
        return $builder;
    }
}
