<?php

namespace MilkoKosturkov\VC\UI\HTTP;

use MilkoKosturkov\VC\Common\DotNotionAccessorTrait;

class Request extends \stdClass {
    use DotNotionAccessorTrait;

    /**
     * @var array
     */
    private $server;

    /**
     * @var array
     */
    private $get;

    /**
     * @var array
     */
    private $post;

    /**
     * Request constructor.
     *
     * @param array $server
     * @param array $get
     * @param array $post
     */
    public function __construct(array $server, array $get, array $post) {
        $this->server = $server;
        $this->get = $get;
        $this->post = $post;
    }

    /**
     * @return static
     */
    public static function fromGlobals() {
        return new static($_SERVER, $_GET, $_POST);
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->server['REQUEST_METHOD'];
    }
}
