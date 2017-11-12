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
        $sql = "SELECT notes.*,user.* from notes,user WHERE user.user_id=notes.user_id order by note_id desc LIMIT " . $start . ",5";
        $rs = Db::query($sql);
        $arr = array();


        for ($i = 0; $i < count($rs); $i++) {
            $str = "
<div  class=\"card m-panel card9\">
    <div class=\"card-wrap\">
        <div class=\"card-main\"><!---->
            <header  onclick='headerClick(" . $rs[$i]['username'] . ")' class=\"weibo-top m-box m-avatar-box\"><a class=\"m-img-box\"><img
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
                           " . $rs[$i]['note_content_images'] . " <!----></div>
                    </div>
                </div> <!----></article>
            <footer class=\"m-ctrl-box m-box-center-a\">
                     <span class=\"m-line-gradient\"></span>
                <div onclick='noteClick(" . $rs[$i]['note_id'] . ")' class=\"m-diy-btn m-box-col m-box-center m-box-center-a\"><i
                        class=\"m-font m-font-comment\"></i> <h4>评论</h4></div>
                <span class=\"m-line-gradient\"></span>   <span class=\"m-line-gradient\"></span>
                <div onclick='likeClick(" . $rs[$i]['note_id'] . ",this.id)' id='" . $rs[$i]['username'] . "'  class=\"m-diy-btn m-box-col m-box-center m-box-center-a\"><i  class=\"m-icon m-icon-like\"></i>
                    <h4 id='" . $rs[$i]['note_id'] . "'>" . $this->findLike($rs[$i]['note_id']) . "</h4></div>
            </footer>
        </div>
    </div>
</div>";

            array_push($arr, $str);
        }

        // echo var_export($arr);
        return $arr;
    }

    private function findLike($note)
    {
        $rs = Db::query("select count(note_id) AS num from likes WHERE note_id=" . $note);
        if ($rs[0]['num'] == 0) {
            $rs = '赞';
            return $rs;
        }
        return $rs[0]['num'];
    }


    public function savenote()
    {
        //$

        $userId = request()->post("userid");
        $content = request()->post("content");
        $date = request()->post("date");
        $images = request()->post("images");
        $arr = explode("%", $images);


        $lis = "";
        for ($i = 0; $i < count($arr) - 1; $i++) {
            $lis = $lis . $this->pushImage($arr[$i]);
        }
        $lis = "<ul class=\"m-auto-list\">" . $lis . "</ul>";
        $data = ["user_id" => $userId, "note_date" => $date, "note_content_text" => $content, "note_content_images" => $lis, "note_school" => "中山大学南方学院"];
        Db::table("notes")->insert($data);
        echo $lis;
    }


    private function pushImage($image)
    {

        $li = " <li class=\"m-auto-box\">
                                     <div class=\"m-img-box m-imghold-square\"><img
                                             src=\"" . $image . "\">
                                     </div>
                                 </li>";
        return $li;
    }

    public function like()
    {
        $from = request()->post("from");
        $to = request()->post("to");
        $note = request()->post("noteid");
        $data = ['note_id' => $note, 'from_user' => $from, 'to_user' => $to];
        Db::table("likes")->insert($data);
        $this->findLike($note);
    }

    public function oneNote()
    {
        $id = request()->get("noteid");
        $sql = "SELECT notes.*,user.* from notes,user WHERE user.user_id=notes.user_id order by note_id";
        $rs = Db::query($sql);
        $note = $rs[0];
        $str = "
<div  class=\"card m-panel card9\">
    <div class=\"card-wrap\">
        <div class=\"card-main\"><!---->
            <header  onclick='headerClick(" . $note['username'] . ")' class=\"weibo-top m-box m-avatar-box\"><a class=\"m-img-box\"><img
                    src=\"" . $note['user_header'] . "\">
                <!----></a>
                <div class=\"m-box-col m-box-dir m-box-center\">
                    <div class=\"m-text-box\"><a><h3 class=\"m-text-cut\">" . $note['user_nickname'] . "
                        <!----></h3></a> <h4 class=\"m-text-cut\"><span class=\"time\">" . $note['note_date'] . "</span> <span
                            class=\"from\"> 来自 " . $note['note_school'] . "</span></h4></div>
                </div> <!----></header>
             <article class=\"weibo-main\">
                <div class=\"weibo-og\">
                    <div class=\"weibo-text\">" . $note['note_content_text'] . " ​​​</div>
                    <div>
                        <div class=\"weibo-media-wraps weibo-media media-b\">
                           " . $note['note_content_images'] . " <!----></div>
                    </div>
                </div> <!----></article>
        
        </div>
    </div>
</div>";
        $this->assign("note", $str);
        return $this->fetch("index/onenote");
    }

}
