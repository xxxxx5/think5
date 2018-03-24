<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\Cate as CateModel;

use think\Db;

class Cate extends Controller
{
	//添加板块
	public function catect()
	{
		$cat = new CateModel();
		$cat->cateadd();
	}
	//删除板块
	public function catedel()
	{
		$cat = new CateModel();
		$cat->catedels();
	}
	

}