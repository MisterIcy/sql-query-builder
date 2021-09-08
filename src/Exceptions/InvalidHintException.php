<?php

namespace MisterIcy\SqlQueryBuilder\Exceptions;

use Throwable;

final class InvalidHintException extends ExpressionException
{
    public function __construct(string $hint)
    {
        parent::__construct(sprintf('An invalid hint "%s" was added to the expression', $hint));
    }
}
