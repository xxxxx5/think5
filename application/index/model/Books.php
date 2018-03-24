<?php
namespace app\index\model;

use think\Model;
use think\Db;
class Books extends Model
{
	public function newBooks()
	{
		//查询最新作品
		$newBook = Db::table('byread_books')->alias('books')->where('isdels=0')->join('byread_cate cate','books.type_id=cate.id','left')->order('add_time','desc')->limit('10')->select();
		return $newBook;
	}
}
