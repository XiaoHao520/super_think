<?php
/**
 * Created by PhpStorm.
 * User: XIAOHAO-PC
 * Date: 2017-09-22
 * Time: 21:33
 */

namespace app\admin\model;

use think\Model;

class News extends Model
{

    protected $table = 'news';
    protected $pk = 'id';
    protected $connection = ['type' => 'mysql',
        'dsn' => '',
        'hostname' => 'localhost',
        'database' => 'wiseschool',
        'username' => 'root',
        'password' => 'root',
        'hostport' => '3306',
        'params' => '',
        'charset' => 'utf8',
        'prefix' => '',];
//	protected	$connection	=	'mysql://root:1234@127.0.0.1:3306/thinkphp#ut f8';

}