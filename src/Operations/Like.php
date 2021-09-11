<?php

namespace MisterIcy\SqlQueryBuilder\Operations;

class Like extends Operation
{
    public function __construct(string $field, string $term)
    {
        parent::__construct('LIKE', $field, $term);
    }
}
