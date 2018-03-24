<?php
namespace app\damin\model;

use think\Validate;

class Validate extends Validate

{
   protected $rule = [
    'card_no'    => ['/(^\d(15)$)|((^\d{18}$))|(^\d{17}(\d|X|x)$)/'],
    'mobile'     => ['/^1[34578]\d{9}$/'],
    'email'      => 'email',
	];	
    protected $message = [
        'card_no'    => '非法身份证号，请仔细核实',
        'mobile'     => '手机号格式不正确',
        'email.email'=> '邮箱格式错误',
    ];
}