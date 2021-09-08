<?php

namespace TestsMisterIcy\QueryBuilder\Expressions;

use MisterIcy\SqlQueryBuilder\Exceptions\InvalidHintException;
use MisterIcy\SqlQueryBuilder\Expressions\Select;
use PHPUnit\Framework\TestCase;

final class SelectTest extends TestCase
{
    public function testSimpleSelect(): void
    {
        $select = new Select();
        static::assertEquals('SELECT *', strval($select));
    }
    public function testSelectWithSimpleFields(): void
    {
        $select = new Select(['id', 'name']);
        static::assertEquals('SELECT id, name', strval($select));
    }
    public function testSelectWithCompositeFields(): void
    {
        $select = new Select(['id' => 'id', 'name' => 'name']);
        static::assertEquals('SELECT id `id`, name `name`', strval($select));
    }
    public function testSelectAllWithValidHint(): void
    {
        $select = new Select();
        $select->addHint('SQL_NO_CACHE');
        static::assertEquals('SELECT SQL_NO_CACHE *', strval($select));
    }
    public function testSelectAllWithInvalidHint(): void
    {
        $select = new Select();
        static::expectException(InvalidHintException::class);
        $select->addHint('NO_STAIRWAY_TO_HEAVEN');
    }
}
