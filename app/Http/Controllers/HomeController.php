<?php

namespace App\Http\Controllers;

use App\ShipmentDetail;
use App\ShipmentDetailLog;
use App\CustomerShipmentDetail;
use App\CustomerShipmentDetailLog;
use App\CustomerDoDetail;

use App\User;
use App\Driver;

use Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function shipmentDetail(){
        $email = Auth::user()->email;
        
        $shipment_details = CustomerShipmentDetail::where('email', $email)->whereIn('status', ['In Plant','In Transit', 'Reach Destination'])->orderBy('updated_at' , 'DESC')->get();
        
        $logs = [];
        if($shipment_details){
            foreach($shipment_details as $k => $log){
                $driver = Driver::where('cardholder_id' , $log['CardholderID'])->first();

                $logs[$k]['id'] = $log['id'];
                $logs[$k]['change_date'] = $log['change_date'] ? date('h:m A m/d/Y',strtotime($log['change_date'])) : "";
                $logs[$k]['shipment_number'] = $log['shipment_number'];
                $logs[$k]['do_number'] = $log['do_number'];
                $logs[$k]['customer_code'] = $log['customer_code'];
                $logs[$k]['customer_name'] = $log['customer_name'];
                $logs[$k]['delivery_address'] = $log['delivery_address'];
                $logs[$k]['status'] = $log['status'];
                $logs[$k]['plate_number'] = $log['plate_number'];
                $logs[$k]['estimated_time_travel'] = $log['estimated_time_travel'];
                $logs[$k]['mobile_number'] = $log['mobile_number'];
                $logs[$k]['distance_text'] = $log['distance_text'];
                $logs[$k]['plant'] = $log['plant'];
                $logs[$k]['shipment_current_coordinates'] = $log['shipment_current_coordinates'];
                $logs[$k]['shipment_delivery_coordinates'] = $log['shipment_delivery_coordinates'];

                $logs[$k]['driver_name'] = $driver ? $driver['name'] : "";
                $logs[$k]['driver_phone_number'] = $driver ? $driver['phone_number'] : "";
            }   
        }
        return $logs;
    }
    public function shipmentDetailFilter(Request $request){
        $email = Auth::user()->email;

        $request->validate([
            'from' => 'required',
            'to' => 'required|after_or_equal:from'
        ]);

        $from = $request->from ? $request->from : ""; 
        $to = $request->to ? $request->to : "";
    
        $shipment_details = CustomerShipmentDetail::where('email', $email)
                                            ->where('updated_at', '>=',  $from)
                                            ->whereDate('updated_at' ,'<=', $to)
                                            ->orderBy('updated_at','DESC')->get();
        $logs = [];
        if($shipment_details){
            foreach($shipment_details as $k => $log){
                $driver = Driver::where('cardholder_id' , $log['CardholderID'])->first();

                $logs[$k]['id'] = $log['id'];
                $logs[$k]['change_date'] = $log['change_date'] ? date('h:m A m/d/Y',strtotime($log['change_date'])) : "";
                $logs[$k]['shipment_number'] = $log['shipment_number'];
                $logs[$k]['do_number'] = $log['do_number'];
                $logs[$k]['customer_code'] = $log['customer_code'];
                $logs[$k]['customer_name'] = $log['customer_name'];
                $logs[$k]['delivery_address'] = $log['delivery_address'];
                $logs[$k]['status'] = $log['status'];
                $logs[$k]['plate_number'] = $log['plate_number'];
                $logs[$k]['estimated_time_travel'] = $log['estimated_time_travel'];
                $logs[$k]['mobile_number'] = $log['mobile_number'];
                $logs[$k]['distance_text'] = $log['distance_text'];
                $logs[$k]['plant'] = $log['plant'];
                $logs[$k]['shipment_current_coordinates'] = $log['shipment_current_coordinates'];
                $logs[$k]['shipment_delivery_coordinates'] = $log['shipment_delivery_coordinates'];

                $logs[$k]['driver_name'] = $driver ? $driver['name'] : "";
                $logs[$k]['driver_phone_number'] = $driver ? $driver['phone_number'] : "";
            }   
        }
        return $logs;
    }

    //Get Shipment Detail Logs
    public function getShipmentDetailLogs(Request $request){

        $shipment_number = $request->shipment_number;
        $customer_code = $request->customer_code;
      
        $shipment_detail_logs = CustomerShipmentDetailLog::where('shipment_number', '=', $shipment_number)
                                                            ->where('customer_code', '=', $customer_code)
                                                            ->orderBy('created_at','DESC')->orderBy('log_date_time','DESC')->get();
        return  $shipment_detail_logs;
    }

    //Change Password
    public function authUserData(){
        return Auth::user();
    }
    
    public function change_password(){
        return view('change_password');
    }

    public function changePassword(Request $request){

        $validator = $request->validate([
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ]);
    
        $user = User::findOrFail($request->user_id);
       
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return $user;
    }

    public function customerDODEtails(Request $request){
        $data = $request->all();
        $do_numbers = explode(',',$data['do_number']);
        return $customer_do_details = CustomerDoDetail::whereIn('do_number',$do_numbers)
                                                        ->where('shipment_number', $data['shipment_number'])
                                                        ->where('customer_code', $data['customer_code'])
                                                        ->where('qty','>',0)
                                                        ->get();

    }

}
