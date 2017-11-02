<?php

namespace app\vue\controller;

use think\Db;

class Index
{
    public function index()
    {
        $start = request()->get("start");
        $size = request()->get("size");
        $sql = "SELECT notes.note_id,notes.note_date,notes.note_school,notes.note_content_text,user.* from notes,user WHERE user.user_id=notes.user_id LIMIT " . $start . ",5";
        $rs = Db::query($sql);
        for ($i = 0; $i < count($rs); $i++) {
            //  echo $rs[$i]['note_id'];
            $sql2 = "select images.image_path from images where images.note_id=" . $rs[$i]['note_id'];
            $rs2 = Db::query($sql2);
            $images = array("images" => $rs2);
            array_push($rs[$i], $images);


        }

        //echo var_export($rs);


        $json = json_encode($rs);
        return $json;
    }
}
