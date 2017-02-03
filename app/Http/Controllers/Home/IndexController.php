<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Navs;

class IndexController extends CommonController
{
    public function index()
    {
       //点击量最高的6片文章(站长推荐区)
        $pics = Article::orderBy('art_view','desc')->take(6)->get();
        //dd($hot);

        //图文列表（带分页）
        $data= Article::orderBy('art_time','desc')->take(5)->paginate(5);
        //dd($data);

        //友情链接
        $links=Links::orderBy('link_order','asc')->get();
        //dd($links);
        //网站配置项
        return view('home.index',compact('hot','pics','data','new','links'));
    }

    public function cate($cate_id)
    {
        //图文列表（带分页）
        $data= Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->take(5)->paginate(4);
        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view');
        //当前分类的子分类
        $submenu=Category::where('cate_pid',$cate_id)->get();
       // dd($submenu);

        $field = Category::find($cate_id);
        //dd($field);
        return view('home.list',compact('field','data','submenu'));
    }

    public function article($art_id)
    {
        $field=Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //dd($field);
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
        $article['pre']=Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next']=Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $data =Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        //dd($data);
        return view('home.new',compact('field','article','data'));
    }
}
