<?php
namespace app\index\controller;

use think\Db;
use think\view;
use think\Controller;
use app\index\model\Books;
use app\index\model\Index as IndexModel;

class Index extends Controller
{
     public function index()
    {
        //查询小说类型
        $cate = new IndexModel();
        $lcate = $cate->lcate();
        $this->assign('lcate',$lcate);

        //查询轮播图
        $pic = new IndexModel();
        $lpic = $pic->pics();
        $this->assign('lpic',$lpic);

        //查询友情链接
        $link = new IndexModel();
        $res = $link->links();
        $this->assign('res',$res);

        $newBook = new Books();
        $lnewbook = $newBook->newBooks();
        $this->assign('lnewbook', $lnewbook);

        return $this->fetch('index');
    }
}