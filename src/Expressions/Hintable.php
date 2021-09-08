<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder\Expressions;

use MisterIcy\SqlQueryBuilder\Exceptions\InvalidHintException;

/**
 * Trait Hintable.
 *
 * Provides extra functionality to Expressions which can provide hints to the SQL Optimizer.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expressions
 */
trait Hintable
{
    /**
     * An array of allowed hints.
     *
     * These must be set by the Expression's constructor and be in uppercase.
     * @var string[]
     */
    protected array $allowedHints = [];

    /**
     * An array of hints to be used in the expression.
     *
     * @var string[]
     */
    protected array $hints = [];

    /**
     * Returns the hints set for this Expression.
     *
     * @return string[]
     */
    public function getHints(): array
    {
        return $this->hints;
    }

    /**
     * Returns a string with the hints formatted.
     *
     * @return string
     */
    public function printHints(): string
    {
        return implode(' ', $this->hints);
    }

    /**
     * Adds a hint to the expression.
     *
     * @param string $hint The hint to be added
     * @return self
     */
    final public function addHint(string $hint): self
    {
        if (!in_array(strtoupper($hint), $this->allowedHints, true)) {
            throw new InvalidHintException($hint);
        }

        if (!in_array($hint, $this->hints, true)) {
            $this->hints[] = $hint;
        }

        return $this;
    }

    /**
     * Removes an already set hint from the expression
     * @param string $hint The hint to be removed.
     * @return self
     */
    final public function removeHint(string $hint): self
    {
        $key = array_search($hint, $this->hints, true);
        if ($key !== false) {
            unset($this->hints[$key]);
        }
        return $this;
    }
}
