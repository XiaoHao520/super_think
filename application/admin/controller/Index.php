<?php
namespace app\admin\controller;
 use app\admin\model\News;
 use app\admin\model\User;
class Index
{
    public function index()
    {
        $news=News::get(1);
        echo $news['content'];

        $user=User::get(1);
        echo $user['user_nickname'];

     return '<h1>测试admin</h1>';
   }
}
