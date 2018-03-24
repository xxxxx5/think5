<?php
namespace app\admin\model;

use think\Model;

use think\Db;

use think\View;

use think\Request;

class User extends Model
{
	//添加用户表处理
	public function addUserHandle()
	{
		// dump(input());die;
		$username = input('post.username');
		$sex      = input('post.radio');
		$pass     = md5(input('post.pass'));
		$regpass  = md5(input('post.regpass'));
		$tel      = input('post.tel');
		$emial    = input('email');

		//获取客户端ip
		$request = Request::instance();
		$loginip = $request->ip();

		if (input('post.')) {
			if (!$username) {
			echo "<script>alert('用户信息不能为空');window.location.href='/admin/rbacaction/addUser'</script>";
			}
			//判断用户名是否存在
			$res = Db::name('user')->where('username',$username)->select();
			if ($res) {
				echo "<script>alert('用户名已存在');window.location.href='/admin/rbacaction/addUser'</script>";
			}
			//正则匹配用户名格式
			/*$pregname = '/^[a-zA-Z]{3,16}$/';
			if (!preg_match($pregname,$username)) {
				echo "<script>alert('用户名必须是大于3位且小于16位');window.location.href='/admin/rbacaction/addUser'</script>";
			}*/
			//判断两次密码是否一致
			if (!$pass) {
				echo "<script>alert('用户密码不能为空');window.location.href='/admin/rbacaction/addUser'</script>";
			}
			if (trim($pass) !== trim($regpass)) {

				echo "<script>alert('两次密码不一致');window.location.href='/admin/rbacaction/addUser'</script>";
			}

			//正则匹配密码是否为字母开头且大于3位且小于8位
			$pregpwd = "/^[a-zA-Z\d_]{8,}$/";
			if (!preg_match($pregpwd,$pass)) {

			    echo "<script>alert('密码必须以字母开头且大于3位且小于8位');window.location.href='/admin/rbacaction/addUser'</script>";
			}

			//正则匹配手机号码格式
			$pregtel = "/^0?(13|14|15|17|18)[0-9]{9}$/";
			if (!$tel) {
				echo "<script>alert('用户手机号码不能为空');window.location.href='/admin/rbacaction/addUser'</script>";
			}
			if (!preg_match($pregtel,$tel)) {

				echo "<script>alert('手机格式不正确');window.location.href='/admin/rbacaction/addUser'</script>";
			}

			//用正则判断Email
			$preg = "/^\w+@\w+\.(com|net|org|cn)/";
			if (!$emial) {
				echo "<script>alert('用户邮件不能为空');window.location.href='/admin/rbacaction/addUser'</script>";
			}
			if (!preg_match($preg,$emial)) {

				echo "<script>alert('邮箱格式不正确');window.location.href='/admin/rbacaction/addUser'</script>";
			}

			//文件上传头像
			$file = request()->file('file');

			if (!$file) {
				echo "<script>alert('图片信息不能为空');window.location.href='/admin/rbacaction/addUser'</script>";
			}
			// 移动到框架应用根目录/public/uploads/ 目录下
			$info = $file->move(ROOT_PATH . 'public' . DS . 'user_uploads');

			//获取图片路径
			$path = '/user_uploads/'. $info->getSaveName();

/*
			if($info){
			// 成功上传后 获取上传信息
			// 输出 jpg
			echo $info->getExtension();
			// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
			echo $info->getSaveName();
			// 输出 42a79759f284b767dfcb2a0197904287.jpg
			echo $info->getFilename();
			}else{
			// 上传失败获取错误信息
			echo $file->getError();
			}*/


			$result = Db::name('user')
					->insert([
						'username'     => $username,
						'sex'          => $sex,
						'password'     => $pass,
						'tel'          => $tel,
						'email'        => $emial,
						'userpic'      => $path,
	 					'create_time'  => time(),
	 					'status'       => 0,
						'loginip'      => $loginip
					]);
			//获取当前的表中id
			$uid = Db::name('user')->getLastInsID();

			$res = input();
			$rold_id = $res['role_id'][0];
			if (!$rold_id) {

				echo "<script>alert('你的所属角色');window.location.href='/admin/rbacaction/addUser'</script>";

			}
			//所属角色
			if ($result) {
				foreach ($_POST['role_id'] as $v) {
					$role[] = array(
				        'role_id' => $v,
				        'user_id' => $uid,
				    	);            
				} 

				return $res = Db::name('role_user')->insertAll($role);
				        
			}
		} else {
			echo "<script>alert('信息不正确');window.location.href='/admin/rbacaction/addUser'</script>";
		}
		
        
    }
	
