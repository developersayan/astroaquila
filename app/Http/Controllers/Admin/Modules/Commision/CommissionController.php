<?php

namespace App\Http\Controllers\Admin\Modules\Commision;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\User;
class CommissionController extends Controller
{
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
    public function index(Request $request)
    {
    	$data = [];
    	$data['commision'] = Commission::where('id',1)->first();
    	$data['users'] = User::where('status','A')->where('approve_by_admin','Y')->where('user_type','!=','C');
    	if (@$request->keyword) {
    		$data['users'] = $data['users']->where(function($q){
                $q->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                        )->orWhere('email','LIKE','%'.request('keyword').'%')->orWhere('mobile','LIKE','%'.request('keyword').'%');
            });
    	}
    	if (@$request->type) {
    		$data['users'] = $data['users']->where('user_type',request('type'));
    	}
    	$data['users'] = $data['users']->orderBy('id','desc')->paginate(10);
    	return view('admin.modules.commission.manage_commision',$data);
    }

    public function comission_update(Request $request)
    {
    	$request->validate([
    		'call_comm'=>'required',
    		'puja_comm'=>'required',
    	]);
    	$updated = Commission::where('id',1)->update([
    		'call_comm'=>$request->call_comm,
    		'puja_comm'=>$request->puja_comm,
    	]);
    	return redirect()->back()->with('success','Commision updated successfully');
    }

    public function edit_commission_view($id)
    {
    	$data = [];
    	$data['data'] = User::where('id',$id)->where('status','!=','D')->first();
    	return view('admin.modules.commission.edit_commission',$data);
    }

    public function update_indi_com(Request $request)
    {
        $data = User::where('id',$request->user_id)->first();
    	if ($data->comission_percentage==null && $request->comission_percentage==null) {
            return redirect()->back()->with('success','No changes updated');
        }
    	$updated = User::where('id',$request->user_id)->update([
    		'comission_percentage'=>$request->comission_percentage,
    	]);
    	return redirect()->back()->with('success','Commission updated successfully');
    }
}
