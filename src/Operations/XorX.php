<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class XorX extends Operation
{
    use NestedOperation;

    /**
     * @param Expression ...$expressions
     */
    public function __construct(...$expressions)
    {
        parent::__construct('XOR', ...$expressions);
    }
}
