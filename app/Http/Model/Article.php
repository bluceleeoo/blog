<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table='article';
    protected $primaryKey='art_id';
    public $timestamp=false;
    protected $guarded=[];//排除不能填充的字段
}
