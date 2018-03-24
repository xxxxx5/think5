<?php

namespace app\admin\controller;

use think\Controller;

use app\admin\model\Pic as PicModel;

use app\admin\model\WebInfo as Web;

class Info extends Controller
{
	//轮播模板
	public function carousel()
	{
		$pic = new PicModel();
        $res = $pic->picmod();
        $page = $res->render();
        $this->assign('page',$page);
        $this->assign('res',$res);

		return $this->fetch();
	}
	public function caradd()
	{
		
	}
	//站点信息模板
	public function webInfo()
	{
		$web = new Web();
        $res = $web->webInfos(); 
        $this->assign('res',$res);
		return $this->fetch('webinfo');
	}
	//修改站点信息模板
	public function webup()
	{
		$web = new Web();
		$resup = $web->webups();
		$this->redirect('info/webinfo');
	}
}