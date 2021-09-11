<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

/**
 * Class From.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions\DML
 */
class From extends Expression
{
    /**
     * @var string The name of the table.
     */
    private string $table;

    /**
     * @var string The alias of the table.
     */
    private string $alias;

    /**
     * Creates a new From expression.
     *
     * @param string $table The name of the table.
     * @param string $alias The alias of the table, defaults to 't'.
     */
    public function __construct(string $table, string $alias = 't')
    {
        parent::__construct(self::PRIORITY_FROM);
        $this->table = $table;
        $this->alias = $alias;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf("FROM %s `%s`", $this->table, $this->alias);
    }
}
