<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Concat extends Operation
{
    public function __construct(...$operands)
    {
        parent::__construct('CONCAT', ...$operands);
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
