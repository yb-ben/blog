<?php


namespace App\Events\Auth;


class BeforeAuthDelete
{

    protected $auth_id ;

    public function __construct($auth_id)
    {
        $this->auth_id = $auth_id;
    }
}
