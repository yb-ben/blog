<?php


namespace App\Http\Controllers\admin;

use App\Common\Response\JsonResponse;
use App\Common\Upload\Upload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class TestController extends Controller
{

    use Upload;

    public function __construct()
    {

        $this->init();
    }

    public function  test(){
//        $old = storage_path('app' . DIRECTORY_SEPARATOR . $this->disk) . DIRECTORY_SEPARATOR . '543c6b61b938483f72759310c56dc587.flv';
//        $target = new File($old);
//        $targetObj = $target->openFile('w');
//        unlink($old);
        $this->storageDriver->deleteDirectory('chunk_543c6b61b938483f72759310c56dc587');
       //dump( $this->storageDriver->allFiles('chunk_543c6b61b938483f72759310c56dc587'));
    }
}
