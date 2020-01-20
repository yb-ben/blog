<?php


namespace App\Exceptions\admin;
use App\Common\Response\JsonResponse;
use Exception;
use Illuminate\Contracts\Support\Renderable;

class NoLoginException extends Exception implements Renderable
{


    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return JsonResponse::error([], 'Please login.', 40001);
    }
}
