<?php

namespace Zqhong\Route;

use Zqhong\Route\Helpers\Arr;

class RouteDispatcher
{
    const FOUND = 0;
    const NOT_FOUND = 1;

    /**
     * @var RouteCollector
     */
    protected $routeCollector;

    /**
     * RouteDispatcher constructor.
     * @param RouteCollector $routeCollector
     */
    public function __construct(RouteCollector $routeCollector)
    {
        $this->routeCollector = $routeCollector;
    }

    /**
     * @param string $httpMethod
     * @param string $uri
     * @return array
     */
    public function dispatch($httpMethod, $uri)
    {
        $staticRoutes = $this->routeCollector->getStaticRoutes();

        if (isset($staticRoutes[$httpMethod][$uri])) {
            return [self::FOUND, $staticRoutes[$httpMethod][$uri]];
        } else {
            $combinedVarRoutes = $this->routeCollector->getCombinedVarRoutes($httpMethod);
            if (!empty($combinedVarRoutes)) {
                $regex = Arr::getValue($combinedVarRoutes, 'regex');
                $routeMap = Arr::getValue($combinedVarRoutes, 'routeMap');
                preg_match($regex, $uri, $matches, $matches);

                $cnt = count($matches);
                if (isset($routeMap[$cnt])) {
                    $handler = $routeMap[$cnt]['handler'];
                    $params = $routeMap[$cnt]['params'];

                    foreach ($params as $k => $v) {
                        $params[$k] = $matches[--$cnt];
                    }

                    return [self::FOUND, $handler, $params];
                }
            }
        }

        return [self::NOT_FOUND];
    }
}