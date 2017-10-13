<?php

namespace app\mobile\controller;

use app\mobile\model\Notes;
use think\Controller;
use think\Db;


class Index extends Controller
{
    public function index()
    {


        $notes = new Notes();
        $total = $notes->count();
        $arr = $this->query(0, 5);
        $this->assign("total", $total);
        $this->assign("notes", $arr);
        return $this->fetch("card");
    }

    public function data()
    {
        $start = input("get.start");
        $arr = $this->query($start, 5);
        return $arr;
    }

    function query($start, $size)
    {
        $sql = "SELECT notes.*,user.* from notes,user WHERE user.user_id=notes.user_id LIMIT " . $start . ",5";
        $rs = Db::query($sql);
        $arr = array();




        for ($i = 0; $i < count($rs); $i++) {
            $str = "
<div class=\"card m-panel card9\">
    <div class=\"card-wrap\">
        <div class=\"card-main\"><!---->
            <header class=\"weibo-top m-box m-avatar-box\"><a class=\"m-img-box\"><img
                    src=\"" . $rs[$i]['user_header'] . "\">
                <!----></a>
                <div class=\"m-box-col m-box-dir m-box-center\">
                    <div class=\"m-text-box\"><a><h3 class=\"m-text-cut\">" . $rs[$i]['user_nickname'] . "
                        <!----></h3></a> <h4 class=\"m-text-cut\"><span class=\"time\">" . $rs[$i]['note_date'] . "</span> <span
                            class=\"from\"> 来自 " . $rs[$i]['note_school'] . "</span></h4></div>
                </div> <!----></header>
             <article class=\"weibo-main\">
                <div class=\"weibo-og\">
                    <div class=\"weibo-text\">" . $rs[$i]['note_content_text'] . " ​​​</div>
                    <div>
                        <div class=\"weibo-media-wraps weibo-media media-b\">
                           ".$rs[$i]['note_content_images']." <!----></div>
                    </div>
                </div> <!----></article>
            <footer class=\"m-ctrl-box m-box-center-a\">
                <div class=\"m-diy-btn m-box-col m-box-center m-box-center-a\"><i
                        class=\"m-font m-font-forward\"></i> <h4>转发</h4></div>
                <span class=\"m-line-gradient\"></span>
                <div class=\"m-diy-btn m-box-col m-box-center m-box-center-a\"><i
                        class=\"m-font m-font-comment\"></i> <h4>评论</h4></div>
                <span class=\"m-line-gradient\"></span>
                <div class=\"m-diy-btn m-box-col m-box-center m-box-center-a\"><i class=\"m-icon m-icon-like\"></i>
                    <h4>赞</h4></div>
            </footer>
        </div>
    </div>
</div>";

            array_push($arr, $str);
        }


        return $arr;
    }
}
