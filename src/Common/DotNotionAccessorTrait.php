<?php

namespace MilkoKosturkov\VC\Common;

trait DotNotionAccessorTrait {

    public function __get($name) {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func([$this, $method]);
        }
        return $this->get($name);
    }

    public function get($accessor) {
        $parts = explode('.', $accessor);
        $prop = array_shift($parts);
        $value = $this->$prop;
        while (count($parts) > 0) {
            $key = array_shift($parts);
            $value = $value[$key];
        }
        return $value;
    }

}
