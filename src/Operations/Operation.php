<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

abstract class Operation extends Expression
{

    protected string $operator;
    /**
     * @var array<int, mixed>
     */
    protected array $operands;

    /**
     * @param string $operator
     * @param mixed ...$operands
     */
    public function __construct(string $operator, ...$operands)
    {
        $this->operator = $operator;
        $this->operands = [];
        foreach ($operands as $operand) {
            $this->operands[] = $operand;
        }
        parent::__construct(0);
    }

    public function __toString(): string
    {
        $builder = '';
        foreach ($this->operands as $operand) {
            $builder .= sprintf('%s %s ', $operand, $this->operator);
        }
        return rtrim($builder, ' ' . $this->operator);
    }
}
