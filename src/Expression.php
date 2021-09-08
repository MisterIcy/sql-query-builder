<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder;

/**
 * Class Expression.
 *
 * The Expression is the basic building block of the QueryBuilder.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder
 */
abstract class Expression
{
    public const PRIORITY_SELECT = 100;
    public const PRIORITY_FROM = 90;

    protected string $preSeparator = '(';
    protected string $separator = ', ';
    protected string $postSeparator = ')';

    /**
     * Defines the priority of the Expression.
     *
     * Expressions are sorted in descending order depending on their priority, prior to constructing the query.
     *
     * @var int
     */
    private int $priority;

    /**
     * @param int $priority The priority of the expression. Defaults to 0.
     */
    public function __construct(int $priority = 0)
    {
        $this->priority = $priority;
    }

    /**
     * Returns the priority of the expression.
     *
     * @return int
     */
    final public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Transforms the expression into a string.
     *
     * This function must be implemented by all inheriting classes.
     *
     * @return string
     */
    abstract public function __toString(): string;
}
