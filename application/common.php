<?php
namespace app;

use think\Controller;
// 应用公共文件

class common extends Controller
{
	function node_merge($node, $access = null,$pid=0)
	{	
	    $arr=array();
	    
	    foreach ($node as $v) {
	    	if (is_array($access)) {
	    		$v['access'] = in_array($v['id'],$access) ? 1 : 0;
	    	}
	        if ($v['pid'] == $pid) {
	            $v['child'] = $this->node_merge($node, $access, $v['id']);
	            $arr[]=$v;
	        }
	    }
	    return $arr;
	}
}
