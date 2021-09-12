<?php

namespace MisterIcy\SqlQueryBuilder\Expressions\DCL;

class Profiling extends Set
{
    public function __construct(bool $enable = false)
    {
        parent::__construct('profiling', ($enable) ? 1 : 0);
    }
}
