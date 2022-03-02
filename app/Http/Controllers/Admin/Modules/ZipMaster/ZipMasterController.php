<?php

namespace App\Http\Controllers\Admin\Modules\ZipMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ZipMaster;
use Excel;
use DB;
use App\Models\PunditToZipcode;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Area;
class ZipMasterController extends Controller
{
    //

    public function index(Request $request)
    {
    	$data = [];
    	$data['zip'] = ZipMaster::orderBy('country_id');
        $data['countries'] = Country::get();
        $data['states']  = State::get();
        $data['cities']  = City::get();
    	if (@$request->name) {
    		$data['zip'] = $data['zip']->where('zipcode','LIKE','%'.request('name').'%');
    	}
        if (@$request->country) {
           $data['zip'] = $data['zip']->where('country_id',@$request->country);

        }
        if(@$request->state){
            $data['zip'] = $data['zip']->where('state_id',$request->state);
        }
        if(@$request->city){
            $data['zip'] = $data['zip']->where('city_id',$request->city);
        }
    	$data['zip'] = $data['zip']->paginate(10);
    	return view('admin.modules.zipmaster.manage_zip',$data);
    }

    public function addView()
    {
        $data = [];
        $data['countries'] = Country::get();
    	return view('admin.modules.zipmaster.add_zip',$data);
    }

    public function addZip(Request $request)
    {
    	$request->validate([
    		'name'=>'required',
            'country'=>'required',
            'state' => 'required',
            'city' => 'required',
            'puja_available' => 'required',
            'service_available' => 'required',
    	]);
    	$zip = new ZipMaster;
    	$zip->zipcode = $request->name;
        $zip->country_id = $request->country;
        $zip->state_id = $request->state;
        $zip->city_id = $request->city;
        $zip->puja_available = $request->puja_available;
        $zip->service_available = $request->service_available;
    	$zip->save();
    	return redirect()->back()->with('success','Zipcode Added Successfully');

    }



     public function editView($id)
     {
        $data = [];
     	$data['data'] = ZipMaster::where('id',$id)->first();
        $data['states']  = State::where('country_id',$data['data']->country_id)->get();
        $data['cities']  = City::where('state_id',$data['data']->state_id)->get();
        $data['countries'] = Country::get();
     	if (@$data==null) {
     		return redirect()->back();
     	}
     	return view('admin.modules.zipmaster.edit_zip',$data);
     }


     public function updateZip(Request $request)
     {
     	$request->validate([
    		'name'=>'required',
            'country'=>'required',
            'state' => 'required',
            'city' => 'required',
            'puja_available' => 'required',
            'service_available' => 'required',
    	]);
        $upPost['country_id'] = $request->country;
        $upPost['state_id'] = $request->state;
        $upPost['city_id'] = $request->city;
        $upPost['zipcode'] = $request->name;
        $upPost['puja_available'] = $request->puja_available;
        $upPost['service_available'] = $request->service_available;

    	$update = ZipMaster::where('id',$request->id)->update($upPost);
    	return redirect()->back()->with('success','Zipcode Updated Successfully');
     }


     public function deleteZip($id)
     {
     	$data = ZipMaster::where('id',$id)->first();
     	if (@$data==null) {
     		return redirect()->back();
     	}
        $check = PunditToZipcode::where('zipcode_id',$id)->first();
        if (@$check!="") {
            return redirect()->back()->with('error','Zipcode Can Not Be Deleted As It Is Associated With Pundit');
        }
     	$delete = ZipMaster::where('id',$id)->delete();
     	return redirect()->back()->with('success','Zipcode Deleted Successfully');
     }

