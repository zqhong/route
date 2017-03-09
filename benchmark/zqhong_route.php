<?php

use Zqhong\Route\Helpers\Arr;
use Zqhong\Route\RouteCollector;
use Zqhong\Route\RouteDispatcher;

require "vendor/autoload.php";


/** @var RouteDispatcher $routeDispatcher */
$routeDispatcher = dispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/test/{a:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}{c:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}{c:\d+}{d:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}{c:\d+}{d:\d+}{e:\d+}', 'test');
});

$httpMethod = 'GET';
$uri = '/test/1';
$routeInfo = $routeDispatcher->dispatch($httpMethod, $uri);

print_r($routeInfo);
