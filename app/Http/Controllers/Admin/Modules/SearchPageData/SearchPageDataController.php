<?php

namespace App\Http\Controllers\Admin\Modules\SearchPageData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SearchPageData;
class SearchPageDataController extends Controller
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

    public function index()
    {	$data = [];
    	$data['data'] = SearchPageData::get();
    	return view('admin.modules.search_page_data.manage_search_page_data',$data);
    }

    public function edit($id)
    {
    	$data = [];
    	$data['data'] = SearchPageData::where('id',$id)->first();
    	return view('admin.modules.search_page_data.edit_seach_page_data',$data);
    }

    public function update(Request $request)
    {
    	$update = SearchPageData::where('id',$request->id)->update([
    		'description'=>@$request->description,
    		'significance'=>@$request->significance,
    		'who_when'=>@$request->who_when,
    		'related_mantra'=>$request->related_mantra,
    		'usages'=>$request->usages,
    	]);
    	return redirect()->back()->with('success','Data Updated Successfully');
    }

    /**
     *   Method      : editwhyWho
     *   Description : edit why and who content
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/
    public function editwhyWho(Request $request)
    {
        $data = [];
        if($request->all()){
            $up['why_who'] = $request->why_who;
            SearchPageData::where('type','A')->update($up);
            return redirect()->back()->with('success','Data Updated Successfully');
        }
    	$data['data'] = SearchPageData::where('type','A')->first();
    	return view('admin.modules.why_who.edit_why_who',$data);
    }
}
