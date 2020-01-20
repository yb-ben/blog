<?php


namespace App\Http\Controllers\admin;


use App\Common\Response\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Role;

class IndexController extends Controller
{

    public function index(){

       $admin = Admin::with(['role.auth','authExt'])->get();
       $roles = Role::with(['auth',])->get();
        return JsonResponse::success(['admin' =>$admin ,'role' => $roles]);
    }


    public function check(){

    }
}
