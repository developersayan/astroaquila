<?php

namespace App\Http\Controllers\Admin\Modules\DataBank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Profession;
use App\Models\Famous;
use App\Models\Databank;
use Storage;
class DataBankController extends Controller
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
        $data['profession'] = Profession::get();
        $data['famous'] = Famous::get();
        $data['data'] = Databank::orderBy('id','desc');
        if (@$request->profession_id) {
           $data['data'] = $data['data']->where('profession_id',$request->profession_id);
        }
        if (@$request->famous_id) {
           $data['data'] = $data['data']->where('famous_id',$request->famous_id);
        }
        if (@$request->name) {
           $data['data'] = $data['data']->where('name','LIKE','%'.request('name').'%');
        }
        $data['data'] = $data['data']->paginate(10);
        return view('admin.modules.data_bank.manage_data_bank',$data);
    }


    public function addView()
    {
    	$data = [];
    	$data['country'] = Country::get();
    	$data['profession'] = Profession::get();
    	$data['famous'] = Famous::get();
    	return view('admin.modules.data_bank.add',$data);
    }


    public function add(Request $request)
    {
        // return $request;    
        $ins = [];
        $ins['name'] = $request->name;
        $ins['dob'] = date('Y-m-d',strtotime($request->dob));
        $ins['place_of_birth'] = $request->place_of_birth;
        $ins['country_id'] = $request->country;
        $ins['state_id'] = $request->state;
        $ins['city_id'] = $request->city;
        $ins['description'] = $request->description;
        if (@$request->profession) {
            $profession = Profession::create([ 'name' =>@$request->profession]);
            $ins['profession_id'] = $profession->id;
        }else{
            $ins['profession_id'] = $request->profession_id;
        }
        if (@$request->famous) {
            $famous = Famous::create([ 'name' =>@$request->famous]);
            $ins['famous_id'] = $famous->id;
        }else{
            $ins['famous_id'] = $request->famous_id;
        }

       if ($request->profile_picture) {
           $destinationPath = "storage/app/public/dataBank/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }

        if ($request->file_upload) {
            @$file_upload = @$request->file_upload;
            $filename = time() . '-' . rand(1000, 9999) . '.' . @$file_upload->getClientOriginalExtension();
            Storage::putFileAs('public/data_bank_attachment/', $file_upload, $filename);
            $ins['file_upload']=@$filename;
        }

        $create = Databank::create($ins);
        $update = Databank::where('id',$create->id)->update([
            'slug'=> str_slug($request->name).'-'.$create->id,
        ]);
        return redirect()->back()->with('success','Data Inserted Successfully');
    


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

    public function getCity(Request $request)
    {
        $data = City::where('state_id',$request->id)->get();
        $response=array();
        $result="<option value=''>Select City</option>";
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
        $response['city']=$result;
        return response()->json($response);
    }

    public function delete($id)
    {
        $delete = Databank::where('id',$id)->delete();
        return redirect()->back()->with('success','Data Deleted Successfully');
    }

    public function edit($id)
    {
        $data = [];
        $data['data'] = Databank::where('id',$id)->first();
        $data['country'] = Country::get();
        $data['state'] = State::where('country_id',$data['data']->country_id)->get();
        $data['city'] = City::where('state_id',$data['data']->state_id)->get();
        $data['profession'] = Profession::get();
        $data['famous'] = Famous::get();
        return view('admin.modules.data_bank.edit',$data);
    }

    public function download($file)
    {
        $file_path = @storage_path() . "/app/public/data_bank_attachment/".$file;
        return response()->download( $file_path);
    }

    public function update(Request $request)
    {
        $data = Databank::where('id',$request->id)->first();
        $upd = [];
        $upd['name'] = $request->name;
        $upd['dob'] = date('Y-m-d',strtotime($request->dob));
        $upd['place_of_birth'] = $request->place_of_birth;
        $upd['country_id'] = $request->country;
        $upd['state_id'] = $request->state;
        $upd['city_id'] = $request->city;
        $upd['slug']= str_slug($request->name).'-'.$request->id;
        $upd['description'] = $request->description;
        if (@$request->profession) {
            $profession = Profession::create([ 'name' =>@$request->profession]);
            $upd['profession_id'] = $profession->id;
        }else{
            $upd['profession_id'] = $request->profession_id;
        }
        if (@$request->famous) {
            $famous = Famous::create([ 'name' =>@$request->famous]);
            $upd['famous_id'] = $famous->id;
        }else{
            $upd['famous_id'] = $request->famous_id;
        }

       if ($request->profile_picture) {
            @unlink(storage_path('app/public/dataBank/' . $data->image));
            @unlink(storage_path('app/public/dataBank/' . $data->image));
           $destinationPath = "storage/app/public/dataBank/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
        }

        if ($request->file_upload) {
            @unlink(storage_path('app/public/data_bank_attachment/' . $data->file_upload));
            @$file_upload = @$request->file_upload;
            $filename = time() . '-' . rand(1000, 9999) . '.' . @$file_upload->getClientOriginalExtension();
            Storage::putFileAs('public/data_bank_attachment/', $file_upload, $filename);
            $upd['file_upload']=@$filename;
        }
        Databank::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Data Updated Successfully');

    }

    public function famous(Request $request)
    {
        $check = Famous::where('name',$request->famous)->first();
              if (!empty($check)) {
                   echo "false";
              }else{
                   echo "true";
        }
    }

    public function profession(Request $request)
    {
      $check = Profession::where('name',$request->profession)->first();
              if (!empty($check)) {
                   echo "false";
              }else{
                   echo "true";
        }  
    }

    public function deletePdf(Request $request)
    {
        $data = Databank::where('id',$request->id)->first();
        @unlink(storage_path('app/public/data_bank_attachment/' . $data->file_upload));
        Databank::where('id',$request->id)->update(['file_upload'=>'']);
        echo "success";
    }

    public function deleteImage(Request $request)
    {
        $data = Databank::where('id',$request->id)->first();
        @unlink(storage_path('app/public/dataBank/' . $data->image));
        Databank::where('id',$request->id)->update(['image'=>'']);
        echo "success";
    }



}
