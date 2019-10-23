<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/29
 * Time: 21:08
 */

namespace App\Http\Middleware\web;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * 是否已授权验证 中间件
 * Class Authenticate
 * @package App\Http\Middleware\web
 */
class Authenticate
{

    protected $rediretTo = '/';
    protected $key = '';

    public function __construct()
    {
        $this->key = Config::get('authenticate.session.name');
    }

    public function handle($request, \Closure $next)
    {
        if (!Session::has($this->key)) {
            return redirect($this->rediretTo);
        }
        $data = Session::set($this->key);
        if(empty($data)){
            return redirect($this->rediretTo);
        }

        return $next($request);
    }

}