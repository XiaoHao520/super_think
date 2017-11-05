<?php
/**
 * Created by PhpStorm.
 * User: xiaohao
 * Date: 17-11-2
 * Time: 上午11:11
 */

namespace app\user\controller;

use think\Db;

class User
{
    public function login()
    {
        $username = request()->post("username");
        $password = request()->post("password");
        $rs = Db::table("user")->where("username", $username)->where("user_password", $password)->select();
        echo json_encode($rs);


    }

    public function register()
    {
        $username = request()->post("username");
        $password = request()->post("password");
        $userId = request()->post("userid");
        $userHeader = request()->post("userHeader");
        $userEmail = request()->post("email");

        //  $data	=	['foo'	=>	'bar',	'bar'	=>	'foo'];
        //  Db::table('think_user')->insert($data);   //添加成功返回1
        $data = ['username' => $username, 'user_id' => $userId, 'user_password' => $password, 'user_email' => $userEmail, 'user_header' => $userHeader];
        $rs = Db::table('user')->insert($data);
        if ($rs == 1) {
            $rs = Db::table('user')->where('user_id', $userId)->select();
            echo json_encode($rs);
        } else {
        }
        echo null;

    }
     public function modify(){

         $userHeader=request()->post("userHeader");
         $nickname=request()->post("nickname");
         $school=request()->post("school");
         $userid=request()->post("userid");
         if($userHeader!=null){
             $data=['user_school'=>$school,"user_nickname"=>$nickname,'user_header',$userHeader];

         }else{
             $data=['user_school'=>$school,"user_nickname"=>$nickname];
         }

         $rs=Db::table("user")->where('user_id',$userid)->update($data);


         $rs=Db::table("user")->where('user_id',$userid)->select();

         echo json_encode($rs);
     }

}