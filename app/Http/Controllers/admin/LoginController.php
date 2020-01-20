<?php


namespace App\Http\Controllers\admin;


use App\Common\Response\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * 密码登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginPwd(Request $request){
       $data = $request->post();
        $validator = Validator::make($data,[
            'usn' => [
                'required',
                'max:255',
            ],
            'pwd' =>[
                'required',
                'max:255'
            ]
        ]);
       if($validator->fails()){
           return JsonResponse::error($validator->errors());
       }
        $admin = Admin::where('usn',$data['usn'])->first();
       if(empty($admin)){
           return JsonResponse::error('该账号不存在');
       }
       if($admin->pwd === password_hash($data['pwd'],PASSWORD_DEFAULT) ){
           return JsonResponse::error('密码不正确');
       }
        session(Config::get('authenticate.session.admin.name'));
        return JsonResponse::success();
    }

}
