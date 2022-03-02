<?php

namespace App\Http\Controllers\Admin\Modules\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\User;
use App\Models\State;
use App\Models\Databank;
use Excel;
use DB;
class CityController extends Controller
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
        $data['city'] = City::orderBy('country_id');

        if (@$request->country) {
           $data['city'] = $data['city']->where('country_id',@$request->country);
           $data['state'] = State::where('country_id',@$request->country)->get();
        }
        if (@$request->state) {
            $data['city'] = $data['city']->where('state_id',@$request->state);
        }
        if (@$request->name) {
            $data['city'] = $data['city']->where('name',@$request->name);
        }
        $data['city'] = $data['city']->paginate(10);
        $data['countris'] = Country::get();
        return view('admin.modules.city.manage_city',$data);
    }

    public function addView()
    {
        $data = [];
        $data['countris'] = Country::get();
        $data['state'] = State::get();
        return view('admin.modules.city.add_city',$data);
    }


    public function getState(Request $request)
    {
        $data = State::where('country_id',$request->id)->get();
        $response=array();
        $result="<option value=''>Select State</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request->id==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->name."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->name."</option>";
                }
                
            }
        }
        $response['state']=$result;
        return response()->json($response);
    }

    public function checkState(Request $request)
    {
        if (@$request->id){
            $check = City::where('name',$request->city)->where('state_id',$request->state)->where('id','!=',$request->id)->first();
            if ($check!="") {
            echo "found";
            }
        }else{
            $check = City::where('name',$request->city)->where('state_id',$request->state)->first();
            if ($check!="") {
                echo "found";
            }
           
        }
    }


    public function add(Request $request)
    {
        $city = new City;
        $city->state_id = $request->state; 
        $city->country_id = $request->country; 
        $city->name = $request->city; 
        $city->save();
        return redirect()->back()->with('success','City Added Successfully');
    }


    public function editView($id)
    {
        $data = [];
        $data['data'] = City::where('id',$id)->first();
        $data['countris'] = Country::get();
        $data['state'] = State::where('country_id',$data['data']->country_id)->get();
        return view('admin.modules.city.edit_city',$data);
    }

    public function update(Request $request)
    {
        $update = City::where('id',$request->id)->update(['name'=>$request->city,'state_id'=>$request->state,'country_id'=> $request->country]);
        return redirect()->back()->with('success','City Updated Successfully');
    }

    public function excelUpload()
    {
        $data['countris'] = Country::get();
        return view('admin.modules.city.excel_upload',$data);
    }

    public function export(Request $request)
    {
        $insert = [];
        $count =0;

        $b = [];

        $titles = City::where('state_id',$request->state)->get();
        foreach ($titles as $key => $value) {
            array_push($b, $value->name);
        }
        $path = $request->file('excel')->getRealPath();

        $data = Excel::load($path, function($reader) {
            })->get();
        // return $data;

            
                foreach ($data->toArray() as $key => $value) {
                    foreach ($value as $row) {
                        if(@$row['city']){
                        
                        if (@$row['city']=='') {
                            $count = $count + 1;
                        }
                        elseif (in_array(@$row['city'], $b)){
                            $count = $count + 1;
                        }else{
                            $insert[] = ['name' => @$row['city'],'country_id'=>$request->country,'state_id'=>$request->state];
                        // Add new title to array
                         $titles[] = @$row['city'];
                     }
                    }else{
                        $count = $count + 1;
                    }
                }
              }
                if(!empty($insert)){
                    DB::table('city')->insert($insert);
                }
                $failed = $count;
                $success = count($insert);
                return redirect()->back()->with('success',@$success.' record added successfully and '. @$failed. " failed");
                     
               //  if(!empty($insert)){
               //   
               // return redirect()->back()->with('success','Data Inserted Successfully');
               // }else{
               //  return redirect()->back()->with('error','Data Already Added');
               // } 
    }


    public function delete($id)
    {
        $check2 = User::where('city',$id)->where('status','!=','D')->first();
        if ($check2!="") {
            return redirect()->back()->with('error','City can not be  deleted as it is associated with user');
        }
        $check3 = Databank::where('city_id',$id)->first();
        if (@$check3!="") {
            return redirect()->back()->with('error','City can not be  deleted as it is associated with data bank');
        }
        $delete = City::where('id',$id)->delete();
        return redirect()->back()->with('success','City Deleted Successfully');
    }




}
