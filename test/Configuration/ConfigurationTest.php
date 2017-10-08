<?php

namespace MilkoKosturkov\VC\Configuration;

use MilkoKosturkov\VC\Common\DotNotionAccessorProxy;
use MilkoKosturkov\VC\Exceptions\UndefinedKeyException;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase {

    /**
     * @var Configuration
     */
    private $config;

    public function setUp() {
        parent::setUp();
        $this->config = new Configuration(new DotNotionAccessorProxy(['a' => 5]));
    }

    public function testGet() {
        $this->assertEquals(5, $this->config->get('a'));
        $this->assertEquals(6, $this->config->get('b', 6));
        $this->expectException(UndefinedKeyException::class);
        $this->config->get('c');
    }

}
