<?php

namespace MisterIcy\SqlQueryBuilder\Exceptions;

class InvalidOperandException extends ExpressionException
{
    public function __construct(string $operandType, string $operation)
    {
        parent::__construct(
            sprintf("Invalid operand type (%s) for %s", $operandType, $operation)
        );
    }
}
