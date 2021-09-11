<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class OrX extends Operation
{
    use NestedOperation;
    /**
     * @param Expression ...$expressions
     */
    public function __construct(...$expressions)
    {
        parent::__construct('OR', ...$expressions);
    }
}
