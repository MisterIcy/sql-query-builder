<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;
use MisterIcy\SqlQueryBuilder\Expressions\OptionTrait;

/**
 * Class Delete.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions\DML
 */
class Delete extends Expression
{
    use OptionTrait;

    /**
     * Creates a new Delete Expression
     * @param array<string, bool> $options An array of extra options
     */
    public function __construct(array $options = [])
    {
        parent::__construct(self::PRIORITY_DELETE);
        $this->setOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = 'DELETE';
        if ($this->hasOption('ignore') && $this->getOption('ignore') === true) {
            $builder .= ' IGNORE';
        }
        return $builder;
    }
}
