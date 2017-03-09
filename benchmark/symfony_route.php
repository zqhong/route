<?php

require "vendor/autoload.php";

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;

$routes = new RouteCollection();
$routes->add('testa', new Route('/test/{a}'));
$routes->add('testb', new Route('/test/{a}{b}'));
$routes->add('testc', new Route('/test/{a}{b}{c}'));
$routes->add('testd', new Route('/test/{a}{b}{c}{d}'));
$routes->add('teste', new Route('/test/{a}{b}{c}{d}{e}'));

$context = new RequestContext('/');

$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match('/test/1');

print_r($parameters);
