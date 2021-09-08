<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Operations;

use MisterIcy\SqlQueryBuilder\Operation;

/**
 * Nop: No Operation.
 *
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Operations
 */
final class Nop extends Operation
{
    /**
     * Creates a new No Operation.
     */
    public function __construct()
    {
        $this->forbiddenTypes = null;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return '';
    }
}
