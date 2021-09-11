<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;
use MisterIcy\SqlQueryBuilder\Expressions\OptionTrait;

/**
 * Class Where.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions\DML;
 */
class Where extends Expression
{
    use OptionTrait;

    /**
     * The Expression of Where.
     *
     * @var Expression
     */
    private Expression $expression;

    /**
     * Creates a new Where Expression.
     *
     * @param Expression $expression
     */
    public function __construct(Expression $expression)
    {
        parent::__construct(self::PRIORITY_WHERE);
        $this->expression = $expression;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        if ($this->hasOption('composite')) {
            if ($this->getOption('composite') === 'and') {
                $builder = 'AND ';
            } elseif ($this->getOption('composite') === 'or') {
                $builder = 'OR ';
            } else {
                $builder = 'WHERE ';
            }
        } else {
            $builder = 'WHERE ';
        }

        $builder .= $this->expression;

        return $builder;
    }
}
