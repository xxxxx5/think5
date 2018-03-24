<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\User;

// use think\Db;
class Userinfo extends Controller
{
	//用户信息模板
   /* public function userinfo()
    {
        $user = new User();
        $res = $user->users();
        $this->assign('res',$res);
    	return $this->fetch('user/userinfo');
    }*/

    //用户信息修改
    public function upuser()
    {

    	$user = new User();
        $res = $user->upusers();
    }

    //用户信息拉黑
    public function deluser()
    {
        // dump(input());die;
    	$user = new User();
        $res = $user->delusers();
        // echo User::getLastSql();
    }

    //用户信息多选删除
    public function delmore()
    {
    	dump(input());
    }

    //用户信息搜索应用
    public function userSousuo()
    {
        $user = new User();
        $res = $user->userSousuo();
        $page = $res->render();
        $this->assign('res',$res);
        $this->assign('page',$page);
        return $this->fetch('user/userinfo');
    }
}