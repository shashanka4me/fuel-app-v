<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    use HasFactory;

    public function getQuataByVehicleNo($vehicleNo)
    {
        return 20;
    }

    public function getOtp()
    {
        return 1234;
    }

    public function getTokenById($id)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return ($randomString . $id);
    }

    public function getTotalAmount($volume)
    {
        $qty = $volume;
        $amount_per_l = 400;
        $total = $qty * $amount_per_l;
        return $total;
    }

    public function checkReservationValid($date)
    {
        $now = date('Y-m-d H:i:s');
        $reserved_date = $date;

        $to_time = strtotime($now);
        $from_time = strtotime($reserved_date);
        $minute = round(abs($to_time - $from_time) / 60, 2);

        if($minute > 181){
            return 0;
        }else{
            return 1;
        }
    }
}
