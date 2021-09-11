<?php

namespace MisterIcy\SqlQueryBuilder\Expressions;

/**
 * Trait OptionTrait.
 *
 * Provides the ability to expressions to implement extra options, such as Hinting.
 *
 * @author Alexandros Koutroulis <icyd3mon@gmail.com>
 * @license Apache-2.0
 * @since 0.1.0
 * @package MisterIcy\SqlQueryBuilder\Expression
 */
trait OptionTrait
{
    /**
     * An array of options to be passed to the expression.
     *
     * @var array<string, mixed>
     */
    protected array $options = [];

    /**
     * Gets the currently set options.
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Gets a single option if set.
     *
     * @param string $name The name of the option
     * @return mixed|null The value of the option or null if it is not set.
     */
    public function getOption(string $name)
    {
        if ($this->hasOption($name)) {
            return $this->options[$name];
        }
        return null;
    }

    /**
     * Checks if the statement has an option.
     *
     * @param string $name The name of the option
     * @return bool True if the option exists, otherwise false.
     */
    public function hasOption(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Sets an option.
     *
     * In case the option exists, it is overwritten.
     *
     * @param string $name The name of the option
     * @param mixed $value The value of the option
     * @return self
     */
    public function setOption(string $name, $value): self
    {
        if (!$this->hasOption($name)) {
            $this->options[$name] = $value;
        }
        return $this;
    }

    /**
     * Unsets an option if it exists.
     *
     * @param string $name The name of the option
     * @return self
     */
    public function unsetOption(string $name): self
    {
        if (!$this->hasOption($name)) {
            unset($this->options[$name]);
        }
        return $this;
    }

    /**
     * Sets options.
     *
     * Overwrites any options currently set.
     *
     * @param array<string, mixed> $options The options to be set.
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }
}
