<?php

declare(strict_types=1);

namespace MisterIcy\SqlQueryBuilder;

use Exception;
use MisterIcy\SqlQueryBuilder\Exceptions\InvalidOperandException;
use ReflectionException;
use ReflectionFunction;

/**
 * Class Operation
 *
 * Any action between one or more operands is defined as an Operation.
 * For example, id = 1 is an Equality Operation between operands 'id' and '1' with the operator '='
 *
 * This class defines the basics of operations. Each operation that inherits from this class, should define
 * its operands (or the lack of operands), the operator, and they must implement the __toString function which
 * will produce the part of the query.
 *
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder
 */
abstract class Operation extends Expression
{
    /**
     * The left operand of the operation.
     *
     * @var mixed|null
     */
    protected $leftOperand;

    /**
     * The right operand of the operation.
     *
     * @var mixed|null
     */
    protected $rightOperand;

    /**
     * The operator of the operation.
     *
     * @var string
     */
    protected string $operator;

    /**
     * An array which defines the forbidden types of the operands.
     *
     * This array holds two arrays, left and right. Each value in these, define which types are forbidden and cannot
     * be used as values of the operands. The values must match one of the is_* PHP functions (is_array, is_null, etc.)
     *
     * @var string[][]|null
     */
    protected ?array $forbiddenTypes = [
        'left' => ['null', 'object', 'array'],
        'right' => ['null', 'object', 'array']
    ];

    /**
     * Creates a new Operation.
     *
     * @param mixed|null $leftOperand The left operand.
     * @param mixed|null $rightOperand The right operand.
     * @throws InvalidOperandException When an operand's type is invalid ({@see Operation::$forbiddenTypes}).
     */
    public function __construct(
        $leftOperand = null,
        $rightOperand = null
    ) {
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
        $this->checkOperandTypes();
        parent::__construct();
    }

    /**
     * Checks operands for validity.
     *
     * @throws InvalidOperandException When an operand's type is invalid.
     */
    private function checkOperandTypes(): void
    {
        if (is_array($this->forbiddenTypes) && array_key_exists('left', $this->forbiddenTypes)) {
            $this->checkOperand($this->leftOperand, $this->forbiddenTypes['left']);
        }
        if (is_array($this->forbiddenTypes) && array_key_exists('right', $this->forbiddenTypes)) {
            $this->checkOperand($this->rightOperand, $this->forbiddenTypes['right']);
        }
    }

    /**
     * Checks an operand for validity.
     *
     * @param mixed|null $operand The operand to be checked.
     * @param string[] $types An array of forbidden types
     * @throws InvalidOperandException Thrown when an operand's type is invalid.
     */
    private function checkOperand($operand, array $types): void
    {
        foreach ($types as $type) {
            try {
                $checker = new ReflectionFunction(sprintf("is_%s", $type));
                if ($checker->invoke($operand) === true) {
                    throw new InvalidOperandException(gettype($operand), self::class);
                }
            } catch (ReflectionException $re) {
                //@TODO: Implement proper exception:
                throw new Exception("Invalid check type " . $type);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf("%s %s %s", $this->leftOperand, $this->operator, $this->rightOperand);
    }
}
