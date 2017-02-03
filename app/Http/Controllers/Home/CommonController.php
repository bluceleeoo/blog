<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        //点击量最高的6片文章(点击排行区)
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布8文章
        $new= Article::orderBy('art_time','desc')->take(8)->get();
        $navs = Navs::all();
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
