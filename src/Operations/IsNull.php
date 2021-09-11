<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IsNull extends Operation
{
    public function __construct(string $field)
    {
        parent::__construct('IS NULL', $field);
    }
    public function __toString(): string
    {
        return sprintf('%s %s', $this->operands[0], $this->operator);
    }
}
