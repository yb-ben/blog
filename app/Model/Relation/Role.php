<?php


namespace App\Model\Relation;


use App\Model\Admin;
use App\Model\AdminRole;
use App\Model\Auth;
use App\Model\RoleAuth;

trait Role
{
    public function auth(){
        return $this->belongsToMany(Auth::class, RoleAuth::class, 'role_id','auth_id');
    }

    public function admin(){
        return $this->belongsToMany(Admin::class, AdminRole::class, 'role_id','auth_id');
    }


}
