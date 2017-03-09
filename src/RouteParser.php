<?php

namespace zqhong\route;

class RouteParser
{
    protected $leftSeparator = '{';
    protected $rightSeparator = '}';

    /**
     * 解析路由：
     * e.g.
     * parse('/user/{id:\d+}', 'getUser') -> new Route('/user/(\d+)', 'getUser', ['id' => 'id"])
     *
     * @param string $route
     * @param $handler
     * @return array
     */
    public function parse($route, $handler)
    {
        $params = [];

        $leftPos = strpos($route, $this->leftSeparator);
        $rightPos = strpos($route, $this->rightSeparator);
        while (($leftPos || $rightPos) !== false && $rightPos > $leftPos) {
            $rule = substr($route, $leftPos, $rightPos - $leftPos + 1);
            list($paramName, $regex) = explode(':', trim($rule, '{}'), 2);
            $route = str_replace($rule, sprintf('(%s)', $regex), $route);
            $params[$paramName] = $paramName;

            $leftPos = strpos($route, $this->leftSeparator);
            $rightPos = strpos($route, $this->rightSeparator);
        }

        return new Route($route, $handler, $params);
    }
}
