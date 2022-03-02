<?php

namespace App\Http\Controllers\Admin\Modules\Planets;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planets;
use App\Models\ProductToplanet;
use App\Models\PujaToPlanet;
use App\Models\Products;
use DB;

class PlanetController extends Controller
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
    	$data['planets'] = Planets::orderBy('id','desc');
    	if (@$request->name) {
    		$data['planets'] = $data['planets']->where('planet_name','LIKE','%'.request('name').'%');
    	}
    	$data['planets'] = $data['planets']->paginate(10);
       
    	return view('admin.modules.planets.manage_planet',$data);
    }

    public function addView()
    {
    	return view('admin.modules.planets.add_planet');
    }


    public function addPlanet(Request $request)
    {
    	$planets = new Planets;
    	$check = Planets::where(DB::raw('LOWER(planet_name)'),strtolower($request->planet))->first();
    	if ($check!="") {
    		return redirect()->back()->with('error','Planet Name Already Exists');
    	}
    	$planets->planet_name = $request->planet;
    	$planets->save();
    	return redirect()->back()->with('success','Planet Added Successfully');
    }

    public function checkPlanet(Request $request)
    {
    	 if (@$request->id) {
	      $check = Planets::where('planet_name',$request->planet)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = Planets::where('planet_name',$request->planet)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function editView($id)
    {
    	$data = Planets::where('id',$id)->first();
    	if ($data==null) {
    		return redirect()->back();
    	}
    	return view('admin.modules.planets.edit_planet',compact('data'));
    }

    public function updatePlanet(Request $request)
    {
    	$upd = [];
    	$upd['planet_name'] = $request->planet;
    	$update = Planets::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','planet Updated Successfully');
    }

    public function deletPlanet($id)
    {
    	$data = Planets::where('id',$id)->first();
    	if ($data==null) {
    		return redirect()->back();
    	}

        $check = Products::where('status','!=','D')->pluck('id')->toArray();
		//dd($check);
	   $getdata = ProductToplanet::whereIn('product_id',$check)->where('planet_id',$id)->first();
	   if(@$getdata) {
		return redirect()->back()->with('error','Planet Can Not Be Deleted As It Is Associated With Products');
	  }
      $check2 = PujaToPlanet::where('planet_id',$id)->first();
      if ($check2!="") {
         return redirect()->back()->with('error','Planet Can Not Be Deleted As It Is Associated With Puja');
      }
        
    	$delete = Planets::where('id',$id)->delete();
    	return redirect()->back()->with('success','Planet Deleted Successfully');
    }
}
