<?php
namespace app\index\controller;
session_start();
//use think\Ucpaas;
use think\Db;
use think\view;
use think\Controller;
use think\Open51094 as Open;
use app\index\model\User as UserModel;
use duanxin\Ucpaas;
use think\Session;

class User extends Controller
{
	//注册页面模板显示
	public function register()
    {
        return $this->fetch('register');
    }

    //短信验证
	public function dxyz()
	{
		$phone = $_POST['phone'];
		//file_put_contents('1.php', $phone);
		//初始化必填
		$options['accountsid']='bf0a92f0872aace15d6c0f9760ad833f';
		$options['token']='f69b623b62bde2e9829e92b8df18213a';

		//初始化 $options必填
		$ucpass = new Ucpaas($options);

		//开发者账号信息查询默认为json或xml
		//header("Content-Type:text/html;charset=utf-8");

		//验证码
		$str = rand('0000','9999');

		//应用的ID
		$appid = "752e17ccb8d849b492f76884128addd8";

		//模板ID
		$templateid = "294776";
		$param = $str; //多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空

		//手机号
		session('code',$str);
		//$_SESSION['yzm'] = $str;
		//$uid = "";

		//70字内（含70字）计一条，超过70字，按67字/条计费，超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。

		echo $ucpass->templateSMS($appid,$phone,$templateid,$param);
		
	}

    //注册功能
   	public function doRegister()
    {
    	//判断用户名是否为空
    	$post = input('post.');
    	$username = $post['username'];
    	$password = $post['password'];
    	$repassword = $post['repassword'];
    	$email = $post['email'];
    	$tel = $post['phone'];
    	$phonever = $post['phonever'];
    	$userPattern = '/^[a-za-z]{1}([a-za-z0-9]|[._]){5,15}$/';
    	$emailPat = '/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';
    	if (empty($username)) {
    		return "<script>alert('用户名不能为空');location.assign('/index/user/register');</script>";
    	}
    	//判断用户名是否存在
    	$user = Db::name('user')->where('username',$username)->select();
    	if ($user) {
    		return "<script>alert('用户名已存在');location.assign('/index/user/register');</script>";
    	}
    	//判断用户名规则
    	if (!preg_match($userPattern , $username, $matches)) {
			return "<script>alert('用户名为5-16位且以字母开头');location.assign('/index/user/register');</script>";
		}
		//判断密码是否为空
		if (empty($password)) {
    		return "<script>alert('密码不能为空');location.assign('/index/user/register');</script>";
    	}
    	//判断密码规则
    	if (!preg_match($userPattern , $password, $matches)) {
			return "<script>alert('密码以字母开头且长度在5到12位');location.assign('/index/user/register');</script>";
		}
		//判断两次密码是否相等
		if (strcasecmp($password , $repassword)) {
			return "<script>alert('两次密码输入不一致');location.assign('/index/user/register');</script>";
		}
		//邮箱判断
		if (!preg_match($emailPat , $email, $matches)) {
			return "<script>alert('邮箱格式不对');location.assign('/index/user/register');</script>";
		}
		//手机验证
		if (empty($tel)) {
			return "<script>alert('请输入手机号');location.assign('/index/user/register');</script>";
		} else if (strcasecmp(session('code'),$phonever)) {
			return "<script>alert('验证码输入错误');location.assign('/index/user/register');</script>";
		}
		$sj = time();
		$password= md5($password);
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip = ($ip == '::1')? '120.0.0.1': $ip;
		
		$data['username'] = $username;
		$data['password'] = $password;
		$data['tel'] = $tel;
		$data['loginip'] = $ip;
		$data['create_time'] = $sj;
		$res = Db::name('user')->insert($data);
		if ($res) {
			return "<script>alert('注册成功');location.assign('/index/user/login');</script>";
		} else {
			return "<script>alert('注册失败');location.assign('/index/user/register');</script>";
		}

		session('username',$username);

    }

    //登录页面模板显示
	public function login()
    {
        return $this->fetch('login');
    }

    //登录功能
    public function doLogin()
    {
    	$post = input('post.');

    	$username = $post['username'];
    	$password = md5($post['password']);
    	$result = Db::name('user')->where('username',$username)->where('password',$password)->select();
    	if ($result) {
    		session('username',$username);
    		return $this->redirect('/index/index/index');
    	} else {
    		return "<script>alert('用户名或密码错误');location.assign('/index/user/login');</script>";
    	}

    }

    //处理QQ登录
    public function qqlogin()
    {
    	$open = new Open();
    	$code = $_GET['code'];
    	$me = $open->me($code);
    	if ($me) {
    		$data['username'] = $me['name'];
    		$data['userpic'] = $me['img'];
    		$data['sex'] = $me['sex'];
    		$str = $me['name'];
    		session('username',$str);
    		$data['create_time'] = time();
    		$resuser = Db::name('user')->where('username', $str)->select();
    		if ($resuser) {

    			return $this->redirect('/index/index/index');
    		} else {
                $ip = $_SERVER['REMOTE_ADDR'];
                $ip = ($ip == '::1')? '120.0.0.1': $ip;
                $data['loginip'] = $ip;
    			$res = Db::name('user')->insert($data);
	    		if ($res) {

	    			return $this->redirect('/index/index/index');
	    		} else {

	    			return "<script>alert('登录失败!');location.assign('/index/user/login');</script>";
	    		}
    		}

    	} else {
    		return "<script>alert('登录失败!');location.assign('/index/user/login');</script>";
    	}
    }

    //退出登陆
    public function logout()
    {
    	//销毁session
    	session(null);
    	//跳转
    	header('refresh:0,/');
    }

    //找回密码模板显示
    public function fsyj()
    {
        return $this->fetch('fsyj');
    }

    //找回密码
    public function zhpass()
    {
        
    }
}