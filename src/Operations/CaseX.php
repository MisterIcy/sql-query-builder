<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class CaseX extends Operation
{
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
