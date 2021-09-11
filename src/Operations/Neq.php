<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Neq extends Operation
{
    /**
     * @param mixed $left
     * @param mixed $right
     */
    public function __construct($left, $right)
    {
        parent::__construct('!=', $left, $right);
    }
}
