<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Lt extends Operation
{
    public function __construct($left, $right)
    {
        parent::__construct('<', $left, $right);
    }
}
