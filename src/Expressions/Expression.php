<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

use Countable;
use MisterIcy\SqlQueryBuilder\Operations\NestedOperation;

/**
 * Class Expression.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @version 0.2.0
 * @package MisterIcy\SqlQueryBuilder\Expressions
 */
abstract class Expression implements Countable
{
    public const PRIORITY_SELECT = 100;
    public const PRIORITY_DELETE = 100;
    public const PRIORITY_FROM = 90;
    public const PRIORITY_JOIN = 80;
    public const PRIORITY_WHERE = 70;
    public const PRIORITY_GROUP_BY = 60;
    public const PRIORITY_HAVING = 50;
    public const PRIORITY_ORDER_BY = 40;
    public const PRIORITY_LIMIT = 30;

    protected string $preSeparator = '(';
    protected string $separator = ', ';
    protected string $postSeparator = ')';

    protected int $priority;

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @var mixed[]
     */
    protected array $expressions = [];

    protected function __construct(int $priority = 0)
    {
        $this->priority = $priority;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->expressions);
    }

    /**
     * Converts the expression to string.
     *
     * @return string
     */
    abstract public function __toString(): string;

    /**
     * @param Expression[] $expressions
     * @return Expression[]
     */
    final public static function sortExpressions(array $expressions): array
    {
        uasort($expressions, function (Expression $a, Expression $b) {
            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }
            return ($a->getPriority() < $b->getPriority()) ? 1 : -1;
        });
        return $expressions;
    }

    final protected function isNestedOperation(): bool
    {
        return (
            is_array(class_uses($this)) &&
            in_array(NestedOperation::class, class_uses($this), true)
        );
    }
}
