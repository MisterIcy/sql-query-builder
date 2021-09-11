<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IsNotNull extends Operation
{
    public function __construct(string $field)
    {
        parent::__construct('IS NOT NULL', $field);
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->operands[0], $this->operator);
    }
}
