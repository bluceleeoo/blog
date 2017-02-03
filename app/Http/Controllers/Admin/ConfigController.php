<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //get.admin/links  全部配置列表
    public function index()
    {
        //dd('全部配置列表');
        $data = Config::orderBy('conf_order','asc')->get();
        foreach($data as $k=>$v){
            switch($v->field_type){
                case 'input':
                $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" name="conf_content[]" >'.$v->conf_content.'</textarea>';
                    //echo $data->_html;
                    break;
                case 'radio':
                    //echo $v->field_value;
                    $arr=explode(',',$v->field_value);
                    //dd($arr);
                    $str='';
                    foreach($arr as $m=>$n){
                        //1\开启
                        $r=explode('|',$n);
                        $c=$v->conf_content==$r[0]?' checked ':'';
                        //dd($r);
                        $str.= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.' >'.$r[1].'　';
                    }
                    $data[$k]->_html= $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }

    public function changeContent()
    {
      $input=Input::all();
        //dd($input);

        foreach($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置更新成功！');
    }

    public function putFile()
    {
        //获取配置项的值
        //echo \Illuminate\Support\Facades\Config::get('web.web_title');
        $config = Config::pluck('conf_content','conf_name')->all();
         //数组转换成字符串
        $path=base_path().'\config\web.php';
        $str='<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
        //dd($path);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $links = Config::find($input['conf_id']);
        $links->conf_order = $input['conf_order'];
        $re = $links->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/config/create   添加配置
    public function create()
    {
        return view('admin/config/add');
    }

    //post.admin/links  添加配置提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];

        $message = [
            'conf_name.required'=>'配置名称不能为空！',
            'conf_title.required'=>'配置标题不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','配置失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/config/{links}/edit  编辑配置
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    //put.admin/config/{links}    更新配置
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if($re){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('errors','配置更新失败，请稍后重试！');
        }
    }

    //delete.admin/config/{links}   删除配置
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '配置删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置删除失败，请稍后重试！',
            ];
        }
        return $data;
    }


    //get.admin/category/{category}  显示单个分类信息
    public function show()
    {

    }

}