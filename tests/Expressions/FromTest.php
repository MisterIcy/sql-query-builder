<?php

namespace TestsMisterIcy\QueryBuilder\Expressions;

use MisterIcy\SqlQueryBuilder\Expressions\From;
use PHPUnit\Framework\TestCase;

class FromTest extends TestCase
{
    public function testFrom(): void
    {
        static::assertEquals('FROM test t', strval(new From('test')));
    }
    public function testFromWithAlias(): void
    {
        static::assertEquals('FROM test t1', strval(new From('test', 't1')));
    }
}
