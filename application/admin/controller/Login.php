<?php 
namespace app\admin\controller;

use think\Controller;

use think\Db;

use think\Request;

use app\admin\model\User;

use think\Session;

class Login extends Controller
{
	public function login()
	{
		if (!$_POST) halt('页面不存在');
		
		$username = input('post.username');
		$password = md5(input('post.password'));
		$request = Request::instance();

		$where = [
			'username'  => $username,
			'password'  => $password
		];
		if (isset($_POST['submit'])) {

			$res  = Db::name('user')->where($where)->select();

			if ($res) {
				// session::set('name',$username);
				
				echo "<script>alert('登陆成功');window.location.href='/admin/index/index.html'</script>";
				
				session('adminLogin',$username);
					// header('Refresh:1,Url=/admin/index/login.html');
					// 
				}else {
					echo "<script>alert('账号或密码不存在');window.location.href='/admin/index/login.html'</script>";
			}

		}

		/*$data = [
			'id'         => $res[0]['id'],
			'logintime'  => time(),
			'username'   => $res[0]['username'],
			'loginip'    => $request,
		];
		$use = new User();
		$reuslt = $use->save($data);
		dump($result);*/

		/*session('user_id',$reuslt[0]['id']);
		session('username',$reuslt['0']['username']);
		session('logintime',date('Y-m-d H:i:s' , $reuslt[0]['logintime']));
		session('loginip',$reuslt[0]['loginip']);
*/
		// echo "<script>alert('登陆成功');</script>";
		// header('Refresh:1,Url=/admin/index/index.html'); 
	}
}