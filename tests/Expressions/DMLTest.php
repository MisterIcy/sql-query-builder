<?php

namespace Expressions;

use MisterIcy\SqlQueryBuilder\Expressions\DML\Delete;
use MisterIcy\SqlQueryBuilder\Expressions\DML\From;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Select;
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
}
