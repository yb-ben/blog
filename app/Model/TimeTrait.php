<?php


namespace App\Model;


trait TimeTrait
{

    public function freshTimestamp()
    {
        return time();
    }

    public function fromDateTime($value)
    {
        return $value;
    }



    public function getDateFormat()
    {
        return 'U';
    }
}
