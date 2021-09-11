<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;
use MisterIcy\SqlQueryBuilder\Expressions\OptionTrait;

class Select extends Expression
{
    use OptionTrait;

    /**
     * @var array<string, string>|array<int, string>|null
     */
    private ?array $fields;

    /**
     * @param array<string, string>|array<int, string>|null $fields
     */
    public function __construct(?array $fields = null)
    {
        parent::__construct(self::PRIORITY_SELECT);
        $this->fields = $fields;
    }

    public function __toString(): string
    {
        $builder = 'SELECT ';

        $builder .= $this->injectHints();

        if (is_null($this->fields) || count($this->fields) === 0) {
            $builder .= '*';
            return $builder;
        }

        if (array_is_list($this->fields)) {
            $builder .= implode($this->separator, $this->fields);
        } else {
            foreach ($this->fields as $field => $alias) {
                $builder .= sprintf('%s `%s`%s', $field, $alias, $this->separator);
            }
            $builder = rtrim($builder, $this->separator);
        }

        return $builder;
    }

    /**
     * Injects hints into the expression.
     *
     * @return string A string representation of the hints to be injected.
     */
    private function injectHints(): string
    {
        $builder = '';

        //HIGH_PRIORITY:
        if ($this->hasOption('high_priority') && $this->getOption('high_priority') === true) {
            $builder .= 'HIGH_PRIORITY ';
        }

        //STRAIGHT_JOIN
        if ($this->hasOption('straight_join') && $this->getOption('straight_join') === true) {
            $builder .= 'STRAIGHT_JOIN ';
        }

        //RESULT HINT:
        if (
            $this->hasOption('result_hint') &&
            in_array(strtoupper($this->getOption('result_hint')), ['SMALL', 'BIG', 'BUFFER'], true)
        ) {
            $builder .= sprintf('SQL_%s_RESULT ', strtoupper($this->getOption('result_hint')));
        }

        //CACHE HINT:
        if ($this->hasOption('cache')) {
            $builder .= sprintf('SQL_%sCACHE ', $this->getOption('cache') === true ? '' : 'NO_');
        }

        return $builder;
    }
}
