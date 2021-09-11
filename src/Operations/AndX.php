<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class AndX extends Operation
{
    use NestedOperation;

    /**
     * @param Expression $expressions
     */
    public function __construct(...$expressions)
    {
        parent::__construct('AND', ...$expressions);
    }
}
