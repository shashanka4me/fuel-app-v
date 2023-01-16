<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Common;
use App\Models\District;
use App\Models\Fuel;
use Illuminate\Support\Facades\Log;

class NotifyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->reservation = new Reservation();
        $this->common = new Common();
        $this->district = new District();
        $this->fuel = new Fuel();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $waiting_payment_list = $this->reservation->getPaymentWaiting();

        foreach ($waiting_payment_list as $key => $value) {
            
            $isvaliddate = $this->common->checkReservationValid($value->created_at);

            if($isvaliddate == 0){
                $station_data = $this->district->getStationById($value->station_id);

                $avalilable = $station_data->available_volume;

                $newAvailable = $avalilable + $value->request_quata;

                $updateFuel = array(
                    'available_volume' => $newAvailable,
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $updateStock = $this->district->updateStation($updateFuel, $value->station_id);

                $updateReservation = array(
                    'reservation_status'=>3,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $updateRese = $this->reservation->updateReservation($updateReservation, $value->id);
                Log::info("Cron is working fine!");
            }
        }


        $order_request = $this->fuel->getAllOrdersByStatus(1);


        foreach ($order_request as $key => $value) {

            $date = date('Y-m-d');
            $outofrequestd = $this->fuel->getOutOfRequestByStationId($value->station_id);

            if($date == $value->date){
                $station_data = $this->district->getStationById($value->station_id);
                $avalilable = $station_data->available_volume;
                $newAvailable = $avalilable + $value->qty;
                $updateFuel = array(
                    'available_volume' => $newAvailable,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->district->updateStation($value->station_id);

                foreach ($outofrequestd as $key => $outofrequest) {
                    $date2 = date('Y-m-d 00:00:00');
                    if($outofrequest->request_date == $date2){
                        $station_data = $this->district->getStationById($value->station_id);
                        $avalilable = $station_data->available_volume;
                        $newAvailable = $avalilable - $outofrequest->request_amount;
    
                        if($outofrequest->read_status == 0){
                            $updateFuel = array(
                                'available_volume' => $newAvailable,
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                            
                            $update = $this->district->updateStation($value->station_id);
    
                            $updateOut = array(
                                'read_status' => 1,
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                            $update = $this->fuel->updateOutReq($updateOut,$outofrequest->id);
                        }
    
                    }
                }

                
            }

            foreach ($outofrequestd as $key => $outofrequest) {
                $now = date('Y-m-d H:i:s');
                $reserved_date = $outofrequest->request_date;
        
                $to_time = strtotime($now);
                $from_time = strtotime($reserved_date);
                $minute = round(abs($to_time - $from_time) / 60, 2);

                if($minute < 719){
                   
                    if($outofrequest->notify_status == 0){
                       
                        $updateOut = array(
                            'notify_status' => 1,
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $update = $this->fuel->updateOutReq($updateOut,$outofrequest->id);

                        Log::info("Cron is working fine!- Msg sent to customer");
                    }

                }
            }

        }



    }
}
