<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Operations\Operation;

class InnerJoin extends Join
{
    public function __construct(string $table, string $alias, Operation $on)
    {
        parent::__construct($table, $alias, $on, self::JOIN_TYPE_INNER);
    }
}
