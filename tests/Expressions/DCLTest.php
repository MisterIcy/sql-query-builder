<?php

namespace Expressions;

use MisterIcy\SqlQueryBuilder\Expressions\DCL\Set;
use MisterIcy\SqlQueryBuilder\Expressions\DCL\Profiling;
use PHPUnit\Framework\TestCase;

class DCLTest extends TestCase
{
    public function testSet(): void
    {
        $set = new Set('profiling', 1);
        self::assertEquals("SET profiling = 1;\n", strval($set));
    }

    public function testProfiling(): void
    {
        $profiling = new Profiling(true);
        self::assertEquals("SET profiling = 1;\n", strval($profiling));
        $profiling = new Profiling(false);
        self::assertEquals("SET profiling = 0;\n", strval($profiling));
    }

}
