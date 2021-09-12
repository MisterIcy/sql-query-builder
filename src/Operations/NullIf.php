<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class NullIf extends Operation
{
    /**
     * @param mixed $left
     * @param mixed $right
     */
    public function __construct($left, $right)
    {
        parent::__construct('NULLIF', $left, $right);
    }

    public function __toString(): string
    {
        return sprintf(
            "%s%s%s%s",
            $this->operator,
            $this->preSeparator,
            implode($this->separator, $this->expressions),
            $this->postSeparator
        );
    }
}
