<?php


namespace App\Model;


class Role extends Base
{
    use Relation\Role;

    public $table = 'role';


    protected $fillable = ['name','desc','parent_id','path'];



    public function createGroup($data , Base $parent = null){

        if ($parent) {
            $data['parent_id'] = $parent->id;
            $data['path'] = $parent->path . '-'.$parent->id;
        }else{
            $data['parent_id'] = 0;
            $data['path'] = '';
        }

        return self::create($data);
    }
}
