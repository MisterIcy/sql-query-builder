<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Gt extends Operation
{
    public function __construct($left, $right)
    {
        parent::__construct('>', $left, $right);
    }
}
