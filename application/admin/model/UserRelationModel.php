<?php
namespace app\admin\model;

use think\Model;

use think\Db;

class UserRelactionModel extends Model()
{
	protected $tableName = 'user';

	protected $_Link = array(
		'role'   => array (
			'mapping_type'  => MANY_TO_MANY,
			'foreign_key'   => 'user_id',
			'relation_key'  => 'role_id',
			'relation_table' => 'role_user',
			'mapping_fields' => 'id,username,remark'
		);
	)
}