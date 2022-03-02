<?php

namespace App\Http\Controllers\Admin\Modules\AstroTips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AstroTip;
class AstroTipController extends Controller
{
    /**
     *   Method      : manageAstroTips
     *   Description : manage astrologer tips
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/

    public function manageAstroTips(Request $request)
    {
        $tips = AstroTip::where('astrologer_id',0);
        if($request->all()){
            if($request->keyword){
                $tips = $tips->where('heading','like','%'.$request->keyword.'%');
            }
        }
        $data['tips'] = $tips->orderBy('id','desc')->paginate(10);
        return view('admin.modules.astro_tips.manage_astro_tips')->with($data);
    }

    /**
     *   Method      : editAstroTipls
     *   Description : add /edit astrologer tips
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/
    public function editAstroTips(Request $request,$id=null)
    {
        $data = array();
        if($id){
            $data['tip'] = AstroTip::where('id',$id)->first();
        }
        if($request->all()){
            $arr['heading'] = $request->heading;
            $arr['astrologer_id'] = 0;
            $arr['description'] = $request->description;
            if(@$request->tip_id){
                AstroTip::where('id',$request->tip_id)->update($arr);
                session()->flash('success','Astro tip updated successfully.');
                return redirect()->back();
            }else{
                AstroTip::create($arr);
                session()->flash('success','Astro tip added successfully.');
                return redirect()->back();
            }
        }
        return view('admin.modules.astro_tips.edit_astro_tips')->with($data);
    }
    /**
     *   Method      : deleteAstroTips
     *   Description : delete astrologer tips
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/
    public function deleteAstroTips($id)
    {
        AstroTip::where('id',$id)->delete();
        session()->flash('success','Astro tip deleted successfully.');
        return redirect()->back();
    }
}
