<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;
use MisterIcy\SqlQueryBuilder\Expressions\OptionTrait;
use MisterIcy\SqlQueryBuilder\Operations\NestedOperation;
use MisterIcy\SqlQueryBuilder\Operations\Operation;

class Join extends Expression
{
    use OptionTrait;

    public const JOIN_TYPE = 'JOIN';
    public const JOIN_TYPE_INNER = 'INNER JOIN';
    public const JOIN_TYPE_LEFT = 'LEFT JOIN';
    public const JOIN_TYPE_RIGHT = 'RIGHT JOIN';
    public const JOIN_TYPE_FULL = 'FULL JOIN';

    private string $table;
    private string $alias;
    private Operation $on;
    private string $operation;

    public function __construct(
        string $table,
        string $alias,
        Operation $on,
        string $operation = self::JOIN_TYPE
    ) {
        parent::__construct(self::PRIORITY_JOIN);
        $this->table = $table;
        $this->alias = $alias;
        $this->on = $on;
        $this->operation = $operation;
    }

    public function __toString(): string
    {
        if ($this->hasOption('outer') && $this->getOption('outer') === true) {
            $joinType = explode(' ', $this->operation);
            array_splice($joinType, 1, 0, ['OUTER']);
            $this->operation = implode(' ', $joinType);
        }

        $builder = sprintf('%s %s `%s` ON ', $this->operation, $this->table, $this->alias);

        if ($this->on->isNestedOperation()) {
            $builder .= sprintf('%s%s%s', $this->preSeparator, $this->on, $this->postSeparator);
        } else {
            $builder .= $this->on;
        }

        return $builder;
    }
}
