<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Index extends Model
{
	//查询轮播图
	public function pics()
	{
		return db('pic')->where('isdel=0')->select();
	}

	//查询友情链接
	public function links()
	{
		$links = Db::name('link')->select();
		return $links;
	}

	//查询小说类型
	public function lcate()
	{
		//大版块
		$dcate = db('cate')->where('isdel=0')->where('pid = 0')->select();
		//小板块
		$xcate = db('cate')->where('pid != 0')->select();

		$arr = ['dcate'=>$dcate, 'xcate'=>$xcate];
		return $arr;
	}



	
}