<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Between extends Operation
{
    /**
     * @param mixed $expression
     * @param int|float $min
     * @param int|float $max
     */
    public function __construct($expression, $min, $max)
    {
        parent::__construct('BETWEEN', $expression, $min, $max);
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s %s AND %s',
            $this->expressions[0],
            $this->operator,
            $this->expressions[1],
            $this->expressions[2]
        );
    }
}
