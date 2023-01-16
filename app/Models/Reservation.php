<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    public function saveReservation($data){
        $result = DB::table('reservations')->insertGetId($data);
        return $result;
    }

    public function updateReservation($data,$id){
        $result = DB::table('reservations')->where('id',$id)->update($data);
        return $result;
    }

    public function getLastReservationByCustomer($cusid){
        $result = DB::table('reservations')->where('customer_id',$cusid)->orderBy('id','DESC')->first();
        return $result;
    }

    public function savePayment($data){
        $result = DB::table('payments')->insert($data);
        return $result;
    }

    public function getByToken($token){
        $result = DB::table('reservations')->where('token_no',$token)->first();
        return $result;
    }

    public function getById($id){
        $result = DB::table('reservations')->where('id',$id)->first();
        return $result;
    }

    public function getPaymentWaiting(){
        $result = DB::table('reservations')->where('payment_status',0)->where('reservation_status',0)->get();
        return $result;
    }
}
