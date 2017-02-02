<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload(){
        $file=Input::file('Filedata');
       // dd($file);
        if($file->isValid()){
            $extension=$file->getClientOriginalExtension();//上传文件后缀
            $newName=date('YmdHis').mt_rand(100,999).'.'.$extension;//新文件名

            $path=$file->move(base_path().'/uploads',$newName);
//            echo $path;
           $filePath= 'uploads/'.$newName;
            return $filePath;
;        }
    }
}
