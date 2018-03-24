<?php 

namespace app\admin\model;

use think\Model;

use think\Db;

class Access extends Model
{
	//
	public function setAccessmod()
	{
		return Db::name('access')->insert();
	}
	public function accessmod() 
	{
		return Db::name('access')->select();
	}
}