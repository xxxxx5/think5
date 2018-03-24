<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\Pic as PicModel;

use think\Db;

class Pic extends Controller
{
	//图片轮播添加
	public function pic()
	{
	  $pic = new PicModel();
	  $pic->picadd(input('post.'));
	  $this->redirect('info/carousel');
	}
	public function picdel()
	{
		$pic = new PicModel();
		$pic->picdels(input('post.'));
		 $this->redirect('info/carousel');
	}

	//多图片上传
	public function morepic()
	{
		  //按照时间创建文件夹
        $file_path= $_SERVER['DOCUMENT_ROOT'] .'/pic_uploads/' . date("Y").'/' . date("m"). '/' .date("d").'/';
        //$uploaddir = "uploads/"; //目录	
        if(!is_dir($file_path)){
        	if (!file_exists($file_path)) {
        		if (mkdir($file_path,777,true)) {
            	}
        	}
           
        }
        //处理文件的后缀
        $houzh = explode('.', $_FILES["file"]["name"] );//名称  和 后缀名
        $taoc = array_pop($houzh); //取后缀
        //dump($taoc);die;
        $time = time();
        $random = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $aa = str_shuffle($random);//打乱字符串
        $endradom = substr($aa,0,5);//取前五个字符
        //拼接路径
        $uploadfile = $file_path . $time . $endradom . '.' . $taoc ;
        
		print "<pre>";
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			 $cf = explode('/pic_uploads/',$uploadfile);
			$uploadfile =  '/pic_uploads/'.$cf[1];
			$data = [ 'pic_url' => $uploadfile,'create_time'=>time()]	;
			Db::name('pic')->insert($data);
			$re = [
				'dir' =>'/'.$uploadfile,
				'msg' =>"上传成功",
				'status'=>200
			];
	        //echo json_encode($re);
		} else {

	        $re['msg']="上传成功";
	        echo json_encode($re);
		}	
		
	}

}
