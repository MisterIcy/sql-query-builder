<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class When extends Operation
{
    public function __construct(Expression $expression, $result)
    {
        parent::__construct('WHEN', $expression, $result);
    }

    public function __toString(): string
    {
        return sprintf('%s %s THEN %s', $this->operator, strval($this->operands[0]), $this->operands[1]);
    }
}