    //用户列表
	public function role()
	{
		return  Db::name('user')
					->alias('u')
					->join('role_user ur','ur.user_id = u.id', 'LEFT')
					->join('role r','r.rid = ur.role_id')
					->order('id desc')
					->where('u.status=0')
					->paginate(3);


	}

	//修改用户信息
	public function upusers()
	{
		$id           = input('get.id');
		$username     = input('post.username');
		$sex          = input('post.sex');
		$coin         = input('post.coin');
		$email        = input('post.email');
		$tel          = input('post.tel');

		$result = Db::name('user')
					->where('id',$id)
					->update([
						'username'  => $username,
						'sex'       => $sex,
						'coin'      => $coin,
						'email'     => $email,
						'tel'       => $tel,
						'update_time'=> time(),
					]);

					if ($result) {
						echo "<script>alert('编辑成功');window.location.href='/admin/userinfo/userinfo'</script>";
						// header('Refresh:1,Url=/');
					} else {
						echo "<script>alert('编辑失败');</script>";
						// header('Refresh:1,Url=/admin/userinfo/userinfo');
					}

	}

	//用户信息拉黑
	public function delusers()
	{
		// dump(input());die;
		$id = input('get.id');

		$result = Db::name('user')
					->where('id',$id)
					->update([
						'status' => 1
					]);

		if ($result) {
			echo "<script>alert('拉黑成功');</script>";
			header('Refresh:1,Url=/admin/rbacaction/userinfo');
		} else {
			echo "<script>alert('拉黑失败');</script>";
			header('Refresh:1,Url=/admin/rbacation/userinfo');
		}
		
	}

	//用户信息搜索应用
	public function userSousuo()
	{
		// dump(input());
		$_POST['keywords'] = empty($_POST['keywords'])? '' : $_POST['keywords'];
		return  Db::name('user')
					->alias('u')
					->join('role_user ur','ur.user_id = u.id', 'LEFT')
					->join('role r','r.rid = ur.role_id')
					// ->order('id desc')
					// ->where('u.status=0')
					
					->whereOr('u.username','like','%'.$_POST['keywords'].'%')
				/*	->whereOr('loginip','like','%'.$_POST['keyword'].'%')
					// -whereOr('create_time','like','%'.$_POST['keyword'].'%')
					->whereOr('role_name','like','%'.$_POST['keyword'].'%')
					->whereOr('remark','like','%'.$_POST['keyword'].'%')*/
					->paginate(3);

	}

	//用户拉黑列表
	public function heihus()
	{
		return  Db::name('user')
					->alias('u')
					->join('role_user ur','ur.user_id = u.id', 'LEFT')
					->join('role r','r.rid = ur.role_id')
					->where('u.status=1')
					->paginate(2);
	}

	//取消拉黑
	public function qxheihus()
	{
		$id = input('get.id');
		$result = Db::name('user')
					->where('id',$id)
					->update([
						'status' => 0
					]);
		if ($result) {
			echo "<script>alert('黑户取消成功');window.location.href='/admin/user/heihu'</script>";
		
		} else {
			echo "<script>alert('黑户取消失败');window.location.href='/admin/user/heihu'</script>";
			
		}			
	}

	//黑户列表删除
	public function delheihus()
	{
		$did = input('get.did');
		$result = Db::name('user')->where('id',$did)->delete();

		if ($result) {
			echo "<script>alert('删除成功');</script>";
			header('Refresh:1,Url=/admin/user/heihu');
		} else {
			echo "<script>alert('删除失败');</script>";
			header('Refresh:1,Url=/admin/user/heihu');
		}	
	}

	//登陆模板数据查询
	public function login()
	{
		return $this->table('user')->select();
	}
}