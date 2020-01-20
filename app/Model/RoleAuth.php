<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleAuth extends Pivot
{
    public $table = 'blog_role_auth';
}
