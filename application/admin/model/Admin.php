<?php
namespace app\admin\model;

use think\Model;

class Admin extends Model
{
	public function admins()
	{
		return $this->table('byread_admin')->select();
	}
	public function user()
	{
		return $this->hasOne('user','a_id');
	}
}