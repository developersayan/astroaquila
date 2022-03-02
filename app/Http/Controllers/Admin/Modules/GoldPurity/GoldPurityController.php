<?php

namespace App\Http\Controllers\Admin\Modules\GoldPurity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoldPurity;
class GoldPurityController extends Controller
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
   /**
     *   Method      : index
     *   Description : show gold purity
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function index()
    {
    	$data = [];
    	$data['gold'] = GoldPurity::get();
    	return view('admin.modules.goldPurity.manage_gold_purity',$data);
    }

   /**
     *   Method      : editView
     *   Description : edit gold purity
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function editView($id)
    {
    	$data = [];
        $data['data'] = GoldPurity::where('id',$id)->first();
        return view('admin.modules.goldPurity.edit_gold_purity',$data);
    }

    /**
     *   Method      : update
     *   Description : update gold purity
     *   Author      : Sayan
     *   Date        : 2021-SEPT-20
    **/

    public function update(Request $request)
    {
        $upd = [];
        $upd['ring_weight_carat'] = $request->ring_weight_carat;
        $upd['ring_price_inr'] = $request->ring_price_inr;
        $upd['ring_price_usd'] = $request->ring_price_usd;
        $upd['pendent_weight_carat'] = $request->pendent_weight_carat;
        $upd['pendent_price_inr'] = $request->pendent_price_inr;
        $upd['pendent_price_usd'] = $request->pendent_price_usd;
        $upd['pendent_chain_price_inr'] = $request->pendent_chain_price_inr;
        $upd['pendent_chain_price_usd'] = $request->pendent_chain_price_usd;
        $upd['bracalet_weight_carat'] = $request->bracalet_weight_carat;
        $upd['bracelet_price_inr'] = $request->bracelet_price_inr;
        $upd['bracelet_price_usd'] = $request->bracelet_price_usd;
        $update = GoldPurity::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Gold Purity Updated Successfully');
    }
}
