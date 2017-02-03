<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Navs;

class IndexController extends CommonController
{
    public function index()
    {
       //$navs = Navs::all();
        return view('home.index');
    }

    public function cate()
    {
        return view('home.list');
    }

    public function article()
    {
        return view('home.new');
    }
}
