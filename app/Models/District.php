<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class District extends Model
{
    use HasFactory;

    public function  getAllDistrict(){
        $results = DB::table('district')->select('*')->get();
        return $results;
    }

    public function  getDistrictByid($id){
        $results = DB::table('district')->where('id',$id)->first();
        return $results;
    }

    public function getAllSuberbByDisId($disid){
        $results = DB::table('suberb')->select('*')->where('district_id',$disid)->get();
        return $results;
    }

    public function getAllStationBySubId($subid){
        $results = DB::table('fuel_station')->select('*')->where('suberb_id',$subid)->get();
        return $results;
    }

    public function getStationById($stationId){
        $results = DB::table('fuel_station')->select('*')->where('id',$stationId)->first();
        return $results;
    }

    public function updateStation($data,$id){
        $results = DB::table('fuel_station')->where('id',$id)->update($data);
        return $results;
    }

    public function saveRequest($data){
        $results = DB::table('out_of_stock_request')->insert($data);
        return $results;
    }

    public function getBySecret($code){
        $results = DB::table('fuel_station')->select('*')->where('secret_code',md5($code))->first();
        return $results;
    }

    public function getSuberbById($id){
        $results = DB::table('suberb')->select('*')->where('id',$id)->first();
        return $results;
    }
}
