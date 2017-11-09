<?php

namespace app\store\controller;

use think\Db;
use think\response\Json;

class Index
{


    public function apply()
    {

        $username = request()->post("username");
        $storeName = request()->post("storename");
        $storeDsc = request()->post("storeDsc");
        $storeHolder = request()->post("storeholder");
        $storeAddress = request()->post("storeaddress");
        $storeLat = request()->post("lat");
        $storeLon = request()->post("lon");
        $storeType = request()->post("type");
        $storeSchool = request()->post("school");
        $data = [
            'store_name' => $storeName,
            'store_holder' => $storeHolder,
            'store_business' => $storeType,
            'store_intro' => $storeDsc,
            'store_lat' => $storeLat,
            'store_lon' => $storeLon,
            'store_school' => $storeSchool,
            'store_address' => $storeAddress,
        ];
        $rs = Db::table("store")->insert($data);
        if ($rs == 1) {
            Db::table("user")->where("username", $username)->setInc("store");

            $this->insertHistory($storeHolder, $storeName);
            echo 'ok';
        } else {
            echo 'error';
        }


    }

    public function insertHistory($storeHolder, $storeName)
    {
        $data = [
            'store_holder' => $storeHolder,

            'store_name' => $storeName
        ];
        Db::table("store_history")->insert($data);
    }

    public function addHistory()
    {
        $storeName = request()->post("store");
        Db::table('store_history')->where("store_name", $storeName)->setInc('store_history_num');
    }


    public function getHistory()
    {
        $storeHolder = request()->post("holder");
        $rs = Db::table('store_history')->where("store_holder", $storeHolder)->select();
        echo json_encode($rs);
    }
    public function del(){

        $storeName=request()->post("store");
        Db::table("store_history")->where("store_name",$storeName)->delete();
        Db::table("store")->where("store_name",$storeName)->delete();


    }


}
