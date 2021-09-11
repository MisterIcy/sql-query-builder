<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions\DML;

use MisterIcy\SqlQueryBuilder\Expressions\Expression;

/**
 * Class Limit.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions\DML
 */
class Limit extends Expression
{
    /**
     * The limit.
     *
     * @var int
     */
    private int $limit;

    /**
     * The offset
     * @var int|null
     */
    private ?int $offset;

    /**
     * Creates a new Limit expression
     * @param int $limit The limit
     * @param int|null $offset The offset
     */
    public function __construct(int $limit, ?int $offset = null)
    {
        parent::__construct(self::PRIORITY_LIMIT);
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = 'LIMIT ';
        if (!is_null($this->offset) && $this->offset >= 0) {
            $builder .= sprintf('%d%s', $this->offset, $this->separator);
        }
        $builder .= $this->limit;
        return $builder;
    }
}
