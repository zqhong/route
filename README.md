# Route - 一个快速的 PHP 路由实现
[![StyleCI](https://styleci.io/repos/84079657/shield?branch=master)](https://styleci.io/repos/84079657)
[![Build Status](https://travis-ci.org/zqhong/route.svg?branch=master)](https://travis-ci.org/zqhong/route)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zqhong/route/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zqhong/route/?branch=master)

思路参考[nikic/FastRoute](https://github.com/nikic/FastRoute)，实现原理：[Fast request routing using regular expressions](http://nikic.github.io/2014/02/18/Fast-request-routing-using-regular-expressions.html)。

---

# 示例代码
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

发送请求：
```
// 返回 404 NOT FOUND
$ curl http://example.com/?r=ops

// 返回：Your uid: 1
$ curl http://example.com/?=/user/1
```

---

# 性能测试
## 系统环境
* 操作系统：Ubuntu 16.04 LTS（Vultr 4核8G）
* PHP：7.0.4
* Apache：2.4.18

## 测试结果
![](http://ww1.sinaimg.cn/large/ce744de6gy1fdgwdy9aghj20pc0df3yh)
```
nikic_route(v1.2)
Requests per second:    3527.98 [#/sec] (mean)

symfony route(v3.2)
Requests per second:    5193.17 [#/sec] (mean)

zqhong route(dev-master)
Requests per second:    5923.56 [#/sec] (mean)
```


具体的测试代码和结果请看 `benchmark` 目录。