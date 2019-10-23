<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/30
 * Time: 20:47
 */

namespace App\Common\JWT;

use App\Common\JWT\Exception\JWTException;
use App\Common\JWT\Exception\ExpiredException;
use App\Common\JWT\Exception\RefreshException;
use Firebase\JWT\JWT as FirebaseJWT;
use Illuminate\Support\Facades\Redis;

class JWT
{

    private $secret = null;
    private $default ;
    private $expire ; //过期时间
    private $refresh ;//refreshToken有效时间
    private $blackListKey;

    public function __construct($secret,$expire,$refresh,$default = [],$blackListKey='jwt:bl')
    {
        $this->secret = $secret;
        $this->default = $default;
        $this->expire = $expire;
        $this->refresh = $refresh;
        $this->blackListKey = $blackListKey;
    }



    public function create($data){
        $payload = $this->default;
        $payload = array_merge($payload, $data);
        $this->_set($payload);
        return FirebaseJWT::encode($payload, $this->secret);
    }

    private function _set(&$payload,$expire = 0){
        $time = time();
        $expire = (empty($expire) ? $this->expire : $expire);
        $payload['exp'] = $time + $expire;
        $payload['nbf'] = $time;
        $payload['iat'] = $time;
        $payload['refreshToken'] = md5(uniqid());
        $payload['refreshTime'] =$payload['exp'] + $this->refresh;

        return $this;
    }


    public function parse($token){
        $tks = explode('.',$token);
        if (count($tks) !== 3) {
            throw new JWTException('Wrong number of segments');
        }
        list($headb64, $bodyb64, $cryptob64) = $tks;
        if (null === ($header = FirebaseJWT::jsonDecode(FirebaseJWT::urlsafeB64Decode($headb64)))) {
            throw new JWTException('Invalid header encoding');
        }
        if (null === $payload = FirebaseJWT::jsonDecode(FirebaseJWT::urlsafeB64Decode($bodyb64))) {
            throw new JWTException('Invalid claims encoding');
        }
        if (false === ($sig = FirebaseJWT::urlsafeB64Decode($cryptob64))) {
            throw new JWTException('Invalid signature encoding');
        }
        if (empty($header->alg)) {
            throw new JWTException('Empty algorithm');
        }
        if ('HS256' !== $header->alg) {
            throw new JWTException('Algorithm not allowed');
        }
        $ref = new \ReflectionMethod(FirebaseJWT::class,'verify');

        // Check the signature
        if (!$ref->invoke(null, "$headb64.$bodyb64", $sig, $this->secret, $header->alg)) {
            throw new JWTException('Signature verification failed');
        }

        return $payload;
    }



    public function refresh($oldToken)
    {
        $payload = $this->parse($oldToken);

            $time = time();
            if (!(isset($payload['refreshToken']) && isset($payload['refreshTime']))){
                throw new RefreshException('Token参数错误！');
            }
            if ($time > $payload['refreshTime']) {
                throw new RefreshException('刷新时间已无效！');
            }

            $redis = Redis::connection();
            $newToken = $this->create($payload);

            $ret = $redis->set('jwt:'.$payload['refreshToken'],$newToken,['nx','ex'=>30]);
            if ($ret === false) {
                $existNewToken = $redis->get('jwt:' . $payload['refreshToken']);
                if ($existNewToken === false) {
                    throw new RefreshException('刷新时间已无效！');
                }
                return $existNewToken;
            }
            return $newToken;
    }



}