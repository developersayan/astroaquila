<?php

namespace App\Http\Controllers\Admin\Modules\Language;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LanguageSpeak;
use App\Models\AstrologerToLanguages;
class LanguageController extends Controller
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
    	$data=[];
    	$data['language'] = LanguageSpeak::orderBy('id','desc');
    	if (@$request->name) {
    		$data['language'] = $data['language']->where('language_name','LIKE','%'.request('name').'%');
    	}
    	$data['language'] = $data['language']->paginate(10);
    	return view('admin.modules.language.manage_language',$data);
    }

    public function addView()
    {
    	return view('admin.modules.language.add_language');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = LanguageSpeak::where('language_name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = LanguageSpeak::where('language_name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function add(Request $request)
    {
    	$language = new LanguageSpeak;
    	$language->language_name = $request->name;
    	$language->save();
    	return redirect()->back()->with('success','Language Added Successfully');
    }

    public function delete($id)
    {
    	$check = AstrologerToLanguages::where('language_id',$id)->first();
    	if (@$check!="") {
    		return redirect()->back()->with('error','Language Can Not Be Deleted As It Is Associated With Astrologer');
    	}
    	LanguageSpeak::where('id',$id)->delete();
    	return redirect()->back()->with('success','Language Deleted Successfully');
    }

    public function edit($id)
    {
    	$data = [];
    	$data['data'] = LanguageSpeak::where('id',$id)->first();
    	return view('admin.modules.language.edit_language',$data);
    }

    public function update(Request $request)
    {
    	LanguageSpeak::where('id',$request->id)->update(['language_name'=>$request->name]);
    	return redirect()->back()->with('success','Language Updated Successfully');
    }









}
