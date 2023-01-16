<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fuel extends Model
{
    use HasFactory;

    public function getStockData(){
        $results = DB::table('fuel_quota')->get();
        return $results;
    }

    public function updateFuealQuata($data,$id){
        $results = DB::table('fuel_quota')->where('id',$id)->update($data);
        return $results;
    }

    public function getAllOrders(){
        $results = DB::table('order')->where('status',0)->get();
        return $results;
    }

    public function getAllOrdersByType($type){
        $results = DB::table('order')->where('fuel_type',$type)->where('status',0)->get();
        return $results;
    }

    public function getAllOrdersByStatus($status){
        $results = DB::table('order')->where('status',$status)->where('status',0)->get();
        return $results;
    }

    public function getOutOfRequestByStationId($id){
        $results = DB::table('out_of_stock_request')->where('station_id',$id)->where('read_status',0)->get();
        return $results;
    }

    public function updateOutReq($data,$id){
        $results = DB::table('out_of_stock_request')->where('id',$id)->update($data);
        return $results;
    }

    

    

}
