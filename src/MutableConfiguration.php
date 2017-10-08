<?php

namespace MilkoKosturkov\VC;

class MutableConfiguration extends Configuration {

    private $values = [];

    public function set($key, $value) {
        $this->values[$key] = $value;
    }

    public function get($key, $default = null) {
        if (!isset ($this->values[$key])) {
            return parent::get($key, $default);
        }
        return $this->values[$key];
    }
}
