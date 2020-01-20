<?php


namespace App\Http\Controllers\admin;


use App\Common\Response\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Admin;

class AdminController extends Controller
{

    public function list(){

       $data = Admin::paginate(15)->toArray();
       return JsonResponse::jsonPaginate($data);
    }
}
