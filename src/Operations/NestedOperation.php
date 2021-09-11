<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

trait NestedOperation
{
    final public function __toString(): string
    {
        $builder = '';
        foreach ($this->operands as $expression) {
            if (in_array(NestedOperation::class, class_uses($expression))) {
                $builder .= sprintf(
                    '%s%s%s %s',
                    $this->preSeparator,
                    $expression,
                    $this->postSeparator,
                    $this->operator
                );
            } else {
                $builder .= sprintf("%s %s ", strval($expression), $this->operator);
            }
        }
        return rtrim($builder, $this->operator . ' ');
    }
}
