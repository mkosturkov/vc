<?php

namespace MilkoKosturkov\VC\Common;

class UseCaseExecutionInfo {
    use ValidatedArrayFactoryTrait;

    /**
     * @var string
     */
    private $className;

    private $parametersMapping = [];

    private $viewClass = '';

    private function setParametersMapping(array $mapping) {
        $this->parametersMapping = $mapping;
    }

    private function setViewClass($class) {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException('View Class does not exist: ' . $class);
        }
        $this->viewClass = $class;
    }

    /**
     * @return string
     */
    public function getClassName() {
        return $this->className;
    }

    /**
     * @return array
     */
    public function getParametersMapping() {
        return $this->parametersMapping;
    }

    /**
     * @return string
     */
    public function getViewClass() {
        return $this->viewClass;
    }

}