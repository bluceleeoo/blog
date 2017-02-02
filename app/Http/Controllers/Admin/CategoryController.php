<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController{
    //get.admin/category全部分类列表
    public function index(){
        $categorys = (new Category)->tree();
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
        $cate = Category::find($input['cate_id']);
        $cate->cate_order=$input['cate_order'];
        $re=$cate->update();
        //echo $re;
        if($re){
            $data=[
                'status'=> 0,
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

    //get.admin/category/create添加分类
    public function create(){
        //echo '添加分类';
        $data=Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('data'));
    }
    //post.admin/category添加分类提交地址
    public function store(){
        $input=Input::except('_token');
        //dd($input);
        //验证规则
        $rules=[
            'cate_name'=>'required',
        ];
        $message=[
            'cate_name.required'=>'分类名称不能为空！',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Category::create($input);
            dd($re);
            if($re){
                return redirect('admin/category');
            }else{
            return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            // echo 'no';
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
        }
    }
    //get.admin/category/{category}/edit编辑分类
    public function edit($cate_id){
        //echo $cate_id;
        $field=Category::find($cate_id);
       // dd($field);
        $data=Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }
    //put.admin/category/{category}更新分类
    public function update($cate_id){
       $input=Input::except('_token','_method');
        $re=Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类更新失败，请稍后重试！');
        }
    }

    //get.admin/category/{category}显示单个分类信息
    public function show(){

    }
    //delete.admin/category/{category}删除单个分类
    public function destroy(){

    }

}
