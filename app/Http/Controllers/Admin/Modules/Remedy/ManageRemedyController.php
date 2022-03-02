<?php

namespace App\Http\Controllers\Admin\Modules\Remedy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\Remedy;
class ManageRemedyController extends Controller
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
        $data['experties'] = Expertise::get();
        $data['remedies'] = Remedy::where('status','!=','D')->orderBy('id','desc');
        if (@$request->expertise) {
            $data['remedies'] = $data['remedies']->where('type_id',@$request->expertise);
        }
        if (@$request->remedy) {
            $data['remedies'] = $data['remedies']->where('remedies_name','LIKE','%'.request('remedy').'%');
        }
        $data['remedies'] = $data['remedies']->orderBy('id','desc')->paginate(10);
        return view('admin.modules.remedy.manage_remedy',$data);
    }
    public function addView(Request $request)
    {
    	$data = [];
    	$data['experties'] = Expertise::get();
    	return view('admin.modules.remedy.add_remedy',$data);
    }

    public function remedyadd(Request $request)
    {
    	$request->validate([
    		'name'=>'required',
    		'type'=>'required',
    		'price'=>'required',
    		'description'=>'required',
    	]);
    	$remedy = new Remedy;
    	$remedy->remedies_name = $request->name;
    	$remedy->type_id = $request->type;
    	$remedy->price = $request->price;
    	$remedy->description = $request->description;
    	$remedy->save();
    	return redirect()->back()->with('success','Remedy added successfully');

    }

    public function checkremedy(Request $request)
    {
        if (@$request->id) {
            $checkproduct = Remedy::where('remedies_name',$request->remedy_name)->where('type_id',$request->type_id)->where('id','!=',$request->id)->where('status','!=','D')->first();
            if ($checkproduct!="") {
                echo "found";
            }else{
                echo "not found";
            }
        }else{
    	 $checkremedy = Remedy::where('remedies_name',$request->remedy_name)->where('type_id',$request->type_id)->where('status','!=','D')->first();
        
        if ($checkremedy!="") {
            echo "found";
        }else{
            echo "not found";
        }
      }
    }


    public function delete($id)
    {
      $check = Remedy::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
       }
       $delete = Remedy::where('id',$id)->delete();
       return redirect()->back()->with('success','Puja deleted successfully');
    }


    public function editview($id)
    {
        $check = Remedy::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
       }
       $data = [];
       $data['experties'] = Expertise::get();
       $data['data'] = Remedy::where('id',$id)->first();
       return view('admin.modules.remedy.edit_remedy',$data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'price'=>'required',
            'description'=>'required',
        ]);
        $update = Remedy::where('id',$request->id)->update([
            'remedies_name'=>$request->name,
            'type_id'=>$request->type,
            'price'=>$request->price,
            'description'=>$request->description,
        ]);
        return redirect()->back()->with('success','Remedy updated successfully');
    }



}
