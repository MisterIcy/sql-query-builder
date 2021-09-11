<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Coalesce extends Operation
{
    public function __construct(...$operands)
    {
        parent::__construct('COALESCE', ...$operands);
    }

    public function __toString(): string
    {
        return sprintf(
            "%s%s%s%s",
            $this->operator,
            $this->preSeparator,
            implode($this->separator, $this->operands),
            $this->postSeparator
        );
    }
}
