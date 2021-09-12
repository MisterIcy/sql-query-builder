<?php

namespace MisterIcy\SqlQueryBuilder\Expressions\DCL;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;
use MisterIcy\SqlQueryBuilder\Operations\Eq;

class Set extends Expression
{
    public function __construct(string $variable, string $value)
    {
        parent::__construct(self::PRIORITY_SET);
        $this->expressions[] = $variable;
        $this->expressions[] = $value;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf("SET %s;\n", new Eq($this->expressions[0], $this->expressions[1]));
    }
}
