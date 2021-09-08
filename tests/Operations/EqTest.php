<?php

declare(strict_types=1);

namespace TestsMisterIcy\QueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Exceptions\InvalidOperandException;
use MisterIcy\SqlQueryBuilder\Operations\Eq;
use PHPUnit\Framework\TestCase;

final class EqTest extends TestCase
{
    public function testSimpleEqualityOperator(): void
    {
        static::assertEquals('1 = 2', strval(new Eq(1, 2)));
    }

    public function testEqualityOperatorWithInvalidOperand(): void
    {
        static::expectException(InvalidOperandException::class);
        new Eq(1, new Eq(1, 2));
    }

    public function testEqualityOperatorWithNullOperand(): void
    {
        static::expectException(InvalidOperandException::class);
        new Eq(1, null);
    }

    public function testEqualityOperatorWithArrayOperand(): void
    {
        static::expectException(InvalidOperandException::class);
        new Eq([], 1);
    }
}
