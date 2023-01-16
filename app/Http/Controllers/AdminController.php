<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fuel;
use Throwable;
use App\Models\District;
use App\Models\Station;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->fuel = new Fuel();
        $this->district = new District();
        $this->station = new Station();
        $this->user = new User();
    }

    public function manageFuelPage(){
        if(Auth::check()){
            $stock_data = $this->fuel->getStockData();
            return view('admin.fuel-manage',['stock_data'=>$stock_data]);
        }else{
            return redirect('/admin-login');
        }
    }

    public function updateQuota(Request $request){
        try{
            
            $updatedata = array(
                'weekly_quota'=>$request->post('value'),
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $update = $this->fuel->updateFuealQuata($updatedata,$request->post('id'));
            if ($update) {
                $response[0]['code'] = 200;
                $response[0]['text'] = "Success";
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Something went wrong. Please try again!";
            }

        }catch(Throwable $e){
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        return $response;
    }

    public function manageFillingStationPage(){
        if(Auth::check()){
            if(request()->get('type') == 'all'){
                $all_orders = $this->fuel->getAllOrders();
            }else{
                $all_orders = $this->fuel->getAllOrdersByType(request()->get('type'));
            }
            
            foreach($all_orders as $key=>$val){
                $station_data =  $this->district->getStationById($val->station_id);
                $suberb_data = $this->district->getSuberbById($station_data->suberb_id);
                
                $all_orders[$key]->station_name = $station_data->name;
                $all_orders[$key]->suberbname = $suberb_data->name;
            }
            

            return view('admin.filing-station-manage',['all_orders'=>$all_orders]);
        }else{
            return redirect('/admin-login');
        }
    }

    public function updateOrder(Request $request){
        try{
            $data = array(
                'status'=>$request->post('status'),
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $update = $this->station->updateOrder($data,$request->post('id'));

            if($update){
                $response[0]['code'] = 200;
                $response[0]['text'] = "Success";
            }else{
                $response[0]['code'] = 400;
                $response[0]['text'] = "Something went wrong. Please try again!";
            }

        }catch(Throwable $e){
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        
        return $response;
       
    }

    public function fuelDistribution(){
        if(Auth::check()){
            if(request()->get('type') == 'all'){
                $all_station = $this->station->getAllStation();
            }else{
                $all_station = $this->station->getAllStation();
            }
            
            foreach($all_station as $key=>$val){
                
                $suberb_data = $this->district->getSuberbById($val->suberb_id);
                $district_data = $this->district->getDistrictByid($val->district_id);
                $all_station[$key]->suberdata = $suberb_data;
                $all_station[$key]->districtdatat = $district_data;
            }
            

            return view('admin.distribution-manage',['all_station'=>$all_station]);
        }else{
            return redirect('/admin-login');
        }
    }

    public function vehicleRegistratndata(){
        if(Auth::check()){
            $all_customers = $this->user->getAllCustomers();
            
            return view('admin.vehicle-manage',['all_customers'=>$all_customers]);
        }else{
            return redirect('/admin-login');
        }
    }
}
