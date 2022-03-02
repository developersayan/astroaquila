<?php

namespace App\Http\Controllers\Admin\Modules\Postcode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postcode;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Area;
use App\User;
use Excel;
use DB;
class PostcodeManagement extends Controller
{
    /**
     *   Method      : managePostCode
     *   Description : To manage post code
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

     public function managePostCode(Request $request)
     {
        $data['postcodes'] = Postcode::with(['getCountry','getState','getCity']);
        if($request->all()){
            if(@$request->country){
                $data['postcodes'] = $data['postcodes']->where('country_id',$request->country);
                $data['states']  = State::where('country_id',@$request->country)->get();
            }
            if(@$request->state){
                $data['postcodes'] = $data['postcodes']->where('state_id',$request->state);
                $data['cities']  = City::where('state_id',@$request->state)->get();
            }
            if(@$request->city){
                $data['postcodes'] = $data['postcodes']->where('city_id',$request->city);
            }
            if(@$request->postcode){
                $data['postcodes'] = $data['postcodes']->where('postcode','like','%'.$request->city.'%');
            }

        }
        $data['postcodes'] =$data['postcodes']->orderBy('id','desc')->paginate(10);
        $data['countries'] = Country::get();

        return view('admin.modules.postcode.manage_postcode',$data);
     }

     /**
     *   Method      : addPostCode
     *   Description : To add /edit post code
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function addPostCode(Request $request,$id=null)
    {
        if($id){
            $data['details'] = Postcode::where('id',$id)->first();
            $data['states']  = State::where('country_id',$data['details']->country_id)->get();
            $data['cities']  = City::where('state_id',$data['details']->state_id)->get();
        }
        $data['countries'] = Country::get();
        return view('admin.modules.postcode.edit_postcode',$data);
    }

    /**
     *   Method      : updatePostCode
     *   Description : To insert / update post code
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function updatePostCode(Request $request)
    {
        $request->validate([
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'puja_available' => 'required',
            'postcode' => 'required',
            'service_available' => 'required',
        ]);
        $insPost['country_id'] = $request->country;
        $insPost['state_id'] = $request->state;
        $insPost['city_id'] = $request->city;
        $insPost['postcode'] = $request->postcode;
        $insPost['puja_available'] = $request->puja_available;
        $insPost['service_available'] = $request->service_available;

        if($request->id){
            Postcode::where('id',$request->id)->update($insPost);
            return redirect()->back()->with('success','Postcode updated successfully.');
        }else{
            Postcode::create($insPost);
            return redirect()->back()->with('success','Postcode added successfully.');
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
        $check = Postcode::where('country_id',$request->country_id)
                        ->where('postcode',$request->postcode);

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
     *   Method      : deletePostCode
     *   Description : To delete post code
     *   Author      : Argha
     *   Date        : 2021-DEC-22
     **/

    public function deletePostCode($id)
    {
        $postcode = Postcode::where('id',$id)->first();

        $check = User::where('pincode',$postcode->postcode)->where('status','!=','D')->first();
        if ($check!="") {
            return redirect()->back()->with('error','Postcode can not be  deleted as it is associated with user');
        }
        $delete = Postcode::where('id',$id)->delete();
        return redirect()->back()->with('success','Postcode Deleted Successfully');
    }

    public function exportPostcode(Request $request)
    {
        $insert = [];
        $b = [];

        $titles = City::where('state_id',$request->state)->get();
        foreach ($titles as $key => $value) {
            array_push($b, $value->name);
        }
        $path = $request->file('excel')->getRealPath();

        $data = Excel::load($path, function($reader) {
            })->get();
        // return $data;

                $count = 0;
                foreach ($data->toArray() as $key => $value) {
                    foreach ($value as $row) {
                        if(@$row['postcode'] != ''){
                            $postcode = (string)@$row['postcode'];

                            $check = Postcode::where('country_id',$request->country)
                                                ->where('postcode',$postcode)
                                                ->first();
                            $insPost['country_id'] = $request->country;
                            $insPost['state_id'] = $request->state;
                            $insPost['city_id'] = $request->city;
                            $insPost['postcode'] = $postcode;
                            $insPost['puja_available'] = @$row['puja_available'] ? @$row['puja_available'] :'N';
                            $insPost['service_available'] = @$row['service_available']? @$row['service_available'] :'N';
                            if($check){
                                $count = $count + 1;
                            }else{
                                $post = Postcode::create($insPost);
                                $area = '';
                                if(@$row['area']){
                                    $area = trim(strtolower(@$row['area']));
                                }
                                $checkArea = Area::where('state_id',$request->state)
                                                ->where('city_id',$request->city)
                                                ->where('postcode_id',@$post->id)
                                                ->where(DB::raw('trim(lower(area))'),$area)
                                                ->first();
                                if(!$checkArea){
                                    $insArea['country_id'] = $request->country;
                                    $insArea['state_id'] = $request->state;
                                    $insArea['city_id'] = $request->city;
                                    $insArea['postcode_id'] = @$post->id;
                                    $insArea['area'] = $area;

                                    Area::create($insArea);
                                }
                            }
                        }else{
                            $count = $count + 1;
                        }


                    }
                }
                $failed = $count;
                $success = count($data->toArray()) - $failed;
                return redirect()->back()->with('success',@$success.' record added successfully and '. @$failed. " failed");
    }
}
