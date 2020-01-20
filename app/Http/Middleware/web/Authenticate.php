<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/29
 * Time: 21:08
 */

namespace App\Http\Middleware\web;

use App\Common\Response\JsonResponse;
use App\Exceptions\admin\NoLoginException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * 是否已授权验证 中间件
 * Class Authenticate
 * @package App\Http\Middleware\web
 */
class Authenticate
{



    public function handle($request, \Closure $next)
    {
        $adminId = \session(Config::get('authenticate.session.admin.name'));
        if (!$adminId) {
            throw new NoLoginException();
        }
        return $next($request);
    }

}
