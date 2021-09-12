<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class ConcatWs extends Operation
{
    private string $concatSeparator;

    public function __construct(string $separator = ', ', ...$operands)
    {
        parent::__construct('CONCAT_WS', ...$operands);
        $this->concatSeparator = $separator;
    }
    public function __toString(): string
    {
        return sprintf(
            "%s%s'%s', %s%s",
            $this->operator,
            $this->preSeparator,
            $this->concatSeparator,
            implode($this->separator, $this->expressions),
            $this->postSeparator
        );
    }
}
