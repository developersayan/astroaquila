<?php

namespace App\Http\Controllers\Modules\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Blog;
use App\Models\Puja;
use App\Models\Products;
use Session;
use App\Models\BannerSettings;
use App\Models\BannerDetails;
class HomeController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('customer.access');
    }
    public function index()
    {
        // return Session::get('cart_session_id');
        $data = [];
        $data['astrologers'] = User::with('astrologerExclusionDateDetails')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('show_at_home','Y')->get();

        
        $data['blogs'] = Blog::where('status','A')->limit('5')->get();
        $data['featured'] = Blog::where('status','A')->where('is_show','Y')->get();
        $data['pujas'] = Puja::where('status','!=','D')->where('show_at_home','Y')->get();
        $data['products'] = Products::where('product_type','AP')->where('status','A')->where('is_show','Y')->limit(10)->get();
        $data['gemstones'] = Products::where('product_type','GS')->where('status','A')->where('is_show','Y')->limit(10)->get();
        $data['banner_setting'] = BannerSettings::where('id',1)->first();
        $data['banner_details'] = BannerDetails::where('image_type','F')->get();
		$data['second_banner_setting'] = BannerSettings::where('id',2)->where('enable_disable','E')->first();
        $data['second_banner_details'] = BannerDetails::where('image_type','S')->get();
        return view('modules.home.home',$data);
    }
}
