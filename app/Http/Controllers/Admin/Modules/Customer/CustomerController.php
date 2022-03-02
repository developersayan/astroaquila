<?php

namespace App\Http\Controllers\Admin\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Mail;
use App\Mail\UserResetPassword;

class CustomerController extends Controller
{
        //
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     *   Method      : index
     *   Description : show customer manage view with serach funtionality
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

    public function index(Request $request)
    {
        $data = [];
        $data['allCustomer'] = User::where('status','!=','D')->where('user_type','C')->orderBy('id', 'desc')->with('gotra');
        if (@$request->keyword) {
           $data['allCustomer'] = $data['allCustomer']->where(function($query){
                $query->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                        )  
                      ->orWhere('email','LIKE','%'.request('keyword').'%')
                      ->orWhere('mobile','LIKE','%'.request('keyword').'%')
                      ->orWhere('user_unique_code','LIKE','%'.request('keyword').'%')
                      ->orWhere('address','LIKE','%'.request('keyword').'%');
           }); 
        }

        if(@$request->status){
            $data['allCustomer'] = $data['allCustomer']->where('status',request('status'));
        }
        $data['allCustomer']= $data['allCustomer']->paginate(10);
        return view('admin.modules.customer.customer_list')->with($data);
    }


    /**
     *   Method      : status
     *   Description : change customer status
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

    public function status($id)
    {
        $data = User::where('id',$id)->where('status','!=','D')->where('user_type','C')->first();
        if ($data==null) {
            return redirect()->back();        
        }
        if ($data->status=="A") {
            $inactive = User::where('id',$id)->update(['status'=>'I']);
            return redirect()->back()->with('success','Customer Status Deactivated Successfully');
        }

        if ($data->status=="I") {
            $inactive = User::where('id',$id)->update(['status'=>'A']);
            return redirect()->back()->with('success','Customer Status Activated Successfully');
        }
    }

      /**
     *   Method      : delete
     *   Description : change customer status
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

    public function delete($id)
    {
        $data = User::where('id',$id)->where('status','!=','D')->where('user_type','C')->first();
        if ($data==null) {
            return redirect()->back();        
        }
        $delete = User::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Customer Deleted Successfully');
    }

     /**
     *   Method      : view
     *   Description : customer view
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

     public function view($id)
     {
        $data = User::where('id',$id)->where('status','!=','D')->where('user_type','C')->with('orderbookings.pundit')->first();
        if ($data=="") {
            return redirect()->back();
        }
        return view('admin.modules.customer.customer_view',compact('data'));
     }
	 /**
     *   Method      : userResetPassword
     *   Description : To reset customer password
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-10
     **/

     public function userResetPassword($id)
     {
        $user = User::where('id',$id)->where('status','!=','D')->where('user_type','C')->first();
		if(!$user)
		{
			return redirect()->back();
		}
		$new_password=str_random(8);
		User::where('id',$id)->update(['password'=>Hash::make($new_password)]);
        $maildetails=array();
		$mail_details['new_password']=$new_password;
		$mail_details['full_name']=$user->first_name." ".$user->last_name;
		$mail_details['email']=$user->email;
		$mail_details['mobile']=$user->mobile;
		Mail::send(new UserResetPassword($mail_details));
		return redirect()->back()->with('success','New password sent successfully');
     }











}
