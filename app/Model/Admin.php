<?php


namespace App\Model;


class Admin extends Base
{

    public $table = 'admin';

    protected $casts = [

        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];


    public function role(){
        return $this->belongsToMany(Role::class, AdminRole::class, 'admin_id','role_id');
    }


    public function authExt(){
        return $this->belongsToMany(Auth::class, AdminAuthExt::class, 'admin_id','auth_id');
    }

}
