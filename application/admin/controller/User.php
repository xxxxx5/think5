<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\User as UserModel;

use app\admin\model\Admin as AdminModel;

use app\admin\model\Cate as CateMode;

use think\Db;

class User extends Controller
{
    //模板access
    public function access()
    {
    	return $this->fetch();
    }
    //审核模板
    public function applyAuthor()
    {
    	return $this->fetch();
    }

    //黑户模板
    public function heihu()
    {
        $user = new UserModel();
        $res = $user->heihus();
        $page = $res->render();
        $this->assign('page',$page);
        $this->assign('res',$res);
    	return $this->fetch();
    }  
    //取消黑户
    public function qxheihu()
    {
        // dump(input());die;
        $user = new UserModel();
        $res = $user->qxheihus();
    }

    //拉黑列表删除
    public function delheihu()
    {
        $user = new UserModel();
        $res = $user->delheihus();   
    }

    //板块模板
    public function category()
    {   
        $cat = new CateMode();
        $res = $cat->catemod();
        $this->assign('res',$res);
    	return $this->fetch();
    }
    
    //分类的添加管理categoryadd 遍历
    public function categoryadd()
    {
       $cat = new CateMode();
       
        $res = $cat->catemod();
        $this->assign('res',$res);
        return $this->fetch();
    }

    //使用ajax分类级别  ajax访问
    public function categoryAjax()
    {
        $cat = new CateMode();
        $res = $cat->catemod();
        echo json_encode($res);
    }

    //ajax访问 删除分类级别
    public function catedel()
    {      
        $id = input('get.id');
        $res = Db::name('cate')
            ->where(['pid'=>$id,'isdel'=>0])
            ->find();
       
        if ($res) {
            $str = '分类下面还有子分类，不允许删除!';
            echo json_encode($str);
        } else {
            $result = Db::name('cate')
                    ->where('id='.$id)
                    ->update([
                        'isdel'=>1
                    ]);
            echo 1;
        } 
    }
    //分类级别的添加
    public function cateadd()
    {
        $cat = new CateMode();
        $res = $cat->cateadd();
        if  ($res) {
            echo "<script>alert('添加数据成功');window.location.href='/admin/user/category.html'</script>";
        } else {
            echo "<script>alert('添加数据失败');window.location.href='/admin/user/category.html'</script>";
        }
    }

    //分类添加模板提交
    public function category_add()
    {
        $cat = new CateMode();
        $res = $cat->category_add();
        if  ($res) {
             echo "<script>alert('添加数据成功');window.location.href='/admin/user/categoryadd.html'</script>";
        } else {
            echo "<script>alert('添加数据失败');window.location.href='/admin/user/categoryadd.html'</script>";
        }
    }
}
