<?php

namespace Expressions;

use MisterIcy\SqlQueryBuilder\Expressions\DML\Delete;
use MisterIcy\SqlQueryBuilder\Expressions\DML\From;
use MisterIcy\SqlQueryBuilder\Expressions\DML\GroupBy;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Having;
use MisterIcy\SqlQueryBuilder\Expressions\DML\InnerJoin;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Join;
use MisterIcy\SqlQueryBuilder\Expressions\DML\LeftJoin;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Limit;
use MisterIcy\SqlQueryBuilder\Expressions\DML\OrderBy;
use MisterIcy\SqlQueryBuilder\Expressions\DML\RightJoin;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Select;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Where;
use MisterIcy\SqlQueryBuilder\Operations\AndX;
use MisterIcy\SqlQueryBuilder\Operations\Eq;
use MisterIcy\SqlQueryBuilder\Operations\Gt;
use MisterIcy\SqlQueryBuilder\Operations\Neq;
use MisterIcy\SqlQueryBuilder\Operations\When;
use PHPUnit\Framework\TestCase;

class DMLTest extends TestCase
{
    //<editor-fold desc="Delete">
    public function testSimpleDelete(): void
    {
        $delete = new Delete();
        self::assertEquals('DELETE', strval($delete));
    }

    public function testDeleteIgnore(): void
    {
        $delete = new Delete(['ignore' => true]);
        self::assertEquals('DELETE IGNORE', strval($delete));
    }

    public function testDeleteIgnoreWithSetOption(): void
    {
        $delete = new Delete();
        $delete->setOption('ignore', true);
        self::assertEquals('DELETE IGNORE', strval($delete));
    }
    //</editor-fold>

    //<editor-fold desc="Select">
    public function testSimpleSelect(): void
    {
        self::assertEquals('SELECT *', strval(new Select()));
    }

    public function testSelectWithFields(): void
    {
        self::assertEquals('SELECT id, name', strval(new Select(['id', 'name'])));
    }

    public function testSelectWithFieldsAndAliases(): void
    {
        self::assertEquals('SELECT id `f1`, name `f2`', strval(new Select(['id' => 'f1', 'name' => 'f2'])));
    }

    public function testSelectAllWithHints(): void
    {
        $select = new Select();
        $select->setOption('cache', false);
        self::assertEquals('SELECT SQL_NO_CACHE *', strval($select));
    }

    public function testComplexSelect(): void
    {
        $select = new Select(['id' => 'userId']);
        $select->setOptions(
            [
                'high_priority' => true,
                'straight_join' => true,
                'result_hint' => 'small',
                'cache' => false
            ]
        );

        self::assertEquals(
            'SELECT HIGH_PRIORITY STRAIGHT_JOIN SQL_SMALL_RESULT SQL_NO_CACHE id `userId`',
            strval($select)
        );
    }

    /**
     * @group issue-8
     */
    public function testSelectWithMixedFields(): void
    {
        $select = new Select(['id', 'name' => 'userName', 'timestamp']);
        self::assertEquals('SELECT id `f_0`, name `userName`, timestamp `f_1`', strval($select));
    }
    //</editor-fold>

    //<editor-fold desc="From">
    public function testSimpleFrom(): void
    {
        self::assertEquals('FROM test `t`', strval(new From('test')));
    }

    public function testFromWithAlias(): void
    {
        self::assertEquals('FROM test `c`', strval(new From('test', 'c')));
    }
    //</editor-fold>

    //<editor-fold desc="Where">
    public function testSimpleWhere(): void
    {
        $where = new Where(new Eq(1, 2));
        self::assertEquals('WHERE 1 = 2', strval($where));
    }

    public function testComplexWhere(): void
    {
        $where = new Where(new AndX(new Eq(42, 42), new Neq(1, 2)));
        self::assertEquals('WHERE 42 = 42 AND 1 != 2', strval($where));
    }

    public function testAndWhere(): void
    {
        $where = new Where(new Eq(42, 42));
        $where->setOption('composite', 'and');
        self::assertEquals('AND 42 = 42', strval($where));
    }

