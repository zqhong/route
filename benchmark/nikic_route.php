<?php

require 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/test/{a:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}{c:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}{c:\d+}{d:\d+}', 'test');
    $r->addRoute('GET', '/test/{a:\d+}{b:\d+}{c:\d+}{d:\d+}{e:\d+}', 'test');
});

// Fetch method and URI from somewhere
$httpMethod = 'GET';
$uri = '/test/1';

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

print_r($routeInfo);
