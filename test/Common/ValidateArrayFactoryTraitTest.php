<?php

namespace MilkoKosturkov\VC\Common;

use PHPUnit\Framework\TestCase;

class ArrayFactoryTraitTestImpl {
    use ValidatedArrayFactoryTrait;

    private $noSetter;

    private $setter;

    private function setSetter($value) {
        $this->setter = $value + 1;
    }

    public function getNoSetter() {
        return $this->noSetter;
    }

    public function getSetter() {
        return $this->setter;
    }
}

class ValidateArrayFactoryTraitTest extends TestCase {

    public function testReturnClass() {
        $this->assertInstanceOf(
            ArrayFactoryTraitTestImpl::class,
            ArrayFactoryTraitTestImpl::fromArray(['setter' => 1, 'noSetter' => 1])
        );
    }

    public function testSettingWithNoSetter() {
        $inst = ArrayFactoryTraitTestImpl::fromArray(['noSetter' => 1, 'setter' => 1]);
        $this->assertEquals(1, $inst->getNoSetter());
    }

    public function testSettingWithSetter() {
        $inst = ArrayFactoryTraitTestImpl::fromArray(['setter' => 1, 'noSetter' => 1]);
        $this->assertEquals(2, $inst->getSetter());
    }

    public function testExceptionOnValidationFailure() {
        $this->expectException(\InvalidArgumentException::class);
        ArrayFactoryTraitTestImpl::fromArray(['except' => true]);
    }

}
