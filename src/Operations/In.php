<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class In extends Operation
{
    private $expression;

    public function __construct($expression, ...$operands)
    {
        parent::__construct('IN', ...$operands);
        $this->expression = $expression;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s %s%s%s',
            $this->expression,
            $this->operator,
            $this->preSeparator,
            implode($this->separator, $this->operands),
            $this->postSeparator
        );
    }
}
