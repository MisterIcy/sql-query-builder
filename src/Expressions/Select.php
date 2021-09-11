<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

class Select extends Expression
{
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

        //TODO: Add support for hints

        if (is_null($this->fields) || count($this->fields) === 0) {
            $builder .= '*';
            return $builder;
        }

        if (array_is_list($this->fields)) {
            $builder .=  implode($this->separator, $this->fields);
        } else {
            foreach ($this->fields as $field => $alias) {
                $builder .= sprintf('%s `%s`%s', $field, $alias, $this->separator);
            }
            $builder = rtrim($builder, $this->separator);
        }

        return $builder;
    }
}
