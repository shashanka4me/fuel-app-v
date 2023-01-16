<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Station extends Model
{
    use HasFactory;

    public function saveOrder($data){
        $result = DB::table('order')->insert($data);
        return $result;
    }

    public function updateOrder($data,$id){
        $result = DB::table('order')->where('id',$id)->update($data);
        return $result;
    }

    public function getAllStation(){
        $results = DB::table('fuel_station')->select('*')->get();
        return $results;
    }

    
}
