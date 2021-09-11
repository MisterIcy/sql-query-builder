<?php

namespace Tests;

use MisterIcy\SqlQueryBuilder\Operations\Gt;
use MisterIcy\SqlQueryBuilder\Operations\Gte;
use MisterIcy\SqlQueryBuilder\Operations\IsNotNull;
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

    public function testSelectHaving(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->having(new Gt('COUNT(visit)', 42));

        self::assertEquals('SELECT * FROM test `t` HAVING COUNT(visit) > 42', $queryBuilder->getQuery());
    }

    public function testExtremeSelect(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select(['id', 'name' => 'userName', 'version'])
            ->from('users', 'u')
            ->where(new IsNotNull('u.id'))
            ->andWhere(new Gt('u.version', 0))
            ->groupBy(['userName', 'id' => 'DESC'])
            ->having(new Gte('COUNT(visit)', 1));

        self::assertEquals(
            'SELECT id `f_0`, name `userName`, version `f_1` FROM users `u` WHERE u.id IS NOT NULL AND u.version > 0 GROUP BY userName ASC, id DESC HAVING COUNT(visit) >= 1',
            $queryBuilder->getQuery()
        );
    }
}
