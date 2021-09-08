<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

use MisterIcy\SqlQueryBuilder\Expression;

class From extends Expression
{
    /**
     * The name of the table
     *
     * @var string
     */
    private string $table;

    /**
     * The alias of the table (defaults to 't').
     * @var string
     */
    private string $alias;

    /**
     * Creates a new FROM Expression
     * @param string $table The name of the table
     * @param string $alias The alias of the table (defaults to 't')
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
        return sprintf("FROM %s %s",$this->table, $this->alias);
    }
}
