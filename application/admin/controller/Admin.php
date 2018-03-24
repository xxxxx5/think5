<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\Admin as AdminModel;

class Admin extends Controller
{
	
	//管理员模板admin
    /*public function admin()
    {    
        $ad = new AdminModel();
        $res = $ad->admins();
        $this->assign('res',$res);
        return  $this->fetch('user/admin');
    }
    public function oneTone()
    {
    	$ad = AdminModel::find(2);
    	// echo $ad->user->tel;
    	echo $ad->user()->save(['username'=>'bythod']);
    }*/
}