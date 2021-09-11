<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class XorX extends Operation
{
    use NestedOperation;

    public function __construct(...$expressions)
    {
        parent::__construct('XOR', ...$expressions);
    }
}
