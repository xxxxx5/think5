<?php
namespace app\index\controller;

use think\View;
use think\Controller;

class Book extends Controller
{
    public function lst()
    {
    	return $this->fetch('lst');
    }
}