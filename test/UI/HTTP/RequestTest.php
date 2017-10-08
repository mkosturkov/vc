<?php

namespace MilkoKosturkov\VC\UI\HTTP;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {

    public function testMethodGetter() {
        $request = new Request(['REQUEST_METHOD' => 'POST'], [], []);
        $this->assertEquals('POST', $request->getMethod());
    }

    public function testConstructorParams() {
        $request = new Request(['REQUEST_METHOD' => 'POST'], ['g1' => 'g'], ['p1' => 'p']);
        $this->assertTrue(is_array($request->getServer()));
        $this->assertEquals('g', $request->getGet()['g1']);
        $this->assertEquals('p', $request->getPost()['p1']);
    }

}
