<?php

namespace app\admin\controller;

use think\Controller;

use app\admin\model\Book as BookModel;

use app\admin\model\Pinlun ;

use app\admin\model\Author;

use think\Db;

class Book extends Controller
{
	//作者列表模板
	public function authorList()
	{
		$bok = new BookModel();
		$res = $bok->authorList();
		$page = $res->render();
		$this->assign('page',$page);
		$this->assign('res',$res);
		return $this->fetch();
	}
	
	//作者头衔取消
	public function noAuthor()
	{
		$aut = new Author();
		$res = $aut->noAuthor();
		if ($res) {
			echo "<script>alert('已取消作者头衔');window.location.href='/admin/book/authorList'</script>";
		} 
	}

	//书籍列表展示
	public function bookList()
	{
		$bok = new BookModel();
		$res = $bok->booklists();
		$page = $res->render();
		$this->assign('page',$page);
		$this->assign('res',$res);
		return $this->fetch('bookList');
	}

	//书籍列表修改
	public function updateBook()
	{
		$bok = new BookModel();
		$res = $bok->updateBook();
		// echo BookModel::getLastSql();die;
	}
	
	//书籍列表放入回收站
	public function bookShelf()
	{
		$bok = new BookModel();
		$res = $bok->bookShelf();
		
		if ($res) {
			echo "<script>alert('回收成功');</script>";
			header('Refresh:1,Url=/admin/book/bookList');
		} else {
			echo "<script>alert('回收失败');</script>";
			header('Refresh:1,Url=/admin/book/bookList');
		}
	}

	//书籍回收站模板
	public function bookHz()
	{
		$bok = new BookModel();
		$res = $bok->bookHz();
		$page = $res->render();
		$this->assign('page',$page);
		$this->assign('res',$res);
		return $this->fetch();
	} 

	//书籍返回列表
	public function returnBook()
	{
		$bok = new BookModel();
		$res = $bok->returnBook();
	}

	//充实模板
	public function recharge()
	{
		return $this->fetch();
	}

	//书籍评论列表
	public function shuPing()
	{
		$bok = new Pinlun();
		$res = $bok->shuPing();
		$page = $res->render();
		$this->assign('page',$page);
		$this->assign('res',$res);
		return $this->fetch();
	}

	//书评放入回收站
	public function interPinlun()
	{

		$bok = new Pinlun();
		$res = $bok->interPinlun();
		if ($res) {
			echo "<script>alert('成功放入回收站');window.location.href='/admin/book/shuPing'</script>";
			
		} else {
			echo "<script>alert('放入回收站失败');window.location.href='/admin/book/shuPing'</script>";
		}
	}

	//书评回收站列表
	public function pinlunHz()
	{
		$bok = new Pinlun();
		$res = $bok->pinlunHz();
		$page = $res->render();
		$this->assign('page',$page);
		$this->assign('res',$res);
		return $this->fetch();
	}

	//评论回收站返回列表
	public function returnPinlun()
	{
		$bok = new Pinlun();
		$res = $bok->returnPinlun();
		if ($res) {
			echo "<script>alert('成功返回');window.location.href='/admin/book/pinlunHz'</script>";
		
		} else {
			echo "<script>alert('返回失败');window.location.href='/admin/book/pinlunHz'</script>";
			
		}
	}

	//书籍列表搜素
	public function sousuo()
	{
		$bok = new BookModel();
		$res = $bok->sousuo();
		if (!$res) {
			echo "<script>alert('没有符合的数据');window.location.href='/admin/book/bookList.html'</script>";
		}
		$page = $res->render();
		$this->assign('page',$page);
		$this->assign('res',$res);
		return $this->fetch('book/bookList');
	}

	//是否推荐
	public function istuijian()
	{
		dump(input());
	}


}