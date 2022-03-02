<?php

namespace App\Http\Controllers\Admin\Modules\Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\ZipMaster;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\CustomerAddressBook;
use App\Models\OrderMaster;
use App\User;
use DB;
class AreaController extends Controller
{
    /**
     *   Method      : index
     *   Description : To manage index
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
    public function index(Request $request)
    {
    	$data = [];
    	$data['areas'] = Area::orderBy('country_id');
        $data['countries'] = Country::get();
        $data['states']  = State::get();
        $data['cities']  = City::get();
    	if (@$request->name) {
    		$data['areas'] = $data['areas']->where('area','LIKE','%'.@$request->name.'%');
    	}
        if (@$request->postcode) {
    		$data['areas'] = $data['areas']->where('postcode_id',@$request->postcode);
    	}
        if (@$request->country) {
           $data['areas'] = $data['areas']->where('country_id',@$request->country);
        }
        if(@$request->state){
            $data['areas'] = $data['areas']->where('state_id',$request->state);
        }
        if(@$request->city){
            $data['areas'] = $data['areas']->where('city_id',$request->city);
        }
    	$data['areas'] = $data['areas']->paginate(10);
    	return view('admin.modules.area.manage_area',$data);
    }

    /**
     *   Method      : addView
     *   Description : To add new area
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
    public function addView()
    {
        $data = [];
        $data['countries'] = Country::get();
        //$data['states'] = State::get();
    	return view('admin.modules.area.add_area',$data);
    }
    /**
     *   Method      : addArea
     *   Description : To insert new area
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
    public function addArea(Request $request)
    {
    	$request->validate([
    		'area'=>'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postcode' => 'required',
    	]);
    	$addArea['country_id'] = $request->country;
        $addArea['state_id'] = $request->state;
        $addArea['city_id'] = $request->city;
        $addArea['postcode_id'] = $request->postcode;
        $addArea['area'] = $request->area;
        Area::create($addArea);
    	return redirect()->back()->with('success','Area Added Successfully');

    }


    /**
     *   Method      : editView
     *   Description : To edit area
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
     public function editView($id)
     {
        $data = [];
     	$data['data'] = Area::where('id',$id)->first();
        $data['states']  = State::where('country_id',$data['data']->country_id)->get();
        $data['cities']  = City::where('state_id',$data['data']->state_id)->get();
        $data['postcodes']  = ZipMaster::where('state_id',$data['data']->state_id)
                                        ->where('city_id',$data['data']->city_id)
                                        ->get();
        $data['countries'] = Country::get();
     	if (@$data==null) {
     		return redirect()->back();
     	}
     	return view('admin.modules.area.edit_area',$data);
     }

     /**
     *   Method      : editArea
     *   Description : To update  area
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
     public function editArea(Request $request)
     {
     	$request->validate([
    		'area'=>'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postcode' => 'required',
    	]);
        $upArea['country_id'] = $request->country;
        $upArea['state_id'] = $request->state;
        $upArea['city_id'] = $request->city;
        $upArea['postcode_id'] = $request->postcode;
        $upArea['area'] = $request->area;

    	$update = Area::where('id',$request->id)->update($upArea);
    	return redirect()->back()->with('success','Zipcode Updated Successfully');
     }

     /**
     *   Method      : deleteArea
     *   Description : To delete area
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
     public function deleteArea($id)
     {
     	$data = Area::where('id',$id)->first();
     	if (@$data==null) {
     		return redirect()->back();
     	}
        $checkOrder = OrderMaster::where('shipping_area',$data->area)->orWhere('billing_area',$data->area)->first();
        $checkUser = User::where('area',$data->area)->first();
        $checkAddress = CustomerAddressBook::where('area',$data->area)->first();
        if (@$checkOrder!="" || $checkUser != '' || $checkAddress!= '') {
            return redirect()->back()->with('error','Area can not be deleted as it is associated with customer or order');
        }
     	$delete = Area::where('id',$id)->delete();
     	return redirect()->back()->with('success','Area Deleted Successfully');
     }
     /**
     *   Method      : checkDuplicateArea
     *   Description : To check duplicate area
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
     public function checkDuplicateArea(Request $request)
     {
        //return $request;
        $area = trim(strtolower($request->area));
        $check = Area::where('state_id',$request->state)
                     ->where('city_id',$request->city)
                     ->where('postcode_id',$request->postcode)
                     ->where(DB::raw('trim(lower(area))'),$area);
                     //->where('area',$request->area);

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
     *   Method      : getState
     *   Description : To get state on country
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function getState(Request $request)
    {
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
     *   Method      : getPostcode
     *   Description : To get postcode
     *   Author      : Argha
     *   Date        : 2021-DEC-23
     **/
    public function getPostcode(Request $request)
    {
        $data = ZipMaster::where('state_id',$request['params']['state'])
                         ->where('city_id',$request['params']['city'])
                         ->get();
        $response=array();
        $result="<option value=''>Select Postcode</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request['params']['id']==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->zipcode."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->zipcode."</option>";
                }

            }
        }
        $response['postcode']=$result;
        return response()->json($response);
    }
}
