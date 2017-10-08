<?php

namespace MilkoKosturkov\VC\UI\HTTP;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {

    public function testMethodGetter() {
        $request = new Request(['REQUEST_METHOD' => 'POST'], [], []);
        $this->assertEquals('POST', $request->method);
    }

    public function testConstructorParams() {
        $request = new Request(['REQUEST_METHOD' => 'POST'], ['g1' => ['g2' => 'g']], ['p1' => ['p2' => 'p']]);
        $this->assertTrue(is_array($request->server));
        $this->assertEquals('g', $request->{'get.g1.g2'});
        $this->assertEquals('p', $request->{'post.p1.p2'});
    }

}
