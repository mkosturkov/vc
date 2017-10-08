<?php

namespace MilkoKosturkov\VC\Common;

trait ValidatedArrayFactoryTrait {

    protected function __construct() {}

    private function getDataForValidation() {
        return $this;
    }

    private function validate() {
        foreach ($this->getDataForValidation() as $prop => $value) {
            if (is_null($value)) {
                throw new \InvalidArgumentException("Null field value: $prop!");
            }
        }
        return true;
    }

    public static function fromArray(array $arr) {
        $instance = new static();
        foreach ($arr as $prop => $value) {
            $setter = 'set' . $prop;
            if (method_exists($instance, $setter)) {
                call_user_func([$instance, $setter], $value);
            } else {
                $instance->$prop = $value;
            }
        }
        if (!$instance->validate()) {
            throw new \InvalidArgumentException('Invalid values for object!');
        }
        return $instance;
    }

}
