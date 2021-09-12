<?php

namespace Tests;

use MisterIcy\SqlQueryBuilder\Expressions\DML\Join;
use MisterIcy\SqlQueryBuilder\Operations\Eq;
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
            ->limit(100, 42)
            ->where(new IsNotNull('u.id'))
            ->andWhere(new Gt('u.version', 0))
            ->orderBy(['id' => 'DESC', 'userName'])
            ->groupBy(['userName', 'id' => 'DESC'])
            ->join('test', 't1', new Eq('t1.id', 'u.id'))
            ->having(new Gte('COUNT(visit)', 1));

        self::assertEquals(
            'SELECT id `f_0`, name `userName`, version `f_1` FROM users `u` JOIN test `t1` ON t1.id = u.id WHERE u.id IS NOT NULL AND u.version > 0 GROUP BY userName ASC, id DESC HAVING COUNT(visit) >= 1 ORDER BY id DESC, userName ASC LIMIT 42, 100',
            $queryBuilder->getQuery()
        );
    }

    public function testJoints(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('tests')
            ->join('t1', 't1', new Eq(1, 1))
            ->leftJoin('t1', 't1', new Eq(1, 1))
            ->rightJoin('t1', 't1', new Eq(1, 1))
            ->innerJoin('t1', 't1', new Eq(1, 1));

        self::assertEquals(
            'SELECT * FROM tests `t` JOIN t1 `t1` ON 1 = 1 LEFT JOIN t1 `t1` ON 1 = 1 RIGHT JOIN t1 `t1` ON 1 = 1 INNER JOIN t1 `t1` ON 1 = 1',
            $queryBuilder->getQuery()
        );
    }

    public function testProfiling(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('tests');

        $queryBuilder->enableProfiling();

        self::assertEquals("SET profiling = 1;\n SELECT * FROM tests `t`", $queryBuilder->getQuery());

        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->enableProfiling()
            ->from('tests');

        $queryBuilder->disableProfiling();
        self::assertEquals("SELECT * FROM tests `t`", $queryBuilder->getQuery());


    }
}
