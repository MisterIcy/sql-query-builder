<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IfNull extends Operation
{
    public function __construct(string $field, $replaceValue)
    {
        parent::__construct('IFNULL', $field, $replaceValue);
    }

    public function __toString(): string
    {
        return sprintf('%s(%s, %s)', $this->operator, $this->operands[0], $this->operands[1]);
    }
}