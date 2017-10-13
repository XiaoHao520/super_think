<?php

namespace app\upload\controller;

class Index
{
    public function index()
    {
        echo "file upload";
// 获取表单上传文件 例如上传了001.jpg
        $file = request()->file("image");

// 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {

            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                echo "file3";
// 成功上传后 获取上传信息
// 输出 jpg
                echo "<br>";
                echo $info->getExtension();
                echo "<br>";
// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                echo "<br>";
// 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
                echo "<br>";
            } else {
// 上传失败获取错误信息
                echo $file->getError();
                echo "<br>";
            }

        }
    }
}
