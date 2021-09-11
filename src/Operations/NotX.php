<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class NotX extends Operation
{
    use NestedOperation {
        __toString as public nestedString;
    }

    /**
     * @param mixed
     */
    public function __construct($condition)
    {
        parent::__construct('NOT', $condition);
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->operator, $this->nestedString());
    }
}
