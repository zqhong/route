# Route - A fast route implemented by php
[![StyleCI](https://styleci.io/repos/84079657/shield?branch=master)](https://styleci.io/repos/84079657)
[![Build Status](https://travis-ci.org/zqhong/route.svg?branch=master)](https://travis-ci.org/zqhong/route)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zqhong/route/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zqhong/route/?branch=master)

`zqhong/route` 参考了 [nikic/FastRoute](https://github.com/nikic/FastRoute)。但它比 `FastRoute` 更快、更简单。


* [README English](README.md)
* [README 简体中文](README_ZH_CN.md)

---

# 安装
```
$ composer require -vvv "zqhong/route:dev-master"
```

# 示例
```
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

```

Using CURL send request：
```
// 返回：404 NOT FOUND
$ curl http://example.com/?r=ops

// 返回： Your uid: 1
$ curl http://example.com/?=/user/1
```

---

# 性能测试
## 系统环境
* 操作系统：Ubuntu 16.04 LTS（Vultr 4Cores 8G memory）
* PHP：7.0.4
* Apache：2.4.18

## 性能测试结果
![](http://ww1.sinaimg.cn/large/ce744de6gy1fdgwdy9aghj20pc0df3yh)
```
nikic_route(v1.2)
Requests per second:    3527.98 [#/sec] (mean)

symfony route(v3.2)
Requests per second:    5193.17 [#/sec] (mean)

zqhong route(dev-master)
Requests per second:    5923.56 [#/sec] (mean)
```

Benchmark test code and result in `benchmark` folder.

---

# 文档
[zqhong/route 的实现原理](http://nikic.github.io/2014/02/18/Fast-request-routing-using-regular-expressions.html)