<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

/**
 * Class OrderBy.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions\DML
 */
class OrderBy extends Expression
{
    /**
     * An associative array of fields or expressions, optionally paired with the order.
     *
     * @var array<string, string>|array<int, string>
     */
    private array $fields;

    /**
     * Creates a new Group By Expression.
     *
     * @param array<string, string>|array<int, string> $fields An associative array of fields or expressions,
     * optionally paired with the order of the field/expression to be ordered by.
     */
    public function __construct(array $fields)
    {
        parent::__construct(self::PRIORITY_ORDER_BY);
        $this->fields = $fields;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = 'ORDER BY ';
        if (array_is_list($this->fields)) {
            $builder .= implode($this->separator, $this->fields);
        } else {
            foreach ($this->fields as $field => $order) {
                if (is_int($field)) {
                    $field = $order;
                    $order = 'ASC';
                }
                $builder .= sprintf('%s %s%s', $field, $order, $this->separator);
            }
            $builder = rtrim($builder, $this->separator);
        }
        return $builder;
    }
}
