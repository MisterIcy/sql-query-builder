<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

use MisterIcy\SqlQueryBuilder\Expression;

class Select extends Expression
{
    use Hintable;

    /**
     * An array of fields to be selected.
     *
     * The array can be either in the form of simple fields, or in key-paired values where the key is the name of
     * the field and the value is its alias.
     *
     * @var array<int, string>|array<string, string>|null
     */
    public ?array $fields;

    /**
     * Creates a new SELECT Expression.
     *
     * @param array<int, string>|array<string, string>|null $fields An array of fields to be selected. Leave this null
     * in order to SELECT *.
     */
    public function __construct(?array $fields = null)
    {
        $this->fields = $fields;
        $this->allowedHints = [
            'ALL',
            'DISTINCT',
            'DISTINCTROW',
            'HIGH_PRIORITY',
            'STRAIGHT_JOIN',
            'SQL_SMALL_RESULT',
            'SQL_BIG_RESULT',
            'SQL_BUFFER_RESULT',
            'SQL_CACHE',
            'SQL_NO_CACHE',
            'SQL_CALC_FOUND_ROWS'
        ];
        parent::__construct(self::PRIORITY_SELECT);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = 'SELECT';

        if (count($this->hints) > 0) {
            $builder .= sprintf(' %s', $this->printHints());
        }

        if (is_null($this->fields) || count($this->fields) === 0) {
            $builder .= ' *';
            return $builder;
        }

        $builder .= $this->printFields();

        return $builder;
    }

    /**
     * Prints the fields of the expression in a buffer.
     *
     * @return string The printed fields of the expression.
     */
    private function printFields(): string
    {
        $builder = '';
        if (is_null($this->fields)) {
            return $builder;
        }
        $builder .= ' ';

        if (!array_is_list($this->fields)) {
            foreach ($this->fields as $field => $alias) {
                $builder .= sprintf('%s `%s`%s', $field, $alias, $this->separator);
            }
        } else {
            $builder .= implode($this->separator, $this->fields);
        }

        if (str_ends_with($builder, $this->separator)) {
            $builder = rtrim($builder, $this->separator);
        }
        return $builder;
    }
}
