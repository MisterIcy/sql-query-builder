<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Operation;

final class Eq extends Operation
{
    public function __construct($leftOperand = null, $rightOperand = null)
    {
        $this->operator = '=';
        parent::__construct($leftOperand, $rightOperand);
    }
}
