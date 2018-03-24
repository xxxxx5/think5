<?php
namespace app\index\controller;

use think\view;
use think\Controller;

class Read extends Controller
{
	public function read()
	{
		return $this->fetch('read');
	}
}	