<?php

namespace TestsMisterIcy\QueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Operations\Neq;
use PHPUnit\Framework\TestCase;

class NeqTest extends TestCase
{
    public function testNotEqualOperator(): void
    {
        static::assertEquals('1 != 2', strval(new Neq(1, 2)));
    }
}
