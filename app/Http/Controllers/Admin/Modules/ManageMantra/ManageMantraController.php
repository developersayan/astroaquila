<?php

namespace App\Http\Controllers\Admin\Modules\ManageMantra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mantra;
use App\Models\MantraPrice;
use App\Models\OrderPujaMantra;
class ManageMantraController extends Controller
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
		$data['mantra']=Mantra::orderBy('id','desc');
		if(@$request->all())
		{
			if (@$request->mantra) {
				$data['mantra'] = $data['mantra']->where('mantra','LIKE','%'.request('mantra').'%');
			}
		}
		$data['mantra']=$data['mantra']->paginate(10);
    	return view('admin.modules.mantra.manage_mantra',$data);
    }

    public function addView()
    {
    	return view('admin.modules.mantra.add_mantra');
    }

    public function add(Request $request)
    {
		//dd($request->all());
        // return $request;
    	$mantra = new Mantra;
    	$mantra->mantra = $request->mantra;
    	$mantra->save();
    	$mantraId = $mantra->id;
		for($i=0;$i<count(@$request->recital);$i++)
		{
			MantraPrice::create([
              'mantra_master_id' =>$mantraId,
              'no_of_recitals' => @$request->recital[$i],
              'price_in_inr' => @$request->price_inr[$i],
              'price_in_usd' =>  @$request->price_usd[$i], 
          ]);
		}
        return redirect()->back()->with('success','Mantra Added Successfully'); 
    }
	public function editView($id)
    {
    	$data['mantra'] = Mantra::where('id',$id)->first();
    	$data['mantra_price'] = MantraPrice::where('mantra_master_id',$id)->get();
    	if ($data==null) {
    		return redirect()->back();
    	}
    	return view('admin.modules.mantra.edit_mantra',$data);
    }

    public function updateMantra(Request $request)
    {
    	//dd($request->all());
        // return $request;
    	Mantra::where('id',$request->mantra_id)->update(['mantra'=>@$request->mantra]);
		MantraPrice::where('mantra_master_id',$request->mantra_id)->delete();
		for($i=0;$i<count(@$request->recital);$i++)
		{
			if(@$request->recital[$i] && @$request->price_inr[$i] && @$request->price_usd[$i])
			{
				MantraPrice::create([
				  'mantra_master_id' =>$request->mantra_id,
				  'no_of_recitals' => @$request->recital[$i],
				  'price_in_inr' => @$request->price_inr[$i],
				  'price_in_usd' =>  @$request->price_usd[$i], 
			  ]);
			}			
		}
        return redirect()->back()->with('success','Mantra Updated Successfully'); 
    }

    public function deletMantra($id)
    {
    	$data = Mantra::where('id',$id)->first();
    	if ($data==null) {
    		return redirect()->back();
    	}
        $details=OrderPujaMantra::where('mantra_id',$id)->first();
		if(@$details)
		{
			return redirect()->back()->with('error','Mantra is associated with an order, can not be deleted.');
		}
    	$delete = Mantra::where('id',$id)->delete();
    	$delete = MantraPrice::where('mantra_master_id',$id)->delete();
    	return redirect()->back()->with('success','Mantra Deleted Successfully');
    }
	public function deletMantraPrice($id)
    {
        // return $id;
    	$data = MantraPrice::where('id',$id)->first();
    	if ($data==null) {
    		return redirect()->back();
    	}
		$one_left=MantraPrice::where('mantra_master_id',$data->mantra_master_id)->count();
		if($one_left<2)
		{
			return redirect()->back()->with('success','Mantra should at least have one price');
		}
    	$delete = MantraPrice::where('id',$id)->delete();
    	return redirect()->back()->with('success','Mantra Deleted Successfully');
    }
}
