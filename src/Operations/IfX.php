<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class IfX extends Operation
{
    /**
     * @param mixed $condition
     * @param mixed $true
     * @param mixed $false
     */
    public function __construct($condition, $true, $false)
    {
        parent::__construct('IF', $condition, $true, $false);
    }
    public function __toString(): string
    {
        return sprintf(
            '%s%s%s%s',
            $this->operator,
            $this->preSeparator,
            implode($this->separator, $this->expressions),
            $this->postSeparator
        );
    }
}
