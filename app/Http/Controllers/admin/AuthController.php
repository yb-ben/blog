<?php


namespace App\Http\Controllers\admin;


use App\Common\Response\JsonResponse;
use App\Events\Auth\BeforeAuthDelete;
use App\Http\Controllers\Controller;
use App\Model\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //权限列表
    public function list(){
//        $auths = Auth::all()->keyBy('id')->toArray();
//
//        foreach ($auths as $k=> &$auth) {
//            if($auth['parent_id'] === 0){
//                $auth['children'] = [];
//            }else{
//                $auths[$auth['parent_id']]['children'][$auth['id']] = $auth;
//                unset($auths[$k]);
//            }
//
//        }
        $auths = new Auth;
        return JsonResponse::success($auths->tree());
    }

    //权限详情
    public function detail($id){
        $auth = Auth::find($id);
        return JsonResponse::success($auth);
    }

    //添加权限
    public function add(Request $request){

        $data = $request->post();
        Auth::create($data);
        return JsonResponse::success();
    }

    //编辑权限
    public function edit(Request $request,$id){

        $data = $request->post();
        $auth = Auth::find($id);
        $auth->fill($data);
        $auth->save();
        return JsonResponse::success();
    }


    //删除权限
    public function delete($id){

        DB::transaction(function()use($id){
            event(new BeforeAuthDelete($id));


        });
        return JsonResponse::success();
    }


    public function batchDelete(Request $request){

        $ids = $request->post('ids');
        foreach ($ids as $item){
            DB::transaction(function()use($item){
                event(new BeforeAuthDelete($item));

            });
        }
        return JsonResponse::success();
    }

}
