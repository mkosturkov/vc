<?php

namespace MilkoKosturkov\VC;

use PHPUnit\Framework\TestCase;

class MutableConfigurationTest extends TestCase {

    /**
     * @var MutableConfiguration
     */
    private $config;

    public function setUp() {
        $this->config = new MutableConfiguration();
    }

    public function testSettingAndGetting() {
        $this->config->set('test.key', 'hello, world');
        $this->assertEquals('hello, world', $this->config->get('test.key'));
    }

}
