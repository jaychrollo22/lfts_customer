<?php

namespace App\Http\Controllers;

use App\ShipmentDetail;
use App\ShipmentDetailLog;

use App\User;

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
        $customer_code = auth()->user()->customer_code;
        $shipment_details = ShipmentDetail::where('customer_code', $customer_code)->orderBy('change_date' , 'DESC')->get();

        $logs=[];

        if($shipment_details){
            foreach($shipment_details as $k => $log){
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
            }   
        }
        return $logs;
    }

    //Get Shipment Detail Logs
    public function getShipmentDetailLogs($shipment_number){
        $shipment_detail_logs = ShipmentDetailLog::where('shipment_number', '=', $shipment_number)->orderBy('created_at','DESC')->orderBy('log_date_time','DESC')->get();
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

}
