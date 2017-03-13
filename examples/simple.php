<?php

use zqhong\route\Helpers\Arr;
use zqhong\route\RouteCollector;
use zqhong\route\RouteDispatcher;

require dirname(__DIR__) . "/vendor/autoload.php";

function getUser($uid)
{
    echo "Your uid: " . $uid;
}

/** @var RouteDispatcher $routeDispatcher */
$routeDispatcher = dispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/user/{id:\d+}', 'getUser');
});

$httpMethod = 'GET';
$uri = '/user/1';
$routeInfo = $routeDispatcher->dispatch($httpMethod, $uri);

if (Arr::getValue($routeInfo, 'isFound')) {
    $handler = Arr::getValue($routeInfo, 'handler');
    $params = Arr::getValue($routeInfo, 'params');
    call_user_func_array($handler, $params);
} else {
    echo '404 NOT FOUND';
}
