<?php


namespace App\Http\Controllers\admin;


use App\Common\Response\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Role;
use Huyibin\Struct\Tree;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    //列表
    public function list(){
        $data  =Tree::tree( Role::select('id','name as text','parent_id','path','desc')->get()->toArray() );
        return JsonResponse::success(array_column($data,null));
    }


    //添加角色
    public function add(Request $request,$pid){

        $data= $request->post();
        $group = new Role();
        if($pid){
            $parent = $group->find($pid);
        }
        $group->createGroup($data, $parent?:null);
        return JsonResponse::success();
    }


    //编辑角色
    public function edit(Request $request,$id){
        $data= $request->post();
        $group = Role::find($id);
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
        $group = Role::find($id);
        return JsonResponse::success($group);
    }

    public function delete(){

    }
}
