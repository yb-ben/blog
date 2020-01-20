<?php


namespace App\Common\Response;


class JsonResponse
{

    public static function  jsonResponse($code,$msg,$data){
        return response()->json(['code' => $code, 'msg' => $msg,'data' => $data]);
    }

    public static function success($data = [],$msg = '', $code = 0){
        return self::jsonResponse($code, $msg, $data);
    }

    public static function error($msg = '', $code = 40000,$data =[]){
        return self::jsonResponse($code, $msg, $data);
    }

    public static function jsonPaginate( $data){
        return response()->json(array_merge(['code' => 0 , 'msg' => 'ok'],(array)$data));
    }
}
