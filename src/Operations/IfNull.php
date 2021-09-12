<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IfNull extends Operation
{
    /**
     * @param string $field
     * @param int|float|string $replaceValue
     */
    public function __construct(string $field, $replaceValue)
    {
        parent::__construct('IFNULL', $field, $replaceValue);
    }

    public function __toString(): string
    {
        return sprintf('%s(%s, %s)', $this->operator, $this->expressions[0], $this->expressions[1]);
    }
}
