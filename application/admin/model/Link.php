<?php
namespace app\admin\model;

use think\Model;

use think\Db;

use traits\model\SoftDelete;

class Link extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';

	public function linkmod()
	{
		return Db::name('link')->where('isdel=0')->order('pid')->select();
	}
	//友情链接添加数据
	public function linkadds()
	{
		$name  = input('post.name');
    	$url   = input('post.url');
        $paixu = input('paixu');
        $data = [
        	'lname' => $name,
			'url'   => $url,
			'pid'   => $paixu
        ];
		return Db::name('link')->insert($data);
	}
	//友情链接删除数据
	public function linkdels()
	{
		return User::destroy(1);
	}
	//友情链接修改
	public function linkups()
	{
		dump(input());
		$id = input('post.id');
		$lname = input('post.lname');
		$url   = input('post.url');
		$pid   = input('post.pid');

		$result = Db::name('link')
				-> where('id',$id)
				/*->strict(true)*/
				-> update([
					'lname'  => $lname,
					'url'    => $url,
					'pid'    => $pid
			]);
	}
	/*public function linkdel()
	{
		dump(input());
	}*/
}