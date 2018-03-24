<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
	//后台首页模板
    public function index()
    {  
        return $this->fetch();
    }
    //首页展示模板
    public function main()
    {
    	return $this->fetch();
    }
    public function login()
    {
    	return $this->fetch();
    }
    //个人信息模板
    public function personinfo()
    {
        return $this->fetch();
    }
}
