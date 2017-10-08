<?php

namespace MilkoKosturkov\VC\Common;

use MilkoKosturkov\VC\Exceptions\InvalidArgumentTypeException;
use MilkoKosturkov\VC\Exceptions\UndefinedKeyException;

class DotNotionAccessorProxy {

    /**
     * @var array|object
     */
    private $data;

    /**
     * DotNotionAccessorProxy constructor.
     *
     * @param array|object $data
     *
     * @throws InvalidArgumentTypeException
     */
    public function __construct($data) {
        if (!is_array($data) && !is_object($data)) {
            throw new InvalidArgumentTypeException("Data of type object or array expected!");
        }
        $this->data = $data;
    }

    /**
     * @param string $name
     *
     * @return bool|float|int|string|static
     */
    public function __get($name) {
        $stack = $this->data;
        $parts = explode('.', $name);
        while (count ($parts) > 0) {
            $current = array_shift($parts);
            $stack = $this->getStackValue($current, $stack);
        }
        return is_scalar($stack) ? $stack : new static($stack);
    }

    private function getStackValue($key, $stack) {
        error_reporting(E_ALL);
        if (is_array($stack)) {
            if (isset ($stack[$key])) {
                return $stack[$key];
            }
            throw new UndefinedKeyException("Undefined key: $key");
        }
        if (isset ($stack->$key)) {
            return $stack->$key;
        }
        $getter = 'get' . ucfirst($key);
        $callback = [$stack, $getter];
        if (is_callable($callback)) {
            return $callback();
        }
        throw new UndefinedKeyException("Undefined key: $key");
    }
}