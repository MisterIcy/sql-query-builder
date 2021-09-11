<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;
use MisterIcy\SqlQueryBuilder\Expressions\OptionTrait;

class Where extends Expression
{
    use OptionTrait;

    private Expression $expression;

    public function __construct(Expression $expression)
    {
        parent::__construct(self::PRIORITY_WHERE);
        $this->expression = $expression;
    }

    public function __toString(): string
    {
        if ($this->hasOption('composite')) {
            if ($this->getOption('composite') === 'and') {
                $builder = ' AND ';
            } elseif ($this->getOption('composite') === 'or') {
                $builder = ' OR ';
            } else {
                $builder = 'WHERE ';
            }
        } else {
            $builder = 'WHERE ';
        }

        $builder .= $this->expression;

        return $builder;
    }
}
