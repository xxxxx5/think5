<?php 
namespace app\admin\model;

use think\Model;

use think\Db;

class Author extends Model
{
	//作者头衔取消
	public function noAuthor()
	{
		// dump(input());
		$aid = input('get.aid');
		return Db::name('author')->where('aid',$aid)->update(['isdel'=>1]);

	}
}