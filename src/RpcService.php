<?php
/**
 * Created by PhpStorm.
 * User: wyr6512
 * Date: 2019/4/3
 * Time: 9:28
 */

namespace wyr6512\laraveljsonrpc;

use Closure;
use Hprose\Filter\JSONRPC\ServiceFilter;
use Hprose\Http\Server;
use Illuminate\Http\Request;
use stdClass;

class RpcService
{
    public function init(){
        $server = new Server();
        //定义需要远程调用的控制器并设置其别名
        $classes = config('rpc');
        //$server->debug=true;
        //中间件
        $requestHandler = function ($name, array &$args, stdClass $context, Closure $next) {
            //模拟request
            $req = app('request');
            $request = new Request();
            $request->server->add($req->server());
            $request->headers->add($req->header());
            $request->replace($args);
            //重置参数
            $params = [$request];
            for ($i = 3; $i < count($args); $i++) {
                $params[] = $args[$i];
            }
            $result = $next($name, $params, $context);
            return $result;
        };
        foreach ($classes as $item) {
            if (is_array($item)) {
                $class = $item[0];
                $alias = $item[1];
            } else {
                $class = $item;
                $aliasExplode = explode('\\', get_class($item));
                $alias = $aliasExplode[count($aliasExplode) - 1];
            }
            $server->addFilter(new ServiceFilter());//jsonrpc过滤器
            $server->addInstanceMethods($class, '', $alias);

        }
        $server->addInvokeHandler($requestHandler);
        $server->start();
    }
}