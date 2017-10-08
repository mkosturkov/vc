<?php

namespace MilkoKosturkov\VC\Common;

use MilkoKosturkov\VC\Exceptions\InvalidArgumentTypeException;
use MilkoKosturkov\VC\Exceptions\UndefinedKeyException;
use PHPUnit\Framework\TestCase;

class DotNotionAccessorPorxyTest extends TestCase {

    public function testAccessingArray() {
        $arr = ['scalar' => 5, 'arr' => ['sub-arr' => ['a' => 'v1', 'b' => 'v2']]];
        $proxy = new DotNotionAccessorProxy($arr);
        $this->assertEquals(5, $proxy->scalar);
        $this->assertInstanceOf(DotNotionAccessorProxy::class, $proxy->arr);
        $this->assertInstanceOf(DotNotionAccessorProxy::class, $proxy->arr->{'sub-arr'});
        $this->assertEquals('v1', $proxy->{'arr.sub-arr.a'});
        $this->assertEquals('v2', $proxy->{'arr.sub-arr.b'});
    }

    public function testAccessingObject() {
        $obj = (object)[
            'scalar' => 5,
            'obj' => (object)[
                'sub-obj' => (object)[
                    'a' => 'v1',
                    'b' => 'v2'
                ]
            ]
        ];
        $proxy = new DotNotionAccessorProxy($obj);
        $this->assertEquals(5, $proxy->scalar);
        $this->assertInstanceOf(DotNotionAccessorProxy::class, $proxy->obj);
        $this->assertInstanceOf(DotNotionAccessorProxy::class, $proxy->obj->{'sub-obj'});
        $this->assertEquals('v1', $proxy->{'obj.sub-obj.a'});
        $this->assertEquals('v2', $proxy->{'obj.sub-obj.b'});
    }

    public function testExceptionOnInvalidProxiedType() {
        $this->expectException(InvalidArgumentTypeException::class);
        new DotNotionAccessorProxy(5);
    }

    public function testExceptionOnMissingKey() {
        $this->expectException(UndefinedKeyException::class);
        $proxy = new DotNotionAccessorProxy([]);
        $proxy->inexistent;
    }

    public function testGetterUsageOnObjects() {
        $obj = new class {

            public function getA() {
                return 5;
            }

            private function getB() {

            }
        };
        $proxy = new DotNotionAccessorProxy($obj);
        $this->assertEquals(5, $proxy->a);
        $this->expectException(UndefinedKeyException::class);
        $proxy->b;
    }

}
