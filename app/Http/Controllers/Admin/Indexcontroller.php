<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index(){
        return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }
    //更改超级管理员密码
    public function pass(){
        if($input=Input::all()){
            //dd($input);
            $rules=[
                'password'=>'required|between:6,20|confirmed',
            ];
            $message=[
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'确认密码和新密码不一致！',
            ];
            $validator=Validator::make($input,$rules);
            if($validator->passes()){
                //echo 'yes';
              $user= User::first();
              $_password= Crypt::decrypt($user->user_pwd);
                //echo$_password;
                if($input['password_o']==$_password){
                    $user->user_pwd=Crypt::encrypt($input['password']);
                    $user->update();
                    return redirect('admin/info');
                }else{
                    return back()->with('errors','原密码错误');
                }
            }else{
                // echo 'no';
                //dd($validator->errors()->all());
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }

    }
}
