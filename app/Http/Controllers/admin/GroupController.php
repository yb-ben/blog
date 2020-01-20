<?php


namespace App\Http\Controllers\admin;


use App\Common\Response\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    //分组列表
    public function list(){
        $group = new Group;
        return JsonResponse::success($group->tree());
    }


    //添加分组
    public function add(Request $request,$pid){

        $data= $request->post();
        $group = new Group;
        if($pid){
            $parent = $group->find($pid);
        }
        $group->createGroup($data, $parent?:null);
        return JsonResponse::success();
    }

    //编辑分组
    public function edit(Request $request,$id){
        $data= $request->post();
        $group = Group::find($id);
        if(!$group){
            return JsonResponse::error();
        }
        $group->name = $data['name'];
        $group->desc = $data['desc'];
        $group->save();
        return JsonResponse::success();
    }


    //详情
    public function detail($id){
        $group = Group::find($id);
        return JsonResponse::success($group);
    }

    public function delete(){

    }


}
