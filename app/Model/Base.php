<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Huyibin\Struct\Tree;

class Base extends Model
{


    protected $prefix = 'blog_';

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = $this->prefix . $this->table;
    }


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
