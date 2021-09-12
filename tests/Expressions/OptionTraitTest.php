<?php

namespace Expressions;

use MisterIcy\SqlQueryBuilder\Expressions\OptionTrait;
use PHPStan\Testing\TestCase;

class OptionTraitTest extends TestCase
{
    use OptionTrait;

    public function testGetOptions(): void
    {
        self::assertEquals($this->options, $this->getOptions());
    }
    public function testUnsetNonSetOption(): void
    {
        $options = $this->getOptions();
        $this->unsetOption('non_existent');
        self::assertEquals($options, $this->getOptions());
    }
    public function testUnsetSetOption(): void
    {
        $initialOptions = $this->getOptions();
        $this->setOption('test', 1);
        self::assertTrue($this->hasOption('test'));
        self::assertEquals(1, $this->getOption('test'));
        $this->unsetOption('test');
        self::assertFalse($this->hasOption('test'));
        self::assertEquals($initialOptions, $this->getOptions());
    }
    public function testGetNonExistingOption(): void
    {
        $this->assertNull($this->getOption('non_existent'));
    }
}
