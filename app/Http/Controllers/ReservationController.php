<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Common;
use App\Models\Reservation;
use Throwable;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->district = new District();
        $this->common = new Common();
        $this->reservation = new Reservation();
    }

    public function requestTokenView()
    {

        $district_set = $this->district->getAllDistrict();
        $availableQutaforVehicle = $this->common->getQuataByVehicleNo(0);

        return view('request-token', ['district_set' => $district_set, 'oilQuata' => $availableQutaforVehicle]);
    }

    public function getSuberbByDistrict(Request $request)
    {
        $dis_id = $request->post('dis_id');
        $suberb_set = $this->district->getAllSuberbByDisId($dis_id);
        $options = '<option selected="">Select your suberb</option>';
        foreach ($suberb_set as $key => $value) {
            $options .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        return $options;
    }

    public function getStationBySuberb(Request $request)
    {
        $sub_id = $request->post('subid');
        $station_set = $this->district->getAllStationBySubId($sub_id);
        $options = '<option selected="">Select the fuel station</option>';
        foreach ($station_set as $key => $value) {
            $options .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        return $options;
    }

    public function makeReservation(Request $request)
    {

        try {
            $user_data = session()->get('user_data');
            $customer_id = $user_data['id'];

            $availableQutaforVehicle = $this->common->getQuataByVehicleNo(0);
            $amount = $this->common->getTotalAmount($availableQutaforVehicle);

            $reservationArray = array(
                'customer_id' => $customer_id,
                'station_id' => $request->post('station_id'),
                'request_quata' => $availableQutaforVehicle,
                'payment_status' => 0,
                'reservation_status' => 0,
                'reserve_time' => $request->post('time'),
                'reserve_date' => $request->post('date'),
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')
            );

            $reservation_id = $this->reservation->saveReservation($reservationArray);
            $token = $this->common->getTokenById($reservation_id);

            $tokenData = array(
                'token_no' => $token,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $update = $this->reservation->updateReservation($tokenData, $reservation_id);

            if ($update) {
                $station_data = $this->district->getStationById($request->post('station_id'));

                $avalilable = $station_data->available_volume;

                $requestLog = array(
                    'station_id' => $request->post('station_id'),
                    'customer_id' => $customer_id,
                    'reservation_id' => $reservation_id,
                    'request_amount' => $availableQutaforVehicle,
                    'request_date' => $request->post('date'),
                    'read_status' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                );


                if ($avalilable > $availableQutaforVehicle) {
                    $newAvailable = $avalilable - $availableQutaforVehicle;

                    if ($newAvailable > $station_data->min_volume) {
                        $updateFuel = array(
                            'available_volume' => $newAvailable,
                            'updated_at' => date('Y-m-d H:i:s')
                        );

                        $updateStock = $this->district->updateStation($updateFuel, $request->post('station_id'));
                    
                    } else {
                        $send_request = $this->district->saveRequest($requestLog);
                    }
                } else {
                    $send_request = $this->district->saveRequest($requestLog);
                }

                $response[0]['code'] = 200;
                $response[0]['text'] = "Success";
                $response[0]['reservation_id'] = $reservation_id;
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Somthing went wrong. Please try again!";
            }
        } catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }

        return $response;
    }

    public function makePaymentView()
    {
        $user_data = session()->get('user_data');
        $customer_id = $user_data['id'];
        $last_reservation_list = $this->reservation->getLastReservationByCustomer($customer_id);
        $stationData =  $this->district->getStationById($last_reservation_list->station_id);
        $isvaliddate = 0;
        $paid = 0;
        $released = 0;

        if ($last_reservation_list->payment_status == 1) {
            $paid = 1;
        }

        if ($last_reservation_list->reservation_status == 1) {
            $released = 1;
        }

        $isvaliddate = $this->common->checkReservationValid($last_reservation_list->created_at);

        return view('make-payment', ['isvaliddate' => $isvaliddate, 'paid' => $paid, 'released' => $released, 'last_reservation_list' => $last_reservation_list, 'stationName' => $stationData->name]);
    }

    public function makepayment(Request $request)
    {

        try {
            $updateDate = array(
                'payment_method' => 'Online',
                'payment_status' => 1,
                'payment_done_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $user_data = session()->get('user_data');
            $customer_id = $user_data['id'];

            $paymentData = array(
                'customer_id' => $customer_id,
                'station_id' => $request->post('station'),
                'reservation_id' => $request->post('id'),
                'paid_method' => 'Online',
                'created_at' => date('Y-m-d H:i:s')
            );

            $savePayment = $this->reservation->savePayment($paymentData);

            if ($savePayment) {
                $this->reservation->updateReservation($updateDate, $request->post('id'));
                $response[0]['code'] = 200;
                $response[0]['text'] = "Success";
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Somthing went wrong. Please try again!";
            }
        } catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }

        return $response;
    }

    public function releasedFuel(Request $request)
    {

        try {
            if($request->post('payment_status') == 0){
                $updateDate = array(
                    'payment_method' => 'Cash-on-hand',
                    'payment_status' => 1,
                    'payment_done_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'reservation_status'=>1
                );
                
            }else{
                $updateDate = array(
                    'updated_at' => date('Y-m-d H:i:s'),
                    'reservation_status'=>1
                );
            }

            $up = $this->reservation->updateReservation($updateDate, $request->post('id'));
            
            $reservation_data = $this->reservation->getById($request->post('id'));

            $user_data = session()->get('user_data');
            $customer_id = $reservation_data->customer_id;

            $paymentData = array(
                'customer_id' => $customer_id,
                'station_id' => $request->post('station'),
                'reservation_id' => $request->post('id'),
                'paid_method' => 'Cash-on-hand',
                'created_at' => date('Y-m-d H:i:s')
            );

            if($request->post('payment_status') == 0){
                $savePayment = $this->reservation->savePayment($paymentData);
            }
            

            if ($up) {
                $response[0]['code'] = 200;
                $response[0]['text'] = "Success";
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Somthing went wrong. Please try again!";
            }
        } catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }

        return $response;
    }
}
