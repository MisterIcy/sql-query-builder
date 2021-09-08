<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Exceptions\InvalidOperandException;
use MisterIcy\SqlQueryBuilder\Operation;

final class Neq extends Operation
{
    /**
     * Creates a new Not Equal Operation
     *
     * @param mixed|null $leftOperand The left operand
     * @param mixed|null $rightOperand The right operand
     * @throws InvalidOperandException Thrown when an operand is invalid.
     */
    public function __construct($leftOperand = null, $rightOperand = null)
    {
        $this->operator = '!=';
        parent::__construct($leftOperand, $rightOperand);
    }
}
