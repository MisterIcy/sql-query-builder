<?php

namespace Tests;

use MisterIcy\SqlQueryBuilder\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testSimpleSelect(): void
    {
        $queryBuilder = new \MisterIcy\SqlQueryBuilder\QueryBuilder();
        $queryBuilder->select()
            ->from('test');

        self::assertEquals('SELECT * FROM test `t`', $queryBuilder->getQuery());
    }

    public function testSelectWhere(): void
    {
        $queryBuilder = new \MisterIcy\SqlQueryBuilder\QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->where(new \MisterIcy\SqlQueryBuilder\Operations\Eq(42, 42));

        self::assertEquals('SELECT * FROM test `t` WHERE 42 = 42', $queryBuilder->getQuery());
    }

    public function testSelectWithComplexWhere(): void
    {
        $queryBuilder = new \MisterIcy\SqlQueryBuilder\QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->where(new \MisterIcy\SqlQueryBuilder\Operations\Eq(42, 42))
            ->andWhere(new \MisterIcy\SqlQueryBuilder\Operations\Neq(42, 42))
            ->orWhere(new \MisterIcy\SqlQueryBuilder\Operations\Gt(42, 42));

        self::assertEquals(
            'SELECT * FROM test `t` WHERE 42 = 42 AND 42 != 42 OR 42 > 42',
            $queryBuilder->getQuery()
        );
    }

    public function testSelectWithGroupBy(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->groupBy(['id']);

        self::assertEquals('SELECT * FROM test `t` GROUP BY id', $queryBuilder->getQuery());
    }
}
