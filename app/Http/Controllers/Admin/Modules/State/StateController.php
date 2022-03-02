<?php

namespace App\Http\Controllers\Admin\Modules\State;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use App\User;
class StateController extends Controller
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
    public function index(Request $request)
    {
    	$data = [];
    	$data['states'] = State::with('countrylist');
    	$data['countris'] = Country::get();
    	if (@$request->country) {
    		$data['states'] = $data['states']->where('country_id',@$request->country);
    	}
    	if (@$request->name) {
    		$data['states'] = $data['states']->where('states.name','LIKE','%'.request('name').'%');
    	}
    	
        $data['states'] = $data['states']->select('states.*')
        // ->join('countries', 'countries.id', '=', 'states.country_id')
        ->orderBy('country_id')->paginate(10);
       

       
    	return view('admin.modules.state.state',$data);
    }

    public function delete($id)
    {
    	$check = State::where('id',$id)->first();
    	if ($check=='') {
    	   return redirect()->back()->with('error','State not found');
    	}
        $check2 = User::where('state',$id)->where('status','!=','D')->first();
        if ($check2!="") {
            return redirect()->back()->with('error','State can not be  deleted as it is associated with user');
        }
    	$delete = State::where('id',$id)->delete();
    	return redirect()->back()->with('success','State deleted successfully');
    }

    public function addview(Request $request)
    {
    	$countris = Country::get();
    	return view('admin.modules.state.add_state',compact('countris'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'state' => 'required',
            'country'=>'required',
         ]);
    	$check = State::where('name',$request->state)->where('country_id',$request->country)->first();
    	if ($check!="") {
    		return redirect()->back()->with('error','State already added');
    	}
    	$state = new state;
    	$state->name = $request->state;
    	$state->country_id = $request->country;
    	$state->save();
    	return redirect()->back()->with('success','State added successfully');
    }

    public function edit($id)
    {
    	$check = State::where('id',$id)->first();
    	if ($check=='') {
    	   return redirect()->back()->with('error','State not found');
    	}
    	$countris = Country::get();
    	$data = State::where('id',$id)->first();
    	return view('admin.modules.state.edit_state',compact(['data','countris']));
    }

    public function update(Request $request)
    {
       $request->validate([
            'state' => 'required',
          ]);
        
    	$check = State::where('name',$request->state)->where('country_id',$request->country)->where('id','!=',$request->state_id)->first();
    	if ($check!="") {
    		return redirect()->back()->with('error','State already added');
    	}
    	$update = State::where('id',$request->state_id)->update([
    		'name'=>$request->state,
    	]);
    	return redirect()->back()->with('success','State updated successfully');
    }

    public function checkstate(Request $request)
    {

    	if (@$request->id){
    		$check = State::where('name',$request->state)->where('country_id',$request->country)->where('id','!=',$request->id)->first();
    		if ($check!="") {
    		echo "found";
    	    }
    	}else{
    		$check = State::where('name',$request->state)->where('country_id',$request->country)->first();
    		if ($check!="") {
    			echo "found";
    	    }
    	   
    	}
    	
   }
}
