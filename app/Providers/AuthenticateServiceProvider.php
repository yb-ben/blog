<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/3
 * Time: 21:00
 */

namespace App\Providers;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AuthenticateServiceProvider extends ServiceProvider
{
    public function register()
    {
        Config::get('authenticate.web');
    }


}