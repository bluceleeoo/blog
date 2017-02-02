<?php
use DB;//看着手册填充的，但是不起作用
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;//看着手册填充的，但是不起作用
class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                'link_name' => '普特听力',
                'link_title' => '专业的听力网站',
                'link_url' => 'http://www.put.com',
                'link_order'=>1,
            ],
            [
                'link_name' => '诗词名句',
                'link_title' => '诗词类综合性网站',
                'link_url' => 'http://www.shicimingju.com',
                'link_order'=>2,
            ],
        ];
        DB::table('links')->insert($data);
    }
}
