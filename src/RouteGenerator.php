<?php

namespace zqhong\route;

class RouteGenerator
{
    /**
     * 将多个独立的动态路由表达式合并为一个
     *
     * @param array $varRoutes
     * @return array|bool
     */
    public function combineVarRoutes($varRoutes)
    {
        if (empty($varRoutes)) {
            return false;
        }

        $routeMap = $regexes = [];
        $numGroups = 0;

        /** @var Route $route */
        foreach ($varRoutes as $route) {
            $numVariables = count($route->params);
            $numGroups = max($numGroups, $numVariables);

            $regexes[] = $route->route . str_repeat('()', $numGroups - $numVariables);
            $routeMap[$numGroups + 1] = [
                'handler' => $route->handler,
                'params' => $route->params,
            ];

            ++$numGroups;
        }

        $regex = sprintf('~^(?|%s)$~', implode('|', $regexes));
        return [
            'regex' => $regex,
            'routeMap' => $routeMap,
        ];
    }
}
