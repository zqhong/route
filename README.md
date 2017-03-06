# Route - 一个高性能的 PHP 请求路由
思路参考[nikic/FastRoute](https://github.com/nikic/FastRoute)，实现原理：[Fast request routing using regular expressions](http://nikic.github.io/2014/02/18/Fast-request-routing-using-regular-expressions.html)。

# Example
```
<?php

use Zqhong\Route\RouteCollector;

require "vendor/autoload.php";

$routeDispatcher = dispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/user/{id:\d+}', 'getUser');
});

$httpMethod = 'GET';
$uri = '/user/1';
$r = $routeDispatcher->dispatch($httpMethod, $uri);

print_r($r);
```