<?php


namespace App\Model;


class Group extends Base
{

    public $table = 'group';

    protected $fillable = ['name','desc','parent_id','path'];






}
