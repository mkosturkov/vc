<?php

namespace MilkoKosturkov\VC\UI\HTTP;

class Request {

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

    /**
     * @return array
     */
    public function getServer(): array {
        return $this->server;
    }

    /**
     * @return array
     */
    public function getGet(): array {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getPost(): array {
        return $this->post;
    }
}
