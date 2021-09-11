<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class CaseX extends Operation
{
    /**
     * @param Expression ...$conditions
     */
    public function __construct(...$conditions)
    {
        parent::__construct('CASE', ...$conditions);
    }

    public function __toString(): string
    {
        $builder = sprintf('%s ', $this->operator);
        foreach ($this->operands as $operand) {
            $builder .= sprintf('%s ', $operand);
        }
        $builder .= 'END;';

        return $builder;
    }
}
