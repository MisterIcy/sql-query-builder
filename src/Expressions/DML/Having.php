<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

/**
 * Class Having.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions\DML
 */
class Having extends Expression
{
    /**
     * @var Expression
     */
    private Expression $expression;

    /**
     * Creates a new Having Expression
     * @param Expression $expression The expression to be used.
     */
    public function __construct(Expression $expression)
    {
        parent::__construct(self::PRIORITY_HAVING);
        $this->expression = $expression;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf('HAVING %s', $this->expression);
    }
}
