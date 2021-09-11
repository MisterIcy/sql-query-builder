<?php

namespace Expressions;

use MisterIcy\SqlQueryBuilder\Expressions\DML\Delete;
use PHPUnit\Framework\TestCase;

class DMLTest extends TestCase
{
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
}
