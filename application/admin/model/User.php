<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $table = 'user';
    protected $pk = 'id';
    protected $connection = ['type' => 'mysql',
        'dsn' => '',
        'hostname' => 'localhost',
        'database' => 'super_school',
        'username' => 'root',
        'password' => 'root',
        'hostport' => '3306',
        'params' => '',
        'charset' => 'utf8',
        'prefix' => '',];
//	protected	$connection	=	'mysql://root:1234@127.0.0.1:3306/thinkphp#ut f8';
}