<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController{
    //get.admin/category全部分类列表
    public function index(){
        $categorys=(new Category)->tree();
//        dd($categorys);
//        echo 'get.admin/category';
        //$data=$this->getTree($categorys,'cate_name','cate_id','cate_pid');
        return view('admin.category.index')->with('data',$categorys);
    }

    public function changeOrder()
    {
        //echo 123;
        $input=Input::all();
        //echo $input['cate_order'];?没有结果，报500错误
        $cate=Category::find($input['cate_id']);
        $cate->cate_order=$input['cate_order'];
        $re=$cate->update();
        //echo $re;
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'分类排序更新成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'分类排序更新失败，请稍后重试',
            ];
        }
        return $data;
    }

    //post.admin/category
    public function store(){

    }
    //get.admin/category/create添加分类
    public function create(){
        //echo '添加分类';
        return view('admin/category/add');
    }
    //get.admin/category/{category}显示单个分类信息
    public function show(){

    }
    //delete.admin/category/{category}删除单个分类
    public function destroy(){

    }
    //put.admin/category/{category}更新分类
    public function update(){

    }
    //get.admin/category/{category}/edit编辑分类
    public function edit(){

    }

}
