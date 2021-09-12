<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class When extends Operation
{
    /**
     * @param Expression $expression
     * @param mixed $result
     */
    public function __construct(Expression $expression, $result)
    {
        parent::__construct('WHEN', $expression, $result);
    }

    public function __toString(): string
    {
        return sprintf('%s %s THEN %s', $this->operator, strval($this->expressions[0]), $this->expressions[1]);
    }
}
