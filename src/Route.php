<?php

namespace zqhong\route;

class Route
{
    /**
     * @var string
     */
    public $route;

    /**
     * @var string|array|\Closure
     */
    public $handler;

    /**
     * @var array
     */
    public $params;

    /**
     * Route constructor.
     * @param string $route
     * @param array|\Closure|string $handler
     * @param array $params
     */
    public function __construct($route, $handler, array $params)
    {
        $this->route = $route;
        $this->handler = $handler;
        $this->params = $params;
    }
}
