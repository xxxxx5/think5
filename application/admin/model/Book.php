<?php
namespace app\admin\model;

use think\Model;

use think\Db;

use think\View;

class Book extends Model
{
	public function bookmd()
	{
		return $res = Db::name('books');
		// var_dump($res);
	}

	//书籍列表展示
	public function booklists()
	{
		  return $result = Db::name('books')
				    ->alias('b')
				    ->join('byread_cate c','c.id=b.type_id')
				    ->field('b.id ,b.isdels,cover,bname,author,description,content,uptime,c.name')
				 	->where('b.isdels=0')
				 	->paginate(3);
				    // ->select();
	}

	//书籍列表修改
	public function updateBook()
	{
		// dump(input());die;
		$bid     = input('get.bid');
		$bname   = input('post.bname');
		$author  = input('post.author');
		$name    = input('post.name');
		$isvouch = input('post.isvouch');
		$istop   = input('post.istop');

		if (input('post.')) {
			$result  = Db::name('books')
				    ->alias('b')
				    ->join('byread_cate c','c.id=b.type_id')
				 	->where('b.id',$bid)
				    ->update([
				    	'b.bname'        => $bname,
				    	'b.author'       => $author,
				    	'c.name'         => $name,
				    	'b.uptime'       => date('Y-m-d H:i:s')
 				    ]);
		}
		
 		if ($result) {
 			echo "<script>alert('编辑成功');window.location.href='/admin/book/bookList.html'</script>";
 		} else {
 			echo "<script>alert('编辑失败');window.location.href='/admin/book/bookList.html'</script>";
 		}
	}

	//书籍列表放入回收站
	public function bookShelf()
	{
		$hid = input('get.hid');

		$result = Db::name('books')
				    ->alias('b')
				    ->join('byread_cate c','c.id=b.type_id')
				 	->where('b.id',$hid)
				 	->update([
				 		'isdels' => 1,
				 	]);
 		
		 if ($result) {
		 	echo "<script>alert('放入回收站成功');window.location.href='/admin/book/bookList.html'</script>";
		 } else {
		 	echo "<script>alert('放入回收站失败');window.location.href='/admin/book/bookList.html'</script>";
		 }
	}

	//书籍回收站模板
	public function bookHz()
	{
		 return $result = Db::name('books')
				    ->alias('b')
				    ->join('byread_cate c','c.id=b.type_id')
				    ->field('b.id ,b.isdels,cover,bname,author,description,content,uptime,c.name')
				 	->where('b.isdels=1')
				    ->paginate(3);
	}

	//放回书籍列表
	public function returnBook()
	{

		$rid = input('get.rid');

		$result = Db::name('books')
				    ->alias('b')
				    ->join('byread_cate c','c.id=b.type_id')
				 	->where('b.id',$rid)
				 	->update([
				 		'isdels' => 0,
				 	]);
		 if ($result) {
		 	echo "<script>alert('返回书籍列表成功');window.location.href='/admin/book/bookHz.html'</script>";
		 } else {
		 	echo "<script>alert('返回书籍列表失败');window.location.href='/admin/book/bookHz.html'</script>";
		 }
	}

	//回收书籍列表真删除
	public function delBook()
	{
		dump(input());
		$did = input('git.did');

		$result = Db::name('books')
				    ->alias('a')
				    ->join('byread_books b','b.author_id=a.aid')
				    ->join('byread_booktype t','t.tid=b.type_id')
				    ->where('id',$did)
				    ->delete();
		dump($result);die;
		return $result;
	}

	//作者列表模板
	public function authorList()
	{
		$result = Db::name('author')
					->alias('a')
					->join('user u','u.id = a.user_id')
					->field('a.aid,a.name,a.realname,a.IDnumber,a.create_time,u.id')
					->where('isdel=0')
					->paginate(3);
		return $result;
	}

	//书籍列表搜素
	public function sousuo()
	{
		// dump(input());die;
		$_POST['keywords'] = empty($_POST['keywords'])? '' : $_POST['keywords'];
		 return $data =  Db::name('books')
					    ->alias('b')
					    ->join('byread_cate c','c.id=b.type_id')
					    ->field('b.id ,b.isdels,cover,bname,author,description,content,uptime,c.name')
					 	->where('bname','like','%'.$_POST['keywords'].'%')
					 	->whereOr('author','like','%'.$_POST['keywords'].'%')
					 	->whereOr('description','like','%'.$_POST['keywords'].'%')
					 	->whereOr('content','like','%'.$_POST['keywords'].'%')
					 	->whereOr('uptime','like','%'.$_POST['keywords'].'%')
					 	->whereOr('c.name','like','%'.$_POST['keywords'].'%')
					 	// ->select();
					 	->paginate(3);

	}

}

