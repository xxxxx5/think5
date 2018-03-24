<?php
namespace app\admin\model;

use think\Model;

use think\Db;

class Role extends Model
{
	//添加角色表单处理
	public function roles()
	{
		// dump(input());die;
		$role_name = input('post.role_name');
		$remark = input('post.remark');
		$status = input('post.status');
		$result = Db::name('role')
					->insert([
						'role_name' => $role_name,
						'remark'    => $remark,
						'status'    => $status
					]);
		
		return $result;	
	}

	
}