<?php

namespace app\admin\model;

use think\Db;

use think\Model;

use think\View;
class Pinlun extends Model
{
	//书籍评论列表
	public function shuPing()
	{
		return $result = Db::name('books')
					->alias('b')
					->join('pinlun p', 'p.book_id=b.id')
					->join('user u','u.id=p.user_id')
					->field('p.pid,b.bname,u.username,p.content,p.create_time')
					->where('p.isdel=0')
					->paginate(3);
		// dump($result);

	}

	//书评放入回收站
	public function interPinlun()
	{
		$pid = input('get.pid');
		$result = Db::name('pinlun')
					->where('pid',$pid)
					->update([
						'isdel' => 1
						]);
		return $result;
	}

	//书籍评论回收站
	public function pinlunHz()
	{
		return $result = Db::name('books')
						->alias('b')
						->join('pinlun p', 'p.book_id=b.id')
						->join('user u','u.id=p.user_id')
						->field('p.pid,b.bname,u.username,p.content,p.create_time')
						->where('p.isdel=1')
						// ->select();
						->paginate(3);
	}

	//评论回收站返回列表
	public function returnPinlun()
	{
		$pid = input('get.pid');
		$result = Db::name('pinlun')
					->where('pid',$pid)
					->update([
						'isdel' => 0
						]);
		return $result;
	}
}