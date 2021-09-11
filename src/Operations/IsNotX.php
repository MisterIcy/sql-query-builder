<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IsNotX extends Operation
{
    /**
     * @param mixed $expression
     * @param string $against
     */
    public function __construct($expression, string $against = 'TRUE')
    {
        parent::__construct('IS NOT', $expression, $against);
    }
}
