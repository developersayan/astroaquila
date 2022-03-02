<?php

namespace App\Http\Controllers\Modules\Pundits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gotra;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use  App\Models\UserAccount;
use App\Models\UserToAvailable;
use App\Models\Puja;
use App\Models\Country;
use App\Models\State;
use App\Models\PunditToPuja;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\ChangeEmailPandit;
use App\Mail\NotifyCustomerAssignPundit;
use App\Mail\PunditRejectPuja;
use App\Models\OrderMaster;
use App\Models\OrderPujaNames;
class PujaOrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('pundits.access');
    }
    /**
     *   Method      : delete_puja_history
     *   Description : Pundits profile
     *   Author      : Sayan
     *   Date        : 2021-JUN-10
     **/
     public function delete_puja_history($id)
     {
        $check = OrderMaster::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        $del = OrderMaster::where('id',$id)->delete();
        return redirect()->back()->with('success',\Lang::get('profile.delete_puja_history'));
     }
    /**
     *   Method      : pujaHistory
     *   Description : booking puja history
     *   Author      : Sayan
     *   Date        : 2021-JUN-10
     **/
public function pujahistory(Request $request)
 {
    $data = [];

    $data['pujas'] = OrderMaster::where('user_id',auth()->user()->id)->orderBy('id','desc');
    if (@$request->keyword) {
       $data['pujas'] = $data['pujas']->where(function($query){
         $query->where('order_id','LIKE','%'.request('keyword').'%')
               ->orWhereHas('customer',function($q){
                $q->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                        );
               })->orWhereHas('pujas',function($q){
                $q->where('puja_name','LIKE','%'.request('keyword').'%');
               });
       });
    }

   if(@$request->from_date && @$request->to_date=="")
        {
            $data['pujas'] = $data['pujas']->where('date',[date('Y-m-d',strtotime($request->from_date))]);
        }
       

    if(@$request->from_date && @$request->to_date)
    { 
       $data['pujas'] = $data['pujas']->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
           
    }

    if (@$request->status) {
        $data['pujas'] = $data['pujas']->where('status',request('status'));
    }
    $data['pujas'] = $data['pujas']->orderBy('id','desc')->paginate(6);
    return view('modules.pundit.puja_history',$data);
 }
    /**
     *   Method      : pujaHistoryView
     *   Description : view puja order details
     *   Author      : Soumojit
     *   Date        : 2021-JUN-10
     **/
    public function pujaHistoryView($slug=null)
    {
        $data = [];
        $pujaDetails = OrderMaster::with('mantraDetails')->where('user_id',auth()->user()->id)->with(['customer','pujas'])->where('order_id',$slug)->first();
        
        if($pujaDetails){
            $data['pujaDetails']= $pujaDetails;
            // return $slug;
            $data['pujaNames'] = OrderPujaNames::where('ordermaster_id',$pujaDetails->id)->get();
            // return $data['pujaNames'];
            return view('modules.pundit.puja_history_view')->with($data);
        }
        return redirect()->route('pundit.puja.history')->with('error',\Lang::get('profile.unauthorized_access'));
    }

    public function pujaAccept($id)
    {
        $check = OrderMaster::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        $update = OrderMaster::where('id',$id)->update(['status'=>'A','pundit_accepted'=>'Y']);
        // mail-to-customer 
        $user = User::where('id',$check->customer_id)->first();
        $pundit = User::where('id',$check->user_id)->first();
        $puja = Puja::where('id',$check->puja_id)->first();
        $data = [
           'name'=> $user->first_name,
           'last_name'=>$user->last_name,
           'email'=>$user->email,
           'puja'=>$puja->puja_name,
           'order_id'=>$check->order_id,
           'date'=>date('d/m/Y',strtotime($check->date)),
           'pundit_name'=>$pundit->first_name,
           'pundit_last'=>$pundit->last_name,
        ];
        Mail::send(new NotifyCustomerAssignPundit($data));
        return redirect()->back()->with('success','Puja Accepted Successfully');
    }

    public function pujaReject($id)
    {
        $check = OrderMaster::where('id',$id)->first();

        if ($check==null) {
            return redirect()->back();
        }
        $pundit = User::where('id',$check->user_id)->first();
        $update = OrderMaster::where('id',$id)->update(['pundit_accepted'=>'N','user_id'=>null]);
        // mail-to-admin
        
        $puja = Puja::where('id',$check->puja_id)->first();
        $data = [
           'puja'=>$puja->puja_name,
           'order_id'=>$check->order_id,
           'date'=>date('d/m/Y',strtotime($check->date)),
           'pundit_name'=>$pundit->first_name,
           'pundit_last'=>$pundit->last_name,
        ];
        Mail::send(new PunditRejectPuja($data));
        return redirect()->back()->with('success','Puja Rejected Successfully');
    }

    public function pujaInprocess($id)
    {
        $check = OrderMaster::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        $update = OrderMaster::where('id',$id)->update(['status'=>'IP']);
        return redirect()->back()->with('success','Puja Status Changed In Inprocess Successfully');
    }

    public function pujaComplete($id)
    {
        $check = OrderMaster::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        $update = OrderMaster::where('id',$id)->update(['status'=>'C']);
        return redirect()->back()->with('success','Puja Completed Successfully');
    }



}
