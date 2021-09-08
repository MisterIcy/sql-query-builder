<?php

namespace TestsMisterIcy\QueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Operations\Nop;
use PHPUnit\Framework\TestCase;

final class NopTest extends TestCase
{
    public function testNoOperation(): void
    {
        static::assertEquals('', new Nop());
    }
}
