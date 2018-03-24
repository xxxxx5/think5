<?php
namespace app\index\controller;

use think\View;

use think\Controller;

class Booklist extends Controller
{
    public function index()
    {
    	return $this->fetch('booklist');
    }
}