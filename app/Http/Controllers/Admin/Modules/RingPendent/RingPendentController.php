<?php

namespace App\Http\Controllers\Admin\Modules\RingPendent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RingPendent;
class RingPendentController extends Controller
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


   /**
     *   Method      : index
     *   Description : show manage ring pendent price
     *   Author      : Sayan
     *   Date        : 2021-SEPT-20
    **/

   public function index(Request$request)
   {
   	 $data = [];
   	 $data['rings'] = RingPendent::orderBy('id','desc');
     if (@$request->type_id) {
       $data['rings'] = $data['rings']->where('type',$request->type_id);
     }
     if (@$request->metal_type_id) {
       $data['rings'] = $data['rings']->where('metal_type',$request->metal_type_id);
     }
     if (@$request->metal_type_id) {
       $data['rings'] = $data['rings']->where('metal_type',$request->metal_type_id);
     }
     if (@$request->weight) {
       $data['rings'] = $data['rings']->where('weight','LIKE','%'.$request->weight.'%');
     }
     $data['rings'] = $data['rings']->paginate(10);
   	 return view('admin.modules.ring_pendent.manage_ring_pendent',$data);
   }

   /**
     *   Method      : edit
     *   Description : edit ring pendent price
     *   Author      : Sayan
     *   Date        : 2021-SEPT-20
    **/

    public function edit($id)
    {
    	$data = [];
    	$data['data'] = RingPendent::where('id',$id)->first();
    	return view('admin.modules.ring_pendent.edit_ring_pendent',$data);
    }

   /**
     *   Method      : update
     *   Description : update ring pendent price
     *   Author      : Sayan
     *   Date        : 2021-SEPT-20
    **/

   public function update(Request $request)
   {
   	 $upd = [];
     $upd['metal_type'] = $request->metal_type_id;
     $upd['type'] = $request->type_id;
   	 $upd['price_inr'] = $request->price_inr;
   	 $upd['price_usd'] = $request->price_usd;
     $upd['weight'] = $request->weight;
   	 if (@$request->with_chain_price_inr  && $request->type_id=="P") {
   	 	$upd['with_chain_price_inr'] = $request->with_chain_price_inr;
   	 }else{
   	 	$upd['with_chain_price_inr'] = 0;
   	 }
   	 if (@$request->with_chain_price_usd  && $request->type_id=="P") {
   	 	$upd['with_chain_price_usd'] = $request->with_chain_price_usd;
   	 }else{
   	 	$upd['with_chain_price_usd'] = 0;
   	 }

   	 $update = RingPendent::where('id',$request->id)->update($upd);
   	 return redirect()->back()->with('success','Price Updated Successfully');
   }



   public function addView()
   {
    return view('admin.modules.ring_pendent.add_ring_pendent');
   }

   public function add(Request $request)
   {
      $ringpendent = new RingPendent;
      $ringpendent->metal_type = $request->metal_type_id;
      $ringpendent->type = $request->type_id;
      $ringpendent->price_inr = $request->price_inr;
      $ringpendent->price_usd = $request->price_usd;
      $ringpendent->weight = $request->weight;
      if (@$request->with_chain_price_inr && $request->type_id=="P") {
      $ringpendent->with_chain_price_inr = $request->with_chain_price_inr;
     }else{
      $ringpendent->with_chain_price_inr = 0;
     }
     if (@$request->with_chain_price_usd && $request->type_id=="P") {
      $ringpendent->with_chain_price_usd = $request->with_chain_price_usd;
     }else{
       $ringpendent->with_chain_price_usd = 0;
     }
     $ringpendent->save();
     return redirect()->back()->with('success','Data Inserted Successfully');
   

   }


   public function check(Request $request)
   {
      if (@$request->id) {
      $check = RingPendent::where('metal_type',$request->metal_type)->where('type',$request->type)->where('weight',$request->weight)->where('id','!=',$request->id)->first();
      if (!empty($check)) {
           echo "found";
      }else{
           echo "not found";
      }
          
      }else{
         $check = RingPendent::where('metal_type',$request->metal_type)->where('type',$request->type)->where('weight',$request->weight)->first();
          if (!empty($check)) {
               echo "found";
          }else{
               echo "not found";
          }
      }
   }


   public function delete($id)
   {
     $check = RingPendent::where('id',$id)->first();
     if (@$check==null) {
       return redirect()->back();
     }
     $delete = RingPendent::where('id',$id)->delete();
     return redirect()->back()->with('success','Data Deleted Successfully');
   
   }





}
