<?php

namespace Tests\MisterIcy\QueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Operations\AndX;
use MisterIcy\SqlQueryBuilder\Operations\Between;
use MisterIcy\SqlQueryBuilder\Operations\CaseX;
use MisterIcy\SqlQueryBuilder\Operations\Coalesce;
use MisterIcy\SqlQueryBuilder\Operations\Concat;
use MisterIcy\SqlQueryBuilder\Operations\ConcatWs;
use MisterIcy\SqlQueryBuilder\Operations\ElseX;
use MisterIcy\SqlQueryBuilder\Operations\Eq;
use MisterIcy\SqlQueryBuilder\Operations\EqNullsafe;
use MisterIcy\SqlQueryBuilder\Operations\Gt;
use MisterIcy\SqlQueryBuilder\Operations\Gte;
use MisterIcy\SqlQueryBuilder\Operations\IfNull;
use MisterIcy\SqlQueryBuilder\Operations\IfX;
use MisterIcy\SqlQueryBuilder\Operations\In;
use MisterIcy\SqlQueryBuilder\Operations\IsNotNull;
use MisterIcy\SqlQueryBuilder\Operations\IsNotX;
use MisterIcy\SqlQueryBuilder\Operations\IsNull;
use MisterIcy\SqlQueryBuilder\Operations\IsX;
use MisterIcy\SqlQueryBuilder\Operations\Like;
use MisterIcy\SqlQueryBuilder\Operations\Lt;
use MisterIcy\SqlQueryBuilder\Operations\Lte;
use MisterIcy\SqlQueryBuilder\Operations\Neq;
use MisterIcy\SqlQueryBuilder\Operations\NotX;
use MisterIcy\SqlQueryBuilder\Operations\NullIf;
use MisterIcy\SqlQueryBuilder\Operations\OrX;
use MisterIcy\SqlQueryBuilder\Operations\When;
use MisterIcy\SqlQueryBuilder\Operations\XorX;
use PHPUnit\Framework\TestCase;

class OperationsTest extends TestCase
{
    public function testEquality(): void
    {
        static::assertEquals('1 = 2', strval(new Eq(1, 2)));
    }

    public function testInequality(): void
    {
        static::assertEquals('1 != 2', strval(new Neq(1, 2)));
    }

    public function testGreaterThan(): void
    {
        static::assertEquals('1 > 2', strval(new Gt(1, 2)));
    }

    public function testGreaterThanOrEqual(): void
    {
        static::assertEquals('1 >= 2', strval(new Gte(1, 2)));
    }

    public function testLessThan(): void
    {
        static::assertEquals('1 < 2', strval(new Lt(1, 2)));
    }

    public function testLessThanOrEqual(): void
    {
        static::assertEquals('1 <= 2', strval(new Lte(1, 2)));
    }

    public function testBetween(): void
    {
        static::assertEquals('id BETWEEN 1 AND 2', strval(new Between('id', 1, 2)));
    }

    public function testLike(): void
    {
        self::assertEquals('id LIKE "%a%"', strval(new Like('id', '"%a%"')));
    }

    public function testIsNull(): void
    {
        self::assertEquals('id IS NULL', strval(new IsNull('id')));
    }

    public function testIsNotNull(): void
    {
        self::assertEquals('id IS NOT NULL', strval(new IsNotNull('id')));
    }

    public function testAndXSimple(): void
    {
        $and = new AndX(new Eq(1, 2), new Neq(1, 2));
        self::assertEquals('1 = 2 AND 1 != 2', strval($and));
    }

    public function testAndXComplex(): void
    {
        $and = new AndX(
            new Eq(1, 2),
            new AndX(new IsNull('name'), new Gt('id', 0))
        );
        self::assertEquals('1 = 2 AND (name IS NULL AND id > 0)', strval($and));
    }

    public function testOrXSimple(): void
    {
        $or = new OrX(new Eq(1, 2), new Neq(1, 2));
        self::assertEquals('1 = 2 OR 1 != 2', strval($or));
    }

    public function testOrXComplex(): void
    {
        $or = new OrX(
            new Eq(1, 2),
            new AndX(new IsNull('name'), new Gt('id', 0))
        );
        self::assertEquals('1 = 2 OR (name IS NULL AND id > 0)', strval($or));
    }

    public function testIfNull(): void
    {
        $operation = new Eq(new IfNull('ts', 0), 0);
        self::assertEquals('IFNULL(ts, 0) = 0', strval($operation));
    }

    public function testSimpleNot(): void
    {
        $not = new NotX(new Eq(1, 2));
        self::assertEquals('NOT 1 = 2', strval($not));
    }

    public function testComplexNot(): void
    {
        $not = new NotX(new AndX(new Eq(1, 2), new Neq(1, 2)));
        self::assertEquals('NOT (1 = 2 AND 1 != 2)', strval($not));
    }

    public function testIn(): void
    {
        $in = new In('id', 1, 2, 3);
        self::assertEquals('id IN (1, 2, 3)', strval($in));
    }

    public function testWhen(): void
    {
        $when = new When(new IsNull('name'), '0');
        self::assertEquals('WHEN name IS NULL THEN 0', strval($when));
    }

    public function testElse(): void
    {
        $else = new ElseX(0);
        self::assertEquals('ELSE 0', strval($else));
    }

    public function testSimpleCase(): void
    {
        $case = new CaseX(new When(new Eq(1, 2), 0), new ElseX(1));
        self::assertEquals('CASE WHEN 1 = 2 THEN 0 ELSE 1 END;', strval($case));
    }

    public function testNullSafeEq(): void
    {
        $eq = new EqNullsafe(1, 2);
        self::assertEquals('1 <=> 2', strval($eq));
    }

    public function testCoalesce(): void
    {
        $coalesce = new Coalesce(1, 2, 3, 4);
        self::assertEquals('COALESCE(1, 2, 3, 4)', strval($coalesce));
    }

    public function testConcat(): void
    {
        $concat = new Concat('T', 'es', 't');
        self::assertEquals('CONCAT(T, es, t)', strval($concat));
    }

    public function testConcatWs(): void
    {
        $concat = new ConcatWs(',', 'T', 'es', 't');
        self::assertEquals('CONCAT_WS(\',\', T, es, t)', strval($concat));
    }

    public function testIfX(): void
    {
        $if = new IfX(new Eq(1, 2), '1', '0');
        self::assertEquals('IF(1 = 2, 1, 0)', strval($if));
    }

    public function testIsX(): void
    {
        $is = new IsX(new Eq(1, 2));
        self::assertEquals('1 = 2 IS TRUE', strval($is));
    }

    public function testIsNotX(): void
    {
        $isnot = new IsNotX(new Eq(1, 2), 'FALSE');
        self::assertEquals('1 = 2 IS NOT FALSE', strval($isnot));
    }

    public function testNotBetween(): void
    {
        self::assertEquals('NOT id BETWEEN 1 AND 2', strval(new NotX(new Between('id', 1, 2))));
    }

    public function testNotLike(): void
    {
        self::assertEquals('NOT name LIKE %test%', strval(new NotX(new Like('name', '%test%'))));
    }

    public function testNotIn(): void
    {
        self::assertEquals('NOT id IN (1, 2, 3)', strval(new NotX(new In('id', 1, 2, 3))));
    }

    public function testXorSimple(): void
    {
        self::assertEquals('1 = 2 XOR 1 != 2', strval(new XorX(new Eq(1, 2), new Neq(1, 2))));
    }

    public function testNullIf(): void
    {
        self::assertEquals('NULLIF(1, 2)', strval(new NullIf(1, 2)));
    }
}
