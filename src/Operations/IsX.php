<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IsX extends Operation
{
    public function __construct($expression, string $against = 'TRUE')
    {
        parent::__construct('IS', $expression, $against);
    }
}
