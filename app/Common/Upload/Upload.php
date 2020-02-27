<?php


namespace App\Common\Upload;


use App\Common\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

trait Upload
{

    protected $disk = 'testfile';
    protected $storageDriver = null;

    public function init()
    {
        $this->storageDriver = Storage::disk($this->disk);
    }


    /**
     * * 上传接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function upload(Request $request){
        $chunks = $request->post('chunks');//分片总数
        if($chunks === 1){
            return $this->unChunkUpload($request);
        }
        return $this->chunkUpload($request);
    }

    /**
     * 边上传边合并，分片必须使用同步上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
     public function chunkUpload(Request $request){
        $file = $request->file('file');
        $hash = md5($request->post('md5Value'));//完整文件hash值
        $chunks = (int)$request->post('chunks',0);//分片数量
        $chunk = (int)$request->post('chunk',0);//当前分片序号
        $size = (int)$request->post('size',0);//完整文件大小
        if(!$chunks || $chunk>$chunks || !$hash || !$size){
            return JsonResponse::error('参数错误');
        }
        if(!$file || !$file->isValid()){
            return JsonResponse::error('no file exists!');
        }
        $chunkDirName = 'chunk_'.$hash ;
        $this->mkChunkDir($chunkDirName);
        $chunkName = $chunkDirName . DIRECTORY_SEPARATOR .$chunk.'.tmp';
        $file->storeAs($this->disk,$chunkName);

         $fullpath = storage_path('app'.DIRECTORY_SEPARATOR.$this->disk).DIRECTORY_SEPARATOR. $hash;


         $mode = (($chunk === 0) ? 'w' : 'a');
         $fileObj = $file->openFile('r');
         $fileObj->rewind();
         $target = new File($fullpath,false);
         $targetObj = $target->openFile($mode);
         $fileObj->setMaxLineLen(409600);
         while (!$fileObj->eof()){
             $targetObj->fwrite($fileObj->fgets());
         }

        if($chunks-1 === $chunk){
            clearstatcache();
            if ($target->getSize() !== $size  ) {
                return JsonResponse::error('文件大小不正确');
            }
            if(md5(md5_file($fullpath)) !== $hash){
                return JsonResponse::error('文件不一致');
            }
            $ext = $target->guessExtension();
            $this->storageDriver->deleteDirectory($chunkDirName);
            if(!empty($ext)){
                rename($fullpath,$fullpath.".$ext");
            }
        }
        return JsonResponse::success();
    }

    /**
     * 不分片上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unChunkUpload(Request $request){
        $file = $request->file('file');
         if(!$file || !$file->isValid()){
            return JsonResponse::error('no file exists!');
        }
        $file->storeAs($this->disk,$file->hashName());
        return JsonResponse::success();
    }

    /**
     * 检查分片文件夹
     * @param $path
     */
    protected function mkChunkDir($path){
        $this->storageDriver->makeDirectory($path);
    }

    /**
     * 合并chunk
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mergeChunk(Request $request){
        $hash = md5($request->post('md5Value'));
        $size = (int)$request->post('size');
        $chunkDirName = 'chunk_'.$hash ;


        $chunkArray = $this->storageDriver->files($chunkDirName);
        $len = strlen($chunkDirName);
        array_walk($chunkArray,function (&$item)use($len){
            $item = substr($item, $len+1);
        });
        usort($chunkArray,function($a,$b){
           return (intval( substr($a, 0, strpos($a, '.')+1)) <  intval(substr($b, 0, strpos($b, '.')+1)))?-1:1;
        });

        $rootdir = storage_path('app').DIRECTORY_SEPARATOR.$this->disk.DIRECTORY_SEPARATOR;
        $fullChunkDirName =  $rootdir.$chunkDirName.DIRECTORY_SEPARATOR;
        $fullpath = $rootdir. Str::random(40);

        $target = new File($fullpath,false);
        $targetObj = $target->openFile('w');
         foreach ($chunkArray as $item) {
            $chunkFile = new \SplFileObject( $fullChunkDirName.$item, 'r');
            $chunkFile->rewind();
            $chunkFile->setMaxLineLen(409600);
            while (!$chunkFile->eof()){
                $targetObj->fwrite($chunkFile->fgets());
            }
        }
         clearstatcache();
        if($size === $target->getSize() && md5(md5_file($fullpath)) === $hash ){
            $ext = $target->guessExtension();
            if (!empty($ext)) {
                rename($fullpath, $fullpath . ".$ext");
            }
            \Illuminate\Support\Facades\File::deleteDirectory($fullChunkDirName);

            return JsonResponse::success();
        }
        //文件不一致
        unlink($fullpath);
        return JsonResponse::error();
    }

    /**
     * 检查分片或文件是否已存在
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request){
        $chunks = (int)$request->post('chunks');//分片总数
        $hash = md5($request->post('md5Value'));//文件MD5
        $size = (int)$request->post('size');//文件大小
        if(!$chunks ||  $chunks === 1 ){
            //未分片
            if($this->storageDriver->exists($hash) && $this->storageDriver->size($hash) === $size){
                return JsonResponse::error('文件已存在');
            }
            return JsonResponse::success();
         }else{

            $chunk = $request->post('chunk');
            $chunkDirName = 'chunk_'.$hash ;
            $this->mkChunkDir($chunkDirName);
            $chunkName = $chunkDirName . DIRECTORY_SEPARATOR . $chunk.'.tmp';

            if($this->storageDriver->exists($chunkName)  &&  $this->storageDriver->size($chunkName) === $size){
                return JsonResponse::error('分片已存在');

            }
            return JsonResponse::success();
        }
    }


    public function _chunkUpload(Request $request){
        $file = $request->file('file');
        $hash = md5($request->post('md5Value'));//完整文件hash值
        $chunks = (int)$request->post('chunks',0);//分片数量
        $chunk = (int)$request->post('chunk',0);//当前分片序号
        if(!$chunks || $chunk>$chunks || !$hash ){
            return JsonResponse::error('参数错误');
        }
        if(!$file || !$file->isValid()){
            return JsonResponse::error('no file exists!');
        }
        $chunkDirName = 'chunk_'.$hash ;
        $this->mkChunkDir($chunkDirName);
        $chunkName = $chunkDirName . DIRECTORY_SEPARATOR .$chunk.'.tmp';
        $file->storeAs($this->disk,$chunkName);

        return JsonResponse::success();
    }
}
