<?php

namespace Entryshop\Admin\Concerns;

use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * @property-read array $variables
 * @method static|array $context
 */
trait HasVariables
{
    /** @var array */
    protected $variables = [];

    /** @var array */
    protected $original_variables = [];

    protected function callHasVariables(string $method, array $parameters)
    {
        return match (count($parameters)) {
            1 => $this->set($method, $parameters[0]),
            0 => $this->get($method),
            default => null
        };
    }

    /**
     * Set variable(s)
     */
    public function set($key, $value = null): self
    {
        if (is_array($key)) {
            $this->variables = array_merge($this->variables, $key);
            return $this;
        }

        $this->variables[$key] = $value;
        return $this;
    }

    /**
     * Get variable value
     */
    public function get(string $key, $default = null)
    {
        return evaluate(
            $this->variables[$key] ?? $this->__getDefaultVariable($key, $default),
            $this
        );
    }

    /**
     * Get default variable value
     */
    private function __getDefaultVariable(string $key, $fallback = null)
    {
        $method = 'getDefault' . Str::studly($key);

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (method_exists($this, 'defaultVariables')) {
            $defaultVariables = $this->defaultVariables();
            return $defaultVariables[$key] ?? $fallback;
        }

        return $fallback;
    }

    /**
     * Get original variable
     */
    public function getOriginal(string $key, $default = null)
    {
        if (key_exists($key, $this->original_variables)) {
            return $this->original_variables[$key];
        }

        if (key_exists($key, $this->variables)) {
            return $this->variables[$key];
        }

        return $default;
    }

    /**
     * Check if variable exists
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->variables);
    }

    /**
     * Add array type variable
     *
     * @throws InvalidArgumentException
     */
    public function push(string $key, $value): self
    {
        $current = $this->variables[$key] ?? [];

        if (!is_array($current)) {
            throw new InvalidArgumentException("Variable '{$key}' is not an array");
        }

        $values                = is_array($value) ? $value : [$value];
        $this->variables[$key] = array_merge($current, $values);

        return $this;
    }

    /**
     * Get or push array type variable
     */
    public function getOrPush(string $key, $value = null)
    {
        if ($value === null) {
            $result = $this->get($key, []);
            return empty(array_keys($result)) ? array_unique($result) : $result;
        }

        return $this->push($key, $value);
    }


    /**
     * Get all variables
     */
    public function variables(): array
    {
        // store original variables
        if (empty($this->original_variables)) {
            $this->original_variables = $this->variables;
        }

        $variables = method_exists($this, 'defaultVariables')
            ? array_merge($this->defaultVariables(), $this->variables)
            : $this->variables;

        return array_map(
            fn($variable) => evaluate($variable, $this),
            $variables
        );
    }
}
