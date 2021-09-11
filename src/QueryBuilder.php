<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder;

use MisterIcy\SqlQueryBuilder\Expressions\DML\Delete;
use MisterIcy\SqlQueryBuilder\Expressions\DML\From;
use MisterIcy\SqlQueryBuilder\Expressions\DML\GroupBy;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Select;
use MisterIcy\SqlQueryBuilder\Expressions\DML\Where;
use MisterIcy\SqlQueryBuilder\Expressions\Expression;

class QueryBuilder
{
    /**
     * @var Expression[]
     */
    protected array $expressions;

    public function addExpression(Expression $expression): self
    {
        $this->expressions[] = $expression;
        return $this;
    }

    /**
     * Starts a SELECT Operation
     * @param array<string, string>|array<int, string>|null $fields The fields to be selected. If the values are paired,
     * then the key is the field to select and its value is the alias of the field. Leave null if you want to select
     * everything *.
     *
     * @param array<string, mixed> $options An array of options to be passed to the expression. By default no options are passed.
     * <p>Meaningful Options:</p>
     * <ul>
     * <li>high_priority (true/false): Adds the HIGH_PRIORITY hint</li>
     * <li>straight_join (true/false): Adds the STRAIGHT_JOIN hint</li>
     * <li>result_hint ('SMALL', 'BIG', 'BUFFER'): Adds the respective SQL_*_RESULT hint</li>
     * <li>cache (true/false): Adds SQL_CACHE / SQL_NO_CACHE hint</li>
     * </ul>
     *
     * @return self
     */
    public function select(?array $fields = null, array $options = []): self
    {
        $select = new Select($fields);
        $select->setOptions($options);
        return $this->addExpression($select);
    }

    /**
     * Adds a FROM expression to the QueryBuilder.
     *
     * @param string $table The table on which the operation will be performed
     * @param string $alias The alias of the table, defaults to 't';
     * @return self
     */
    public function from(string $table, string $alias = 't'): self
    {
        return $this->addExpression(new From($table, $alias));
    }

    /**
     * Adds a WHERE expression to the QueryBuilder.
     *
     * This is an internal function of the library.
     *
     * @api
     * @param Expression $expression The expression of the Where statement.
     * @param array<string, string> $options An array of options:
     * <p>Meaningful Options</p>
     * <ul>
     * <li>composite ('and'/'or'): Creates a composite Where expression in order to be joined with other
     * where expressions</li>
     * </ul>
     * @return self
     */
    private function addWhere(Expression $expression, array $options = []): self
    {
        $where = new Where($expression);
        $where->setOptions($options);
        return $this->addExpression($where);
    }

    /**
     * Adds a WHERE expression to the QueryBuilder.
     *
     * If you need to chain multiple WHERE expressions, use {@see QueryBuilder::andWhere()} and
     * {@see QueryBuilder::orWhere()}
     *
     * @param Expression $expression
     * @return self
     */
    public function where(Expression $expression): self
    {
        return $this->addWhere($expression);
    }

    /**
     * Creates a composite AND expression to be joined with other WHERE expressions.
     *
     * @param Expression $expression The expression of the Where statement
     * @return self
     */
    public function andWhere(Expression $expression): self
    {
        return $this->addWhere($expression, ['composite' => 'and']);
    }

    /**
     * Creates a composite OR expression to be joined with other WHERE expressions.
     *
     * @param Expression $expression The expression of the Where statement
     * @return self
     */
    public function orWhere(Expression $expression): self
    {
        return $this->addWhere($expression, ['composite' => 'or']);
    }

    /**
     * Adds a Group By expression to the QueryBuilder.
     *
     * @param array<string, string>|array<int, string> $fields An associative array of fields or expressions,
     * optionally paired with the order of the field/expression to be grouped by.
     * @return self
     */
    public function groupBy(array $fields): self
    {
        return $this->addExpression(new GroupBy($fields));
    }

    /**
     * Returns an SQL Query.
     *
     * @return string
     */
    public function getQuery(): string
    {
        $expressions = Expression::sortExpressions($this->expressions);
        $builder = '';
        foreach ($expressions as $expression) {
            $builder .= sprintf('%s ', $expression);
        }

        return rtrim($builder);
    }
}
