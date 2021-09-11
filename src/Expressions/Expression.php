<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

use Countable;
use Iterator;

/**
 * @implements Iterator<Expression>
 */
abstract class Expression implements Countable, Iterator
{
    public const PRIORITY_SELECT = 100;
    public const PRIORITY_FROM = 90;

    protected string $preSeparator = '(';
    protected string $separator = ', ';
    protected string $postSeparator = ')';

    protected int $priority;

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @var Expression[]
     */
    protected array $expressions;

    private int $position = 0;

    protected function __construct(int $priority = 0)
    {
        $this->priority = $priority;
        $this->expressions = [];
    }

    /**
     * @inheritDoc
     */
    final public function count(): int
    {
        return count($this->expressions);
    }

    /**
     * @inheritDoc
     * @return Expression
     */
    final public function current(): Expression
    {
        return $this->expressions[$this->position];
    }

    /**
     * @inheritDoc
     */
    final public function next(): void
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    final public function key(): int
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    final public function valid(): bool
    {
        return isset($this->expressions[$this->position]);
    }

    /**
     * @inheritDoc
     */
    final public function rewind(): void
    {
        $this->position = 0;
    }

    public function __toString(): string
    {
        $builder = '';
        foreach ($this as $expression) {
            $builder .= sprintf('%s%s', $expression, $this->separator);
        }
        $builder = rtrim($builder, $this->separator);
        return $builder;
    }

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
}
