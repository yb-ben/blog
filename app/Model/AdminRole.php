<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class AdminRole extends Pivot
{
    public $table = 'blog_admin_role';
}