    public function testOrWhere(): void
    {
        $where = new Where(new Eq(42, 42));
        $where->setOption('composite', 'or');
        self::assertEquals('OR 42 = 42', strval($where));
    }

    public function testInvalidCompositeWhere(): void
    {
        $where = new Where(new Eq(42, 42));
        $where->setOption('composite', 'invalid');
        self::assertEquals('WHERE 42 = 42', strval($where));
    }

    //</editor-fold>
    //<editor-fold desc="Group By">
    public function testSimpleGroupBy(): void
    {
        $groupBy = new GroupBy(['id']);
        self::assertEquals('GROUP BY id', strval($groupBy));
    }

    public function testGroupByAndOrder(): void
    {
        $groupBy = new GroupBy(['id' => 'DESC', 'name' => 'ASC']);
        self::assertEquals('GROUP BY id DESC, name ASC', strval($groupBy));
    }

    public function testGroupByAndOrderMixed(): void
    {
        $groupBy = new GroupBy(['id', 'name' => 'DESC']);
        self::assertEquals('GROUP BY id ASC, name DESC', strval($groupBy));
    }
    //</editor-fold>

    //<editor-fold desc="Having">
    public function testHaving(): void
    {
        $having = new Having(new Gt('COUNT(visit)', 0));
        self::assertEquals('HAVING COUNT(visit) > 0', strval($having));
    }
    //</editor-fold>

    //</editor-fold>
    //<editor-fold desc="Order By">
    public function testSimpleOrderBy(): void
    {
        $groupBy = new OrderBy(['id']);
        self::assertEquals('ORDER BY id', strval($groupBy));
    }

    public function testOrderByAndOrder(): void
    {
        $groupBy = new OrderBy(['id' => 'DESC', 'name' => 'ASC']);
        self::assertEquals('ORDER BY id DESC, name ASC', strval($groupBy));
    }

    public function testOrderByAndOrderMixed(): void
    {
        $groupBy = new OrderBy(['id', 'name' => 'DESC']);
        self::assertEquals('ORDER BY id ASC, name DESC', strval($groupBy));
    }
    //</editor-fold>
    public function testLimit(): void
    {
        $limit = new Limit(10);
        self::assertEquals('LIMIT 10', strval($limit));
    }
    public function testLimitAndOffset(): void
    {
        $limit = new Limit(10, 5);
        self::assertEquals('LIMIT 5, 10', strval($limit));
    }
    public function testLimitWithNegativeOffset(): void
    {
        $limit = new Limit(10, -10);
        self::assertEquals('LIMIT 10', strval($limit));
    }

    //<editor-fold desc="JOINs">
    public function testSimpleJoin(): void
    {
        $join = new Join('test', 't1', new Eq('t1.id', 't2.userId'));
        self::assertEquals('JOIN test `t1` ON t1.id = t2.userId', strval($join));
    }

    public function testJoinManyConditions(): void
    {
         $join = new Join(
             'test',
             't1',
             new AndX(new Eq('t1.id', 't2.userId'), new Eq('t2.active', 0))
         );
         self::assertEquals('JOIN test `t1` ON (t1.id = t2.userId AND t2.active = 0)', strval($join));
    }

    public function testJoinWithOuterOption(): void
    {
        $join = new LeftJoin('test', 't1', new Eq('t1.id', 1));
        $join->setOption('outer', true);
        self::assertEquals('LEFT OUTER JOIN test `t1` ON t1.id = 1', strval($join));
    }
    public function testInnerJoin(): void
    {
        $join = new InnerJoin('test', 't1', new Eq('t1.id', 't2.userId'));
        self::assertEquals('INNER JOIN test `t1` ON t1.id = t2.userId', strval($join));
    }
    public function testRightJoin(): void
    {
        $join = new RightJoin('test', 't1', new Eq('t1.id', 't2.userId'));
        self::assertEquals('RIGHT JOIN test `t1` ON t1.id = t2.userId', strval($join));
    }
    //</editor-fold>
}
