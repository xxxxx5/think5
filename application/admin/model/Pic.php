<?php

namespace app\admin\model;

use think\Model;

use think\Db;

class Pic extends Model
{
	public function picmod()
	{
		return Db::name('pic')->where('isdel=0')->order('id desc')->paginate(3);
	}
	
	//添加图片
	public function picadd()
	{
		// return dump(input());die;
		
		$file = request()->file('file');
		//获取图片路径
		$fileurl = $file->getInfo('tmp_name');

	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'pic_uploads');
	    //获取图片路径
	    $path = '/pic_uploads/'. $info->getSaveName();

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
	    }

	    $infos = $info->hash('sha1');

	    if (input('post.')) {

	    	$pic_url = input('post.pic_url');

	    	return Db::name('pic')->insert(['pic'=>$infos,'pic_url'=>$path,'create_time'=>time()]);

	    } 
		
	}
	//删除图片
	public function picdels()
	{
		dump(input());
		if (input()) {
			$id = input('id');
			return Db::name('pic')
					->where('id',$id)
					->update([
						'isdel' => 1,
						'delete_time' => time()
					]);
		}
		
	}

	//多图片上传
	public function morePic()
	{
		
		$uploaddir = '/pics_uploads/';
		die;
		$uploadfile = $uploaddir. $_FILES['file']['name'];

		print "<pre>";
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $_FILES['file']['name'])) {
		    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
		    print_r($_FILES);
		} else {
		    print "Possible file upload attack!  Here's some debugging info:\n";
		    print_r($_FILES);
		}
		print "</pre>";

	}
}