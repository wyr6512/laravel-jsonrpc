# laravel-jsonrpc
基于hprose的jsonrpc，适用于laravel框架，可以像api一样调用



此扩展是用于将controller中的方法当做jsonrpc服务调用，调用方式类似于api

### 安装

```php
composer require "wyr6512/laravel-jsonrpc"
```

### 配置

config/app.php

```php
'providers' => [
  	// ...
  	wyr6512\laraveljsonrpc\RpcServiceProvider::class,
]
```

routes/api.php，此处路由可自定义为其他形式

```php
Route::any('jrpc', function (){
    app('laravel-jsonrpc')->init();
});
```

config目录下添加rpc.php文件，内容如下示例：

```php
<?php
//数组中添加要开放的rpc服务
return [
    [new App\Http\Controllers\TestController(), 'test'],//调用方法：如TestController中有add方法，那么调用方法名为test_add
];
```

### 调用示例

```php
curl -H "Content-Type:application/json" -d '{"id":"1","jsonrpc":"2.0","method":"test_add","params":[{"a":3, "b": 4}]' http://localhost/api/jrpc

返回结果：{"id":"1","jsonrpc":"2.0","result":7}
```



参考

https://www.liangzl.com/get-article-detail-29448.html

http://blog.zhouchenxi.cn/post/59.html

