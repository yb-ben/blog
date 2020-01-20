<?php


namespace App\Model;


class Auth extends Base
{

    public $table = 'auth';
    public function role(){
        return $this->belongsToMany(Role::class, RoleAuth::class, 'role_id','auth_id');
    }
}
