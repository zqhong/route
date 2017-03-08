# Route - 一个高性能的 PHP 路由实现
[![StyleCI](https://styleci.io/repos/84079657/shield?branch=master)](https://styleci.io/repos/84079657)
[![Build Status](https://travis-ci.org/zqhong/route.svg?branch=master)](https://travis-ci.org/zqhong/route)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zqhong/route/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zqhong/route/?branch=master)

思路参考[nikic/FastRoute](https://github.com/nikic/FastRoute)，实现原理：[Fast request routing using regular expressions](http://nikic.github.io/2014/02/18/Fast-request-routing-using-regular-expressions.html)。

# Example
```
<?php

use Zqhong\Route\Helpers\Arr;
use Zqhong\Route\RouteCollector;
use Zqhong\Route\RouteDispatcher;

require "vendor/autoload.php";

function getUser($uid)
{
    echo "Your uid: " . $uid;
}

/** @var RouteDispatcher $routeDispatcher */
$routeDispatcher = dispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/user/{id:\d+}', 'getUser');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = Arr::getValue($_GET, 'r');
$routeInfo = $routeDispatcher->dispatch($httpMethod, $uri);

if (Arr::getValue($routeInfo, 'isFound')) {
    $handler = Arr::getValue($routeInfo, 'handler');
    $params = Arr::getValue($routeInfo, 'params');
    call_user_func_array($handler, $params);
} else {
    exit('404 NOT FOUND');
}
```
