<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\Link as LinkModel;

use think\Db;

class Link extends Controller
{
	//友情链接模板
	public function link()
    {    
        $lks = new linkModel();
        $res = $lks->linkmod();
        $this->assign('res',$res);
        return  $this->fetch('link/link');
    }
    //友情链接添加
    public function linkadd()
    { 
        // dump(input());
    	$lks = new LinkModel();
    	$res = $lks->linkadds(input('post.'));	
    }
    //友情链接的修改
    public function linkup()
    {
        $user = new LinkModel();
        $res = $user->linkups(input('post.'));
        $this->redirect('link/link');
    }
     //友情链接删除
    public function linkdel()
    {
        $user = new LinkModel();
        dump(input());
        $id = input('id');
        $result = Db::name('link')
                -> where('id',$id)
                /*->strict(true)*/
                -> update([
                   'isdel'  => 1
            ]);
        $this->redirect('link/link');
    }

}