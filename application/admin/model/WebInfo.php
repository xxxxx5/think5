<?php
namespace app\admin\model;

use think\Model;

use think\Db;

class WebInfo extends Model
{
	public function webInfos()
	{
		return Db::name('webinfo')->select();
	}

	public function webups()
	{
		//用input 接收传过来的数据
		// dump(input());die;
		$webname      = input('post.webname');
		$weburl       = input('post.weburl');
		$web_word     = input('post.web_word');
		$web_descript = input('post.web_descript');
		$icp          = input('icp');
		$info         = input('info');
    	
    	/*$file = request()->file('logo');
		//获取图片路径
		$fileurl = $file->getInfo('tmp_name');

	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'web_uploads');
	    //获取图片路径
	    $path = '/web_uploads/'. $info->getSaveName();
*/
	   /* if($info){
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
*/
    	
		//修改表进行数据的修改
		$resutlt = Db::name('webinfo')
					->where('id',2)
					->update([
						'webname'   => $webname,
						'icp'       => $icp,
						'weburl'    => $weburl,
						'web_word'  => $web_word,
						'web_descript' => $web_descript,
						// 'logo'      => $path,
						'info'      => $info
					]);

		
	}
}