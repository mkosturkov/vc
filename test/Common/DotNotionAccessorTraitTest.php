<?php

namespace MilkoKosturkov\VC\Common;

use PHPUnit\Framework\TestCase;

class DotNotionAccessorTraitTest extends TestCase {

    private $accessor;

    public function setUp() {
        parent::setUp();
        $this->accessor = new class {
            use DotNotionAccessorTrait;

            private $a = ['b' => 'c'];

            private function getD() {
                return 'd';
            }
        };
    }

    public function testPropertyAccessor() {
        $this->assertEquals('c', $this->accessor->{'a.b'});
    }

    public function testGetter() {
        $this->assertEquals('d', $this->accessor->d);
    }

}