     public function import(Request $request)
     {
        $insert = [];
        $b = [];

        $titles = ZipMaster::where('country_id',$request->country)->get();
        foreach ($titles as $key => $value) {
            array_push($b, $value->zipcode);
        }
        $path = $request->file('excel')->getRealPath();

        $data = Excel::load($path, function($reader) {
            })->get();
         // return $data;


        // foreach ($data->toArray() as $key => $value) {
        //     foreach ($value as $row) {
        //         if (in_array($row['zipcode'], $b))
        //             continue;

        //         $insert[] = ['zipcode' => $row['zipcode'],'country_id'=>$request->country];

        //         // Add new title to array
        //             $titles[] = $row['zipcode'];

        //     }
        // }

        // if(!empty($insert)){
        //     DB::table('zipcode_master')->insert($insert);
        //     return redirect()->back()->with('success','Data Inserted Successfully');
        // }else{
        //      return redirect()->back()->with('error','Data Already Added');
        // }
        $count = 0;
        $total = 0;
        foreach ($data->toArray() as $key => $value) {
            foreach ($value as $row) {
                if(@$row){
                    $total = $total + 1;
                }
                if(@$row['postcode'] != ''){
                    $postcode = (string)@$row['postcode'];
                    $check = ZipMaster::where('country_id',$request->country)
                                        ->where('state_id',$request->state)
                                        ->where('city_id',$request->city)
                                        ->where('zipcode',$postcode)
                                        ->first();
                    //dd($check);
                    $insPost['country_id'] = $request->country;
                    $insPost['state_id'] = $request->state;
                    $insPost['city_id'] = $request->city;
                    $insPost['zipcode'] = $postcode;
                    $insPost['puja_available'] = @$row['puja_available'] ? @$row['puja_available'] :'N';
                    $insPost['service_available'] = @$row['service_available']? @$row['service_available'] :'N';
                    $area = trim(strtolower(@$row['area']));
                    if(!$check){
                        $zip = ZipMaster::create($insPost);
                        if($area != ''){
                            $checkArea = Area::where([
                                'state_id' => $request->state,
                                'city_id' => $request->city,
                                'postcode_id' => @$zip->id,
                            ])
                            ->where(DB::raw('trim(lower(area))'),$area)
                            ->first();
                            if(!$checkArea){
                                $insArea['country_id'] = @$request->country;
                                $insArea['state_id'] = @$request->state;
                                $insArea['city_id'] = @$request->city;
                                $insArea['postcode_id'] = @$zip->id;
                                $insArea['area'] = @$row['area'];
                                Area::create($insArea);
                            }else{
                                $count = $count + 1;
                            }
                        }

                    }else{
                        if($area != ''){
                            $checkArea = Area::where([
                                'state_id' => $request->state,
                                'city_id' => $request->city,
                                'postcode_id' => @$check->id,
                            ])
                            ->where(DB::raw('trim(lower(area))'),$area)
                            ->first();
                            if(!$checkArea){
                                $insArea['country_id'] = @$request->country;
                                $insArea['state_id'] = @$request->state;
                                $insArea['city_id'] = @$request->city;
                                $insArea['postcode_id'] = @$check->id;
                                $insArea['area'] = @$row['area'];
                                Area::create($insArea);
                            }else{
                                $count = $count + 1;
                            }
                        }else{
                            $count = $count + 1;
                        }

                    }
                }else{
                    $count = $count + 1;
                }
            }
        }
        $success = $total - $count;
        return redirect()->back()->with('success',@$success.' record added successfully and '. @$count. " failed");

     }

     public function checkZipcode(Request $request)
     {
         if (@$request->id) {
          $check = ZipMaster::where('zipcode',$request->zip)->where('country_id',$request->country)->where('id','!=',$request->id)->first();
            if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }


          }else{
             $check = ZipMaster::where('zipcode',$request->zip)->where('country_id',$request->country)->first();
             if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }

          }
     }


     /**
     *   Method      : getState
     *   Description : To get state on country
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function getState(Request $request)
    {
        //dd($request->all());
        $data = State::where('country_id',$request['params']['id'])->get();
        $response=array();
        $result="<option value=''>Select State</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request['params']['id']==$rows->id)
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
    /**
     *   Method      : getCity
     *   Description : To get city on state
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function getCity(Request $request)
    {
        $data = City::where('state_id',$request['params']['id'])->get();
        $response=array();
        $result="<option value=''>Select City</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request['params']['id']==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->name."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->name."</option>";
                }

            }
        }
        $response['city']=$result;
        return response()->json($response);
    }
    /**
     *   Method      : checkDuplicatePostcode
     *   Description : To check duplicate postcode country basis
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function checkDuplicatePostcode(Request $request)
    {
        $check = ZipMaster::where('country_id',$request->country_id)
                        ->where('zipcode',$request->name);

        if($request->id){
            $check = $check->where('id','!=',$request->id);
        }
        $check = $check->first();
        if($check){
            return 'false';
        }else{
            return 'true';
        }
    }

    /**
     *   Method      : uploadZipcodeExcel
     *   Description : To upload the zip code
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

     public function uploadZipcodeExcel()
     {
        $data = [];
        $data['countries'] = Country::get();
    	return view('admin.modules.zipmaster.excel_upload',$data);
     }

}
