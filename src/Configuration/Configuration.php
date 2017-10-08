<?php

namespace MilkoKosturkov\VC\Configuration;

use MilkoKosturkov\VC\Common\DotNotionAccessorProxy;
use MilkoKosturkov\VC\Exceptions\UndefinedKeyException;

class Configuration {

    /**
     * @var DotNotionAccessorProxy
     */
    private $data;

    /**
     * Configuration constructor.
     *
     * @param DotNotionAccessorProxy $source
     */
    public function __construct(DotNotionAccessorProxy $source) {
        $this->data = $source;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return bool|float|int|mixed|string|DotNotionAccessorProxy
     * @throws UndefinedKeyException
     */
    public function get($key, ...$args) {
        try {
            return $this->data->$key;
        } catch (UndefinedKeyException $e) {
            if (count($args) > 0) {
                return $args[0];
            }
            throw $e;
        }
    }

}