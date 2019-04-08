<?php
/**
 * Created by PhpStorm.
 * User: wyr6512
 * Date: 2019/4/4
 * Time: 15:03
 */

namespace wyr6512\laraveljsonrpc;

use Illuminate\Support\ServiceProvider;

class RpcServiceProvider extends ServiceProvider
{
    public function boot(){

    }
    public function register(){
        $this->app->singleton('laravel-jsonrpc', function(){
            return new RpcService();
        });
    }

}