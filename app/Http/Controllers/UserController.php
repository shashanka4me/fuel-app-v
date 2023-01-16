<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Middleware\TrustProxies as Middleware;
use App\Models\Common;
use App\Models\District;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->user = new User();
        $this->common = new Common();
        $this->district = new District();
    }

    public function registerVehicle(Request $request)
    {
        try {

            $otp = $this->common->getOtp();

            $vehicleData = array(
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'mobile' => $request->post('mobile'),
                'vehicle_no' => $request->post('vehicle_no'),
                'chassis_no' => $request->post('chassis_no'),
                'password' => md5($otp),
                'created_at' => date('Y-m-d H:i:s')
            );

            $customer_id = $this->user->saveCustomer($vehicleData);
            if ($customer_id) {
                session(['email_to_be_log' => $request->post('email')]);
                $response[0]['code'] = 200;
                $response[0]['text'] = "Successfully registered";
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Something went wrong. Please try again!";
            }
        } catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }

        return $response;
    }

    public function verifyOtp(Request $request)
    {
        try {
            $email = session()->get('email_to_be_log');
            $otp = md5($request->post('otp'));
            $user = DB::table('customer')->where('email', $email)->first();

            if ($otp == $user->password) {
                $user_data = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                );
                session(['user_data' => $user_data]);

                $response[0]['code'] = 200;
                $response[0]['text'] = "Successfully registered";
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Something went wrong. Please try again!";
            }
        }catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        return $response;
    }

    public function login(Request $request)
    {
        try {
            $userIn = $this->user->getByMobile($request->post('mobile'));
            if ($userIn) {
                $otp = $this->common->getOtp();
                $vehicleData = array(
                    'password' => md5($otp),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $customer_id = $this->user->updateCustomer($vehicleData, $userIn->id);
                if ($customer_id) {
                    session(['email_to_be_log' => $userIn->email]);
                    $response[0]['code'] = 200;
                    $response[0]['text'] = "Success";
                } else {
                    $response[0]['code'] = 400;
                    $response[0]['text'] = "Something went wrong. Please try again!";
                }
            } else {
                $response[0]['code'] = 400;
                $response[0]['text'] = "Your mobile number is not registered!";
            }
        } catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        return $response;
    }

    public function verifySecret(Request $request){
        try{

            $code = $request->post('secret_code');
            $stationData = $this->district->getBySecret($code);

            if($stationData){
                $sessionData = array(
                    'name'=>$stationData->name,
                    'id'=>$stationData->id
                );
                session(['station_data' => $sessionData]);
                
                $response[0]['code'] = 200;
                $response[0]['text'] = "Success";
            }else{
                $response[0]['code'] = 400;
                $response[0]['text'] = "Secret code can not verify. Please try again!";
            }


        }catch (Throwable $e) {
            $response[0]['code'] = 400;
            $response[0]['text'] = $e->getMessage();
        }
        return $response;
    }

    public function logoutStation(){
        session()->forget('station_data');
        return redirect('/station-login');
    }

    public function adminLogin(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {

            $response[0]['code'] = 200;
            $response[0]['text'] = "Success";

        }else{
            $response[0]['code'] = 400;
            $response[0]['text'] = "Something went wrong. Please try again!";
        }
        return $response;
    }
}
