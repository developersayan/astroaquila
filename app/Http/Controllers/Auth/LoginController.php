<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordEmailVerification;
use App\Models\Cart;
use App\Models\Products;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
    public $data;
    public function __construct()
    {

      $this->middleware(function ($request, $next) {
        if ( \request()->get( 'ref' )) {
           session()->put( 'customurl', \request()->get( 'ref' ));
           $this->data = Session::get('customurl');
        }
        return $next($request);
        });
       $this->middleware('guest')->except('logout');

    }
    /**
     *   Method      : customLogin
     *   Description : custom Login
     *   Author      : Soumojit
     *   Date        : 2021-APR-21
     **/
    public function customLogin(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        /* login using email */
        $userDataEmail=User::where('email',$request->username)->where('status','!=','D')->first();
        if($userDataEmail){
            if (!Hash::check($request->password, $userDataEmail->password)) {
                session()->flash('error', \Lang::get('auth.email_password_wrong'));
                return redirect()->back()->withInput($request->input());
            }
            if($userDataEmail->status=='U'){
                $upd['vcode'] = str_random(60);
                User::where('id', $userDataEmail->id)->update($upd);
                $user=User::where('id', $userDataEmail->id)->first();
                Mail::to($user->email)->send(new EmailVerification($user));
                session()->flash('error', \Lang::get('auth.user_not_verify'));
                return redirect()->back()->withInput($request->input());
            }
            if ($userDataEmail->is_email_verify == 'N') {
                $upd['vcode'] = str_random(60);
                User::where('id', $userDataEmail->id)->update($upd);
                $user = User::where('id', $userDataEmail->id)->first();
                Mail::to($user->email)->send(new EmailVerification($user));
                session()->flash('error', \Lang::get('auth.user_email_not_verify'));
                return redirect()->back()->withInput($request->input());
            }
            if($userDataEmail->status=='I'){
                session()->flash('error', \Lang::get('auth.user_inactive'));
                return redirect()->back()->withInput($request->input());
            }
            Auth::login($userDataEmail);
            session()->flash('success', \Lang::get('auth.login_success'));
			User::where('id',auth()->user()->id)->update(['last_login'=>date('Y-m-d H:i:s')]);
            $cart_id = Session::get('cart_session_id');
                $isAvailable = Cart::where('cart_session_id',$cart_id)->get();
                if($isAvailable->count()>0){
                    foreach($isAvailable as $item){
                        $check=Cart::where('product_id',$item->product_id)->where('user_id',auth()->user()->id)->first();
						$productDetails = Products::where('id',$item->product_id)->first();
                        if(@$check){
                            if(@$check->cart_type=='GS')
							{
								$total_price_inr=0;
								$total_price_usd=0;
								$where=array();
								$where['product_id']=$item->product_id;
								$where['user_id']=auth()->user()->id;
								//$where['gemstone_weight']=$item->gemstone_weight;
								$where['jewellery_type']=$item->jewellery_type;
								/*$where['metal_type']=$item->metal_type;
								if(@$item->jewellery_type!='OS' && @$item->metal_type)
								{
									if(@$item->jewellery_type=='R')
									{
										
										if(@$item->metal_type=='G')
										{
											$where['gold_purity']=@$item->gold_purity;
										}
										$where['ring_size_system']=@$item->ring_size_system;
										$where['ring_size']=@$item->ring_size;				
									}
									if(@$item->jewellery_type=='P')
									{
										if(@$item->metal_type=='G')
										{
											$where['gold_purity']=@$item->gold_purity;
										}										
										$where['pendant_type']=@$item->pendant_type;
									}
									if(@$item->jewellery_type=='B')
									{
										if(@$item->metal_type=='G')
										{
											$where['gold_purity']=@$item->gold_purity;
										}
										$where['bracelet_design_id']=@$item->bracelet_design_id;
									}
								}
								$where['certificate_id']=$item->certificate_id;
								$where['puja_energization_id']=$item->puja_energization_id;*/
								$gemcheck=Cart::where($where)->first();
								if(@$gemcheck)
								{
									$upd['quantity']=$gemcheck->quantity+$item->quantity;
									$upd['price_inr']=$gemcheck->price_inr;
									$upd['price_usd']=$gemcheck->price_usd;
									if(@$gemcheck->gift_pack_price_inr){
									$upd['gift_pack_price_inr']=$gemcheck->gift_pack_price_inr;
									}
									else
									{
										if($item->gift_pack_price_inr>0)
										{
											$upd['gift_pack_price_inr']=$item->gift_pack_price_inr;
										}
										else
										{
											$upd['gift_pack_price_inr']=0;
										}
									}
									if(@$gemcheck->gift_pack_price_usd){
										$upd['gift_pack_price_usd']=$gemcheck->gift_pack_price_usd;
									}
									else
									{
										if($item->gift_pack_price_usd>0)
										{
											$upd['gift_pack_price_usd']=$item->gift_pack_price_usd;
										}
										else
										{
											$upd['gift_pack_price_usd']=0;
										}
									}
									if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
										$upd['price_inr']=round($upd['price_inr'] - (($upd['price_inr']/100))* @$productDetails->discount_inr);
										
									}
									if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
										$upd['price_inr']=round($upd['price_usd'] - (($upd['price_usd']/100))* @$productDetails->discount_usd);
										
									}
									$total_price_inr=$total_price_inr+$upd['price_inr']+$gemcheck->gold_purity_price_inr+$gemcheck->ring_price_inr+$gemcheck->pendant_price_inr+$gemcheck->pendant_chain_price_inr+$gemcheck->bracelet_design_price_inr+$gemcheck->certification_price_inr+$gemcheck->puja_energization_price_inr;
									$total_price_usd=$total_price_usd+$upd['price_usd']+$gemcheck->gold_purity_price_usd+$gemcheck->ring_price_usd+$gemcheck->pendant_price_usd+$gemcheck->pendant_chain_price_usd+$gemcheck->bracelet_design_price_usd+$gemcheck->certification_price_usd+$gemcheck->puja_energization_price_usd;
									$upd['total_price_inr']=($total_price_inr*$upd['quantity'])+$upd['gift_pack_price_inr'];
									$upd['total_price_usd']=($total_price_usd*$upd['quantity'])+$upd['gift_pack_price_usd'];
									Cart::where('id',$gemcheck->id)->update($upd);
								}
								else
								{
									$upd=array();
									$upd['cart_session_id']='';
									$upd['user_id']=auth()->user()->id;
									Cart::where('id',$item->id)->update($upd);
								}
								
							}
							else
							{
								$upd=array();
								$upd['quantity']=$check->quantity+$item->quantity;
								if(@$check->gift_pack_price_inr){
									$upd['gift_pack_price_inr']=$check->gift_pack_price_inr;
								}
								else
								{
									if($item->gift_pack_price_inr>0)
									{
										$upd['gift_pack_price_inr']=$item->gift_pack_price_inr;
									}
									else
									{
										$upd['gift_pack_price_inr']=0;
									}
								}
								if(@$check->gift_pack_price_usd){
									$upd['gift_pack_price_usd']=$check->gift_pack_price_usd;
								}
								else
								{
									if($item->gift_pack_price_usd>0)
									{
										$upd['gift_pack_price_usd']=$item->gift_pack_price_usd;
									}
									else
									{
										$upd['gift_pack_price_usd']=0;
									}
								}
								if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
									$upd['price_inr']=round($productDetails->price_inr - (($productDetails->price_inr/100))* @$productDetails->discount_inr);
									$upd['total_price_inr']=($upd['price_inr']*$upd['quantity'])+$upd['gift_pack_price_inr'];
								}
								if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
									$upd['price_usd']=round($productDetails->price_usd - (($productDetails->price_usd/100))* @$productDetails->discount_usd);
									$upd['total_price_usd']=($upd['price_usd']*$upd['quantity'])+$upd['gift_pack_price_usd'];
								}
								Cart::where('id',$check->id)->update($upd);
							}
                        }
						else
						{
							$upd=array();
							$upd['cart_session_id']='';
							$upd['user_id']=auth()->user()->id;
							Cart::where('id',$item->id)->update($upd);
						}
                    }
					Cart::where('cart_session_id',$cart_id)->delete();                    
                }
                if (@$userDataEmail->url_slug!="") {
                    // return @$userDataPhone->url_slug;
                    $url = @$userDataEmail->url_slug;
                    session()->put( 'customurl', $url);
                    User::where('email',$request->username)->update(['url_slug'=>'','url_type'=>'']);
                    return redirect(Session::get('customurl'));
                }
                // extra-work
                $exp = explode('/',@$request->custom_url);
                if (@$request->custom_url!="" && end($exp)!=@$userDataEmail->slug) {
                    if (@$userDataEmail->url_slug!="") {
                         User::where('email',$request->username)->update(['url_slug'=>'','url_type'=>'']);
                     }
                     return redirect(Session::get('customurl'));
                 }
                
            if($userDataEmail->user_type=='C'){
                return redirect()->route('customer.dashboard');
            }
            if($userDataEmail->user_type=='A'){
                return redirect()->route('astrologer.dashboard');
            }
            if($userDataEmail->user_type=='P'){
                return redirect()->route('pundit.dashboard');
            }

        }
        /* login using mobile */
        $userDataPhone=User::where('mobile',$request->username)->where('status','!=','D')->first();
        if($userDataPhone){
            if (!Hash::check($request->password, $userDataPhone->password)) {
                session()->flash('error', \Lang::get('auth.email_password_wrong'));
                return redirect()->back()->withInput($request->input());
            }
            if ($userDataPhone->status == 'U') {
                $upd['otp'] = mt_rand(100000, 999999);
                User::where('id', $userDataPhone->id)->update($upd);
                $user = User::where('id', $userDataPhone->id)->first();
                // Mail::to($user->email)->send(new EmailVerification($user));
                session()->flash('error', \Lang::get('auth.user_mobile_account_not_verify'));
                return redirect()->route('account.otp', ['id' => $user->id]);
            }
            if ($userDataPhone->is_mobile_verify == 'N') {
                $upd['otp'] = mt_rand(100000, 999999);
                User::where('id', $userDataPhone->id)->update($upd);
                $user = User::where('id', $userDataPhone->id)->first();
                // Mail::to($user->email)->send(new EmailVerification($user));
                session()->flash('error', \Lang::get('auth.user_mobile_not_verify'));
                return redirect()->route('account.otp', ['id' => $user->id]);
            }
            if ($userDataPhone->status == 'I') {
                session()->flash('error', \Lang::get('auth.user_inactive'));
                return redirect()->back()->withInput($request->input());
            }
            Auth::login($userDataPhone);
            session()->flash('success', \Lang::get('auth.login_success'));
			User::where('id',auth()->user()->id)->update(['last_login'=>date('Y-m-d H:i:s')]);
            $cart_id = Session::get('cart_session_id');
                $isAvailable = Cart::where('cart_session_id',$cart_id)->get();
                if($isAvailable->count()>0){
                    foreach($isAvailable as $item){
                        $check=Cart::where('product_id',$item->product_id)->where('user_id',auth()->user()->id)->first();
						$productDetails = Products::where('id',$item->product_id)->first();
                        if(@$check){
                            if(@$check->cart_type=='GS')
							{
								$total_price_inr=0;
								$total_price_usd=0;
								$where=array();
								$where['product_id']=$item->product_id;
								$where['user_id']=auth()->user()->id;
								//$where['gemstone_weight']=$item->gemstone_weight;
								$where['jewellery_type']=$item->jewellery_type;
								/*$where['metal_type']=$item->metal_type;
								if(@$item->jewellery_type!='OS' && @$item->metal_type)
								{
									if(@$item->jewellery_type=='R')
									{
										
										if(@$item->metal_type=='G')
										{
											$where['gold_purity']=@$item->gold_purity;
										}
										$where['ring_size_system']=@$item->ring_size_system;
										$where['ring_size']=@$item->ring_size;				
									}
									if(@$item->jewellery_type=='P')
									{
										if(@$item->metal_type=='G')
										{
											$where['gold_purity']=@$item->gold_purity;
										}										
										$where['pendant_type']=@$item->pendant_type;
									}
									if(@$item->jewellery_type=='B')
									{
										if(@$item->metal_type=='G')
										{
											$where['gold_purity']=@$item->gold_purity;
										}
										$where['bracelet_design_id']=@$item->bracelet_design_id;
									}
								}
								$where['certificate_id']=$item->certificate_id;
								$where['puja_energization_id']=$item->puja_energization_id;*/
								$gemcheck=Cart::where($where)->first();
								if(@$gemcheck)
								{
									$upd['quantity']=$gemcheck->quantity+$item->quantity;
									$upd['price_inr']=$gemcheck->price_inr;
									$upd['price_usd']=$gemcheck->price_usd;
									if(@$gemcheck->gift_pack_price_inr){
									$upd['gift_pack_price_inr']=$gemcheck->gift_pack_price_inr;
									}
									else
									{
										if($item->gift_pack_price_inr>0)
										{
											$upd['gift_pack_price_inr']=$item->gift_pack_price_inr;
										}
										else
										{
											$upd['gift_pack_price_inr']=0;
										}
									}
									if(@$gemcheck->gift_pack_price_usd){
										$upd['gift_pack_price_usd']=$gemcheck->gift_pack_price_usd;
									}
									else
									{
										if($item->gift_pack_price_usd>0)
										{
											$upd['gift_pack_price_usd']=$item->gift_pack_price_usd;
										}
										else
										{
											$upd['gift_pack_price_usd']=0;
										}
									}
									if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
										$upd['price_inr']=round($upd['price_inr'] - (($upd['price_inr']/100))* @$productDetails->discount_inr);
										
									}
									if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
										$upd['price_inr']=round($upd['price_usd'] - (($upd['price_usd']/100))* @$productDetails->discount_usd);
										
									}
									$total_price_inr=$total_price_inr+$upd['price_inr']+$gemcheck->gold_purity_price_inr+$gemcheck->ring_price_inr+$gemcheck->pendant_price_inr+$gemcheck->pendant_chain_price_inr+$gemcheck->bracelet_design_price_inr+$gemcheck->certification_price_inr+$gemcheck->puja_energization_price_inr;
									$total_price_usd=$total_price_usd+$upd['price_usd']+$gemcheck->gold_purity_price_usd+$gemcheck->ring_price_usd+$gemcheck->pendant_price_usd+$gemcheck->pendant_chain_price_usd+$gemcheck->bracelet_design_price_usd+$gemcheck->certification_price_usd+$gemcheck->puja_energization_price_usd;
									$upd['total_price_inr']=($total_price_inr*$upd['quantity'])+$upd['gift_pack_price_inr'];
									$upd['total_price_usd']=($total_price_usd*$upd['quantity'])+$upd['gift_pack_price_usd'];
									Cart::where('id',$gemcheck->id)->update($upd);
								}
								else
								{
									$upd=array();
									$upd['cart_session_id']='';
									$upd['user_id']=auth()->user()->id;
									Cart::where('id',$item->id)->update($upd);
								}
								
							}
							else
							{
								$upd=array();
								$upd['quantity']=$check->quantity+$item->quantity;
								if(@$check->gift_pack_price_inr){
									$upd['gift_pack_price_inr']=$check->gift_pack_price_inr;
								}
								else
								{
									if($item->gift_pack_price_inr>0)
									{
										$upd['gift_pack_price_inr']=$item->gift_pack_price_inr;
									}
									else
									{
										$upd['gift_pack_price_inr']=0;
									}
								}
								if(@$check->gift_pack_price_usd){
									$upd['gift_pack_price_usd']=$check->gift_pack_price_usd;
								}
								else
								{
									if($item->gift_pack_price_usd>0)
									{
										$upd['gift_pack_price_usd']=$item->gift_pack_price_usd;
									}
									else
									{
										$upd['gift_pack_price_usd']=0;
									}
								}
								if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
									$upd['price_inr']=round($productDetails->price_inr - (($productDetails->price_inr/100))* @$productDetails->discount_inr);
									$upd['total_price_inr']=($upd['price_inr']*$upd['quantity'])+$upd['gift_pack_price_inr'];
								}
								if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
									$upd['price_usd']=round($productDetails->price_usd - (($productDetails->price_usd/100))* @$productDetails->discount_usd);
									$upd['total_price_usd']=($upd['price_usd']*$upd['quantity'])+$upd['gift_pack_price_usd'];
								}
								Cart::where('id',$check->id)->update($upd);
							}
                        }
						else
						{
							$upd=array();
							$upd['cart_session_id']='';
							$upd['user_id']=auth()->user()->id;
							Cart::where('id',$item->id)->update($upd);
						}
                    }
					Cart::where('cart_session_id',$cart_id)->delete();                    
                }
                if (@$userDataPhone->url_slug!="") {
                    // return @$userDataPhone->url_slug;
                    $url = @$userDataPhone->url_slug;
                    session()->put( 'customurl', $url);
                    User::where('mobile',$request->username)->update(['url_slug'=>'','url_type'=>'']);
                    return redirect(Session::get('customurl'));
                }
                // extra-work
                $exp = explode('/',@$request->custom_url);
                if (@$request->custom_url!="" && end($exp)!=@$userDataPhone->slug) {
                    if (@$userDataPhone->url_slug!="") {
                         User::where('mobile',$request->username)->update(['url_slug'=>'','url_type'=>'']);
                     }
                     return redirect(Session::get('customurl'));
                }
            if ($userDataPhone->user_type == 'C') {
                return redirect()->route('customer.dashboard');
            }
            if ($userDataPhone->user_type == 'A') {
                return redirect()->route('astrologer.dashboard');
            }
            if ($userDataPhone->user_type == 'P') {
                return redirect()->route('pundit.dashboard');
            }
        }
        session()->flash('error', \Lang::get('auth.user_not_found'));
        return redirect()->back()->withInput($request->input());

    }
    /**
     *   Method      : forgotPassword
     *   Description : forgot Password page view and send email link
     *   Author      : Soumojit
     *   Date        : 2021-APR-23
     **/

    public function forgotPassword(Request $request)
    {
        if ($request->all()) {
            $request->validate([
                'email' => 'required|email'
            ]);
            $user = User::where('email', $request->email)->whereIn('status', ['U', 'A', 'I'])->first();
            if (@$user) {
                if (@$user->status == 'I') {
                    session()->flash('error', \Lang::get('auth.user_inactive'));
                    return redirect()->back()->withInput($request->input());
                }
                $vcode = str_random(60);
                User::where('email', $user->email)->update([
                    'vcode' => $vcode
                ]);
                $data_update = User::where('email', $user->email)->first();
                Mail::to($request->email)->send(new ForgotPasswordEmailVerification($data_update));
                return view('auth.success_forgot');
            } else {
                session()->flash('error', \Lang::get('auth.user_not_found'));
                return redirect()->back()->withInput($request->input());
            }
        }
        return view('auth.forgot_password');
    }
    /**
     *   Method      : forgotPasswordVerifyMail
     *   Description : email link verify
     *   Author      : Soumojit
     *   Date        : 2021-APR-23
     **/
    public function forgotPasswordVerifyMail($id, $code)
    {
        $check_code = User::where('vcode', $code)->where('id', $id)->whereIn('status', ['U', 'A'])->first();
        if (@$check_code) {
            return view('auth.change_password')->with(['id' => $id, 'code' => $code]);
        }
        session()->flash('error', \Lang::get('auth.invalid_verification_link'));
        return redirect()->route('password.forgot');
    }
    /**
     *   Method      : changePassword
     *   Description : change Password for forgot password
     *   Author      : Soumojit
     *   Date        : 2021-APR-23
     **/
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'vcode' => 'required',
            'id' => 'required'
        ]);
        $check_code = User::where('vcode', $request->vcode)->where('id', $request->id)->whereIn('status', ['U', 'A'])->first();
        if (@$check_code) {
            $user = User::where('id', $check_code->id)->update([
                'password' => Hash::make($request->password),
                'status'  => 'A',
                'is_email_verify'  => 'Y',
                'vcode' => null
            ]);
            if (@$user) {
                session()->flash('success', \Lang::get('auth.password_change_success'));
                return redirect()->route('login');
            }
        }
        session()->flash('error', \Lang::get('auth.user_not_found'));
        return redirect()->route('forgot_password');
    }


    public function logout(Request $request)
    {
    	$currencyCode = session()->get('currencyCode');
    	$currency = session()->get('currency');
        $this->guard()->logout();

        $request->session()->invalidate();
        session(['currencyCode' => $currencyCode]);
        session(['currency' => $currency]);
        return $this->loggedOut($request) ?: redirect('/');
    }

}
