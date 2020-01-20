<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class AdminAuthExt extends Pivot
{
    public $table = 'blog_admin_auth_ext';
}
