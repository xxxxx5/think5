<?php
namespace app\index\controller;

use think\Db;
use think\view;
use think\Controller;
use think\Request;
use think\Session;
use app\index\model\Recharge;

class Personal extends Controller
{
	public function _initialize()
	{
		$this->beforeActionList[]='checkisLogin';
	}
	//个人中心判断是否登录
	public function checkisLogin()
	{

		if(empty(session('username')))
		{
			$this->redirect('/');
		}
		$res = Db::table('byread_user')->where('id',session('id'))->find();
		//dump($res);
		session('is_author',$res['is_author']);	
	}

	//个人中心首页模板展示
	public function personal()
	{
		return $this->fetch('personal');
	}
	
	//个人信息模板展示
	public function userinfo()
	{
		$luserinfo = Db::name('user')->where('username',session('username'))->find();
		//dump($luserinfo);
		$this->assign('luserinfo',$luserinfo);
		return $this->fetch('userinfo');
	}
	//修改个人信息
	public function updateUserInfo()
	{
		$data = $this->getUserInfo();
		$res = $this->getuserpic();
		if(!empty($res)){
			$data['userpic']=$res['url'];
		}
		$res = $this->updateUser($data);
		
	}

	protected function updateUser($data)
	{
		$res = Db::name('user')->where('username',session('username'))->update($data);
		return $res;
	}
	protected function getuserpic()
	{
		$file = request()->file('head');
		// echo json_encode($cid);die;
		if(!empty($file)){
			$info = $file->validate(['size'=>1048576,'ext'=>'jpg,png,gif,jpeg'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'headImgs');
			$error = $file->getError();
            //验证文件后缀后大小
            if(!empty($error)){
                return $error;
            }
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                $url['url'] = '/headImgs/'.$info->getFilename();
                return $url; 
            }else{
                // 上传失败获取错误信息
                $file->getError();
            }
        }else{
          	return ''; 
        }
	}
	protected function getUserInfo()
	{
		$data['username']=request()->param('username');
		$data['sex']=request()->param('sex');
		$data['tel']=request()->param('tel');
		$data['qq']=request()->param('qq');
		$data['email']=request()->param('email');
		$data['autograph']=request()->param('autograph');

		return $data;
	}
	
	//修改密码模板展示
	public function pass()
	{
		$lpass = Db::name('user')->where('username',session('username'))->find();
		$this->assign('lpass',$lpass);
		return $this->fetch('pass');
	}

	//修改密码
	public function updatepass()
	{
		$password = md5($_POST['mpass']);
		$time = time();
		$userPattern = '/^[a-za-z]{1}([a-za-z0-9]|[._]){3,15}$/';
		$newpass = md5($_POST['newpass']);
		$lpass = Db::name('user')->where('username',session('username'))->where('password',$password)->find();
		if ($lpass) {
			if (!preg_match($userPattern , $newpass, $matches)) {
				$res = Db::name('user')->where('username',session('username'))->update(['password'=>$newpass,'update_time'=>$time]);
				return "<script>alert('密码修改成功,重新登录后生效');location.assign('/index/personal/userinfo');</script>";
			} else{
				return "<script>alert('新密码以字母开头且长度在5到12位');location.assign('/index/personal/pass');</script>";
			}	
		} else {
			return "<script>alert('原密码输入错误');location.assign('/index/personal/pass');</script>";
		}
		
	}

	//消息通知模板展示
	public function message()
	{
		return $this->fetch('message');
	}

	//充值中心模板展示
	public function recharge()
	{
		return $this->fetch('recharge');
	}

	//申请作者模板展示
	public function applyauthor()
	{
		return $this->fetch('applyauthor');
	}

	//待审核模板展示
	public function auditauthor()
	{
		return $this->fetch('auditauthor');
	}

	//我的收藏模板展示
	public function collection()
	{
		return $this->fetch('collection');
	}

	//正在阅读模板展示
	public function reading()
	{
		return $this->fetch('reading');
	}

	//已购书籍模板展示
	public function buylist()
	{
		return $this->fetch('buylist');
	}

	//我的书评模板展示
	public function replay()
	{
		return $this->fetch('replay');
	}

	//上传书籍模板展示
	public function add()
	{
		return $this->fetch('add');
	}

	//我的书籍模板展示
	public function authorbook()
	{
		return $this->fetch('authorbook');
	}

	//待审核模板展示
	public function auditbook()
	{
		return $this->fetch('auditbook');
	}
}