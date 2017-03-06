<?php

namespace Zqhong\Route;

class RouteCollector
{
    /**
     * @var array 静态路由数组
     *
     * 数据结构：
     * ```
     * [
     *      'GET' => [
     *          '/route1' => 'handler1',
     *          '/route2' => 'handler2',
     *      ],
     *      'POST' => [
     *          '/route3' => 'handler3',
     *          '/route4' => 'handler4',
     *      ]
     * ]
     * ```
     */
    protected $staticRoutes;

    /**
     * @var array 动态路由数组（正则匹配）
     *
     * 数据结构：
     * ```
     * [
     *      'GET' => [
     *          '/user/(\d+) => [
     *              'params' => [
     *                  'id' => 'id',
     *              ],
     *              'handler' => 'handler0',
     *          ]
     *      ]
     * ]
     * ```
     */
    protected $variableRoutes;

    /**
     * @var RouteParser
     */
    protected $routeParser;

    /**
     * @var RouteGenerator
     */
    protected $routeGenerator;

    /**
     * RouteCollector constructor.
     * @param RouteParser $routeParser
     * @param RouteGenerator $routeGenerator
     */
    public function __construct(RouteParser $routeParser, RouteGenerator $routeGenerator)
    {
        $this->routeParser = $routeParser;
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * 添加路由规则
     *
     * @param string $httpMethod
     * @param string $route
     * @param string|array|\Closure $handler
     * @return bool
     */
    public function addRoute($httpMethod, $route, $handler)
    {
        /** @var Route $routeInstance */
        $routeInstance = $this->routeParser->parse($route, $handler);

        if ($this->isStaticRoute($routeInstance)) {
            $this->staticRoutes[$httpMethod][$route] = $handler;
        } else {
            $this->variableRoutes[$httpMethod][] = $routeInstance;
        }
    }

    /**
     * 判断所给路由是否静态路由
     *
     * @param Route $routeInstance
     * @return bool
     */
    protected function isStaticRoute($routeInstance)
    {
        if (empty($routeInstance->params)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getStaticRoutes()
    {
        return $this->staticRoutes;
    }

    /**
     * @return array
     */
    public function getVariableRoutes()
    {
        return $this->variableRoutes;
    }

    /**
     * @param string $httpMethod
     * @return array|bool
     */
    public function getCombinedVarRoutes($httpMethod)
    {
        if (empty($this->variableRoutes[$httpMethod])) {
            return false;
        }

        return $this->routeGenerator->combineVarRoutes($this->variableRoutes[$httpMethod]);
    }
}
