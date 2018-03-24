<?php
namespace app\admin\controller;

use think\Db;

use app\admin\model\Role ;

use app\admin\model\Node ;

use app\admin\model\User ;

use app\common;

use app\admin\model\Access ;

use app\admin\model\Validate;

class Rbacaction extends common
{
	//用户列表
	 public function userinfo()
    {

        $user = new User();
        $res = $user->role();
        $page = $res->render();
        $this->assign('page',$page);
        $this->assign('res',$res);
    	return $this->fetch('user/userinfo');

    }

	//角色列表
	public function role()
	{
		$res = DB::name('role')->select();
		$this->assign('res',$res);
		return $this->fetch('role');
	}

	//节点列表
	public function node()
	{                      
		$node = new Node();

		$res = $node->nodes();

		$node = $this->node_merge($res); 

		$this->assign('node',$node);
	
		return $this->fetch();
	}


	//添加用户
	public function addUser()
	{
		$res = Db::name('role')->select();
		$this->assign('res',$res);
		return $this->fetch();
	}

	//添加用户表处理
	public function addUserHandle()
	{
		$use = new User();
		$res = $use->addUserHandle();
		if ($res) {
			echo "<script>alert('添加成功');window.location.href='/admin/Rbacaction/addUser'</script>";
			
		} else {
			echo "<script>alert('添加失败');window.location.href='/admin/Rbacaction/addUser'</script>";
			
		}
	}

	//添加角色列表
	public function addRole()
	{

	} 

	//添加角色表单处理
	public function addRoleHandle()
	{	
		$role = new Role();
		$res = $role->roles();
		if ($res) {
			echo "<script>alert('添加成功');</script>";
			header('Refresh:1,Url=/admin/Rbacaction/role');
		} else {
			echo "<script>alert('添加失败')</script>";
			header('Refresh:1,Url=/admin/Rbacaction/role');
		 }
	}

	//添加节点
	public function addNode()
	{
		$res = Db::name('node')->order('sort')->select();

		$pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
		$level = isset($_GET['level']) ? $_GET['level'] : 1 ;
		switch($level) {
			case 1 :
				$type = '应用';
				break;
			case 2 :
				$type = '控制器';
				break;
			case 3 :
				$type = '动作方法';
				break;
		}

		$this->assign('pid',$pid);
		$this->assign('level',$level);
		$this->assign('type',$type);
		$this->assign('res',$res);
		return $this->fetch();

	}

	//添加节点表单处理
	public function addNodeHandle()
	{	
		// dump(input());die;
		$node = new Node();
		$res = $node->addNodes();
		if ($res) {
			echo "<script>alert('添加成功');</script>";
			header('Refresh:1,Url=/admin/Rbacaction/node');
		} else {
			echo "<script>alert('添加失败')</script>";
			header('Refresh:1,Url=/admin/Rbacaction/node');
		 }
	}

	//节点列表方法删除
	public function nodeDel()
	{
		$node = new Node();
		$res = $node->nodeDel();
	}

	//配置权限
	public function access()
	{

		$rid = isset($_GET['rid']) ? $_GET['rid'] : 0;
		// dump($rid);die;
		$field = array('id','node_name','node_title','pid');
		
		$node = Db::name('node')->order('sort')->field($field)->select();
		

		//原有权限
		$access = Db::name('access')->where('role_id', $rid)->field('node_id')->select();
		
		$node = $this->node_merge($node,$access);	

		$this->assign('rid',$rid);
		$this->assign('node',$node);
		return $this->fetch();
	}

	//修改权限
	public function setAccess()
	{
		// dump(input());die;
		$rid = isset($_POST['rid']) ? $_POST['rid'] : 0; 

		//清空权限
		$del = Db::name('access')->where('role_id',$rid)->delete();
		//组合新权限
		$data[] = array();

		// $ss =input('post.access');

		if ($_POST['access']) {

			$ss = $_POST['access'];

			foreach ($ss as $v) {
				$tmp = explode('_', $v);
				$data[] = array(
					'role_id' => $rid,
					'node_id' => $tmp[0],
					'level'   =>  $tmp[1]
				);
			}
			// dump($data);die;
		} else {
			header('Refresh:1,Url=/admin/Rbacaction/access');
		}

		//新添权限
		$db = new Access();
		$res = $db->saveAll($data);
		if ($res) {
			echo "<script>alert('修改成功');</script>";
			header('Refresh:1,Url=/admin/Rbacaction/role');
		} else {
			echo "<script>alert('修改失败');</script>";
			header('Refresh:1,Url=/admin/Rbacaction/role');
		}
	}

	//
}