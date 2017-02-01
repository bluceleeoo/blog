<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login(){
        //echo 12345;
        if($input=Input::all()){
            //dd($input);
            $code=new \Code();
            $_code=$code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误!');
            }
            $user=User::first();
            if($user->user_name!=$input['user_name'] || Crypt::decrypt($user->user_pwd)!=$input['user_pwd']){
               return back()->with('msg','用户名或者密码不正确！');
            }
            session(['user'=>$user]);
            //dd(session('user'));
            //echo 'ok';
            return redirect('admin/index');
        }else{
            //dd($user);
           // session(['user'=>null]);情调session
            return view('admin.login');
        }
    }
    public function code(){
    //echo 12345;
    $code=new \Code();
    $code->make();
    //return view('admin.login');
}
    /*public function crypt(){
        //echo 12345;
        $str='123456';
     echo  Crypt::encrypt($str);
        echo "<hr/>";
        echo Crypt::decrypt('eyJpdiI6InNzaFk3dmtqbXBwWUdUeGVFQStCc0E9PSIsInZhbHVlIjoiQkJYVUxcL3FHMlRuMXErN0NzaHpIUFE9PSIsIm1hYyI6IjgzNGQ1YmM2N2Q5YjQwMmY3ZmRkNDBjZWQzOWJlODkxYjE4NDU4ZWUwMTQyYTE3NDc2ZGNkMzlkY2Q5ZjdjYmQifQ');
    }*/
    public function quit(){
       session(['user'=>null]);
        return redirect('admin/login');
    }
}
