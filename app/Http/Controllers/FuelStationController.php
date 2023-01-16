<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;
use App\Models\Station;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Common;
use App\Models\District;

class FuelStationController extends Controller
{
    public function __construct()
    {
        $this->station = new Station();
        $this->reservation = new Reservation();
        $this->user = new User();
        $this->common = new Common();
        $this->district = new District();
    }

    public function verifyUserToken(Request $request)
    {

        try {
            $reservationData = $this->reservation->getByToken($request->post('token'));
            if ($reservationData) {
                $station = session()->get('station_data');
                if($reservationData->station_id == $station['id']){
                    if ($reservationData->reservation_status == 0) {
                        $response[0]['code'] = 200;
                        $response[0]['text'] = 'Success';
                        $response[0]['id'] = $reservationData->id;
                    } else {
                        $response[0]['code'] = 400;
                        $response[0]['text'] = 'Token is alredy used.';
                    }
                }else{
                    $response[0]['code'] = 400;
                    $response[0]['text'] = 'Token is not registered for your fuel station.';
                }

                
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = 'The provided token number is invalid. Please try again';
            }
        } catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        return $response;
    }


    public function fuelVerified()
    {
        if (session()->get('station_data')) {

            $reservation_id = request()->get('id');
            $reservationData = $this->reservation->getById($reservation_id);
            $customerData = $this->user->getByd($reservationData->customer_id);
            $stationData =  $this->district->getStationById($reservationData->station_id);
            $isvaliddate = 0;
            $paid = 0;
            $released = 0;

            if ($reservationData->payment_status == 1) {
                $paid = 1;
            }

            if ($reservationData->reservation_status == 1) {
                $released = 1;
            }

            $isvaliddate = $this->common->checkReservationValid($reservationData->created_at);

            return view('station.verified', ['isvaliddate' => $isvaliddate, 'paid' => $paid, 'released' => $released, 'last_reservation_list' => $reservationData, 'customerData' => $customerData,'stationData'=>$stationData]);
        } else {
            return redirect('/station-login');
        }
    }

    public function orderNow(Request $request){
        try{
            
            $orderData = array(
                'station_id'=>session()->get('station_data')['id'],
                'fuel_type'=>$request->post('fuel_type'),
                'qty'=>$request->post('qty'),
                'date'=>$request->post('date'),
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s')
            );

            $save = $this->station->saveOrder($orderData);

            if($save){
                $response[0]['code'] = 200;
                $response[0]['text'] = "Successfully sent";
            }else{
                $response[0]['code'] = 400;
                $response[0]['text'] = "Something went wrong. Please try again!";
            }

        }catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        return $response;
    }

    
}
