<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Model\Article;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{//get.admin/article全部文章列表
    public function index(){
        echo '全部文章列表';
    }
    //get.admin/article/create添加分文章
    public function create(){
        $data=(new Category)->tree();
       return view('admin.article.add',compact('data'));
    }
    //post.admin/article 添加文章提交
    public function store(){
        $input=Input::except('_token');
        $input['art_time']=time();
        //验证规则
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message=[
            'art_title.required'=>'文章标题不能为空！',
            'art_content.required'=>'文章内容不能为空！',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            // echo 'no';
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
        }
    }
}
