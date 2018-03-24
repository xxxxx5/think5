<?php

namespace app\admin\model;

use think\Model;

use think\Db;

class Node extends Model
{
	//添加节点表单处理
	public function addNodes()
	{
		// dump(input());
		$node_name = input('post.node_name');
		$node_title = input('post.node_title');
		$status = input('post.status');
		$sort   = input('post.sort');
		$pid    = input('post.pid');
		$level  = input('post.level');
		$result = Db::name('node')
					->insert([
						'node_name'  => $node_name,
						'node_title' => $node_title,
						'status'     => $status,
						'sort'       => $sort,
						'pid'        => $pid,
						'level'      => $level
					]);
		return $result;
	}
	//节点列表
	public function nodes()
	{
		return Db::name('node')
		         ->field('id,node_title,node_name,pid')
		         ->where('isdel=0')
		         ->order('sort')
		         ->select();
	}
	public function nodes2()
	{

		return Db::name('node')
				->where('level=3',"pid")
				->select();
	}
	
	//节点列表方法删除
	public function nodeDel()
	{
		// dump(input());
		$uid = input('get.uid');
		$result = Db::name('node')->where('id',$uid)->update(['isdel'=>1]);
		if ($result) {
			echo "<script>alert('删除数据成功');window.location.href='/admin/Rbacaction/node'</script>";
		}
	}
}
