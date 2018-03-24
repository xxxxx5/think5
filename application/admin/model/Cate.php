<?php

namespace app\admin\model;

use think\Model;

use think\Db;

class Cate extends Model
{
	//分类分级列表展示
	public function catemod()
	{
		$data = Db::name('cate')
				->field('*,concat(path ,"-", id) as paths')
				->where('isdel=0')
				->order('paths','desc')
				->select();
		
		foreach ($data as $k=>$v) {
			//$v['name'];
            $data[$k]['name'] = str_repeat("|--",$v['level']).$v['name'];
        }
        return $data;
	}

	//分类添加
	public function cateadd()
	{
		//用post接收传过来的值
		// dump(input());die;
		$name = input('post.name');
		$pid = input('post.pid');
		if ($name != '' && $pid != 0) {
			$path = Db::name('cate')->field('path')->find($pid);
			$data['path'] = $path['path'];
			//计算path里面的逗号来判断他的等级
			$data['level'] = substr_count($data['path'],',')+1; 
			//把数据插入数据库中
			$re = Db::name('cate')
				   ->insertGetId([
				   	'name' => $name,
				   	'pid'  => $pid,
				   	'path' => $data['path'],
				   	'level'=> $data['level']
				   ]);
			//用insertGetId得到当前的id拼接
			$paths['path'] = $data['path'] .','. $re;
			//拼接完之后的path，在进行修改
			return Db::name('cate')->where('id',$re)->update(['path'=>$paths['path'],'level'=>$data['level']]);
			
		}else if ($name != '' && $pid == 0) {
			
			$data['path'] = $pid;
			//计算path里面的逗号来判断他的等级
			$data['level'] = 1; 
			//把数据插入数据库中
			$re = Db::name('cate')
				   ->insertGetId([
				   	'name' => $name,
				   	'pid'  => $pid,
				   	'path' => $data['path'],
				   	'level'=> $data['level']
				   ]);
			//用insertGetId得到当前的id拼接
			$paths['path'] = $data['path'] .','. $re;
			//拼接完之后的path，在进行修改
			return Db::name('cate')->where('id',$re)->update(['path'=>$paths['path'],'level'=>$data['level']]);

		}else {
			echo '<script>alert("添加失败");</script>';	

		}
		
	}
	//分类显示遍历查询
	public function catebl()
	{
		return Db::name('cate')->where('isdel=0')->select();
	}
	//分类删除
	public function catedels()
	{
		// dump(input());die;
		$id = input('post.id');
	    $result = Db::name('cate')
					->where('id', $id)
					->update([
						'isdel' => 1
					]);
		
	}

	//分类模块分类
	public function categoryAjax()
	{
		return Db::name('cate')->field('id,pid,name')->select();
	}

	 //分类添加模板提交
    public function category_add()
    {
       
       // dump(input());die;
       $bname = input('bname');
       $author = input('author');
    
       $pid = input('pid');
       $content = input('content');
       $descript = input('descript');

       $file = request()->file('file');

       $info = $file->move(ROOT_PATH . 'public' . DS . 'book_uploads');

       //获取图片路径
       $path = '/book_uploads/'. $info->getSaveName();
    
		if($info){
		// 成功上传后 获取上传信息
		// 输出 jpg
		$info->getExtension();
		// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
		$info->getSaveName();
		// 输出 42a79759f284b767dfcb2a0197904287.jpg
		$info->getFilename();

		}else{
		// 上传失败获取错误信息
		echo $file->getError();
		}

		if (input('post.')) {
			return  Db::name('books')
						->insert([
							'bname'    => $bname,
							'author'   => $author,
							'type_id'  => $pid,
							'content'  => $content,
							'description' => $descript,
							'author'   => $author,
							'cover'    => $path,
							'add_time' => time()
						]);
			// dump($result);die
		}

    }
}