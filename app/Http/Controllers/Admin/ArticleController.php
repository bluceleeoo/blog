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
        $data =Article::orderBy('art_id','desc')->paginate(10);
        //dd($data->links());
       return view('admin.article.index',compact('data'));
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
    //get.admin/article/{article}/edit编辑分类
    public function edit($art_id){
        $data =(new Category())->tree();
        $field=Article::find($art_id);
        //dd($field);
        return view('admin.article.edit',compact('field','data'));
    }
    //put.admin/category/{category}更新分类
    public function update($art_id){
        $input=Input::except('_token','_method');
        $re=Article::where('art_id',$art_id)->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败，请稍后重试！');
        }
    }
    //delete.admin/article/{category}删除单个文章
    public function destroy($art_id){
        $re=Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '文章删除失败，请稍后重试！',
            ];
        }
        return $data;
    }


}
