<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class ElseX extends Operation
{
    /**
     * @param string|int|float $result
     */
    public function __construct($result)
    {
        parent::__construct('ELSE', $result);
    }

    public function __toString(): string
    {
        return sprintf("%s %s", $this->operator, $this->operands[0]);
    }
}
