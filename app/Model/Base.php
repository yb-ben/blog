<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

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

    public function tree(){

        $groups = $this->all()->toArray();
        $groups = array_column($groups, null, 'id');


        foreach ($groups as $k => &$value){

            if($value['parent_id']){
                $groups[$value['parent_id']]['nodes'][] = &$value;
            }
        }

            foreach ($groups as $k => $value){
                if($value['parent_id']){
                    unset($groups[$k]);
                }
            }

        return $groups;
    }

}
