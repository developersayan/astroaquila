<?php

namespace App\Http\Controllers\Admin\Modules\Faq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Products;
use App\Models\Puja;
use App\Models\FaqCategory;
use App\Models\FaqProduct;
use App\Models\FaqPuja;
use App\Models\Horoscope;
use App\Models\FaqHoroscope;
use App\Models\FaqAstro;
use App\User;
class FaqController extends Controller
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
    	$data['faq']  = Faq::where('product_id',0)->where('puja_id',0)->orderBy('id','desc');
    	if (@$request->keyword) {
    		$data['faq'] = $data['faq']->where(function($query){
    			$query->where('question','LIKE','%'.request('keyword').'%')
    				  ->orWhere('answer','LIKE','%'.request('keyword').'%');
    		});
    	}
    	if (@$request->type) {
    		$data['faq'] = $data['faq']->where('type',$request->type);
    	}
        if (@$request->category_id) {
            $data['faq'] = $data['faq']->where('category_id',$request->category_id);
            $data['sub_categories']  = FaqCategory::where('parent_id',@$request->category_id)->get();
        }
        if (@$request->sub_category_id) {
            $data['faq'] = $data['faq']->where('subcategory_id',$request->sub_category_id);
        }
        if (@$request->show) {
            $data['faq'] = $data['faq']->where('show_in_search',@$request->show);
        }
    	$data['faq'] = $data['faq']->paginate(10);
        $data['category'] = FaqCategory::where('parent_id',0)->get();
    	return view('admin.modules.faq.manage_faq',$data);
    }

    public function addView(Request $request)
    {
        $data = [];
        $data['category'] = FaqCategory::where('parent_id',0)->get();
    	return view('admin.modules.faq.add_faq',$data);
    }

    public function add(Request $request)
    {
    	$ins = [];
    	$ins['question'] = $request->question;
    	$ins['answer'] = $request->answer;
    	$ins['type'] = $request->type;
        $ins['display_order'] = $request->display_order;
    	$ins['product_id'] = 0;
    	$ins['puja_id'] = 0;
        $ins['horoscope_id'] = 0;
        $ins['astrologer_id'] = 0;
        $ins['category_id'] = $request->category_id;
        $ins['subcategory_id'] = $request->sub_category_id;
    	Faq::create($ins);
    	return redirect()->back()->with('success','General Faq Added Successfully');
    }

    public function delete($id)
    {
    	$check = Faq::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        if (@$check->type=="PU") {
            $checkpuja = FaqPuja::where('faq_id',$id)->first();
            if (@$checkpuja!="") {
                return redirect()->back()->with('error','Faq Can Not Be Deleted As It Associated With Puja');
            }
        }
        if (@$check->type=="P") {
            $checkpuja = FaqProduct::where('faq_id',$id)->first();
            if (@$checkpuja!="") {
                return redirect()->back()->with('error','Faq Can Not Be Deleted As It Associated With Product');
            }
        }
        if (@$check->type=="G") {
            $checkpuja = FaqProduct::where('faq_id',$id)->first();
            if (@$checkpuja!="") {
                return redirect()->back()->with('error','Faq Can Not Be Deleted As It Associated With Gemstone');
            }
        }
        if (@$check->type=="H") {
            $checkpuja = FaqHoroscope::where('faq_id',$id)->first();
            if (@$checkpuja!="") {
                return redirect()->back()->with('error','Faq Can Not Be Deleted As It Associated With Hororscope');
            }
        }
    	$delete = Faq::where('id',$id)->delete();
    	return redirect()->back()->with('success','General Faq Deleted Successfully');
    }

    public function editView($id)
    {
    	$check = Faq::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data['data'] = $check;
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['subcategory'] = FaqCategory::where('parent_id', $check->category_id)->get();
    	return view('admin.modules.faq.edit_faq',$data);
    }

    public function update(Request $request)
    {
    	$upd = [];
    	$upd['question'] = $request->question;
    	$upd['answer'] = $request->answer;
    	$upd['type'] = $request->type;
        $upd['category_id'] = $request->category_id;
        $upd['subcategory_id'] = $request->sub_category_id;
        $upd['display_order'] = $request->display_order;
    	Faq::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','Gemeral Faq Updated Successfully');
    }


    public function manageFaqPuja(Request $request,$id)
    {
        $data = [];
        $data['faq'] = Faq::where('puja_id',$id);
        if (@$request->keyword) {
            $data['faq'] = $data['faq']->where(function($query){
                $query->where('question','LIKE','%'.request('keyword').'%')
                      ->orWhere('answer','LIKE','%'.request('keyword').'%');
            });
        }

        $data['type'] = 'PU';
        $data['id'] = $id;
        $data['code'] = Puja::where('id',$id)->first();
        $data['faq'] = $data['faq']->orderBy('id','desc')->paginate(10);
        return view('admin.modules.faq.manage_individual_faq',$data);
    }


    public function manageFaqPujaAddView($id)
    {
        $data['type'] = 'PU';
        $data['id'] = $id;
        $data['code'] = Puja::where('id',$id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        return view('admin.modules.faq.add_individual_faq',$data);
    }

    public function addFaq(Request $request)
    {
        $ins = [];
        $ins['question'] = $request->question;
        $ins['answer'] = $request->answer;
        $ins['type'] = $request->type;
        $ins['category_id'] = $request->category_id;
        $ins['subcategory_id'] = $request->sub_category_id;
        $ins['display_order'] = $request->display_order;
        if(@$request->type=="PU")
        {
          $ins['puja_id'] = $request->product_id;
          $ins['product_id'] = 0;
          $ins['horoscope_id'] = 0;
          $ins['astrologer_id'] = 0;
        }
        elseif(@$request->type=="H")
        {
          $ins['horoscope_id'] = $request->product_id;
          $ins['product_id'] = 0; 
          $ins['puja_id'] = 0; 
          $ins['astrologer_id'] = 0;

        }
        elseif (@$request->type=="A") {
          $ins['horoscope_id'] = 0;
          $ins['product_id'] = 0; 
          $ins['puja_id'] = 0; 
          $ins['astrologer_id'] = $request->product_id;

        }    
        else{
           $ins['product_id'] = $request->product_id;
           $ins['puja_id'] = 0;
           $ins['horoscope_id'] = 0;
           $ins['astrologer_id'] = 0;

        }
        Faq::create($ins);
        return redirect()->back()->with('success','Faq Added Successfully');
    }

    public function manageFaqPuja_edit($faq)
    {
        $check = Faq::where('id',$faq)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $data = [];
        $data['data'] = $check;
        $data['type'] = $check->type;
        $data['code']= Puja::where('id',$check->puja_id)->first();
        $data['id'] = $check->puja_id;
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['subcategory'] = FaqCategory::where('parent_id', $check->category_id)->get();
        return view('admin.modules.faq.edit_individual_faq',$data);
    }

    public function updateFaq(Request $request)
    {
        $update = [];
        $update['question'] = $request->question;
        $update['answer'] = $request->answer;
        $update['type'] = $request->type;
        $update['category_id'] = $request->category_id;
        $update['subcategory_id'] = $request->sub_category_id;
        $update['display_order'] = $request->display_order;
        if(@$request->type=="PU")
        {
          $update['puja_id'] = $request->product_id;
          $update['product_id'] = 0;
        }else{
           $update['product_id'] = $request->product_id;
           $update['puja_id'] = 0;
        }
        Faq::where('id',$request->id)->update($update);
        return redirect()->back()->with('success','Faq Updated Successfully');
    }

    public function deleteFaq($id)
    {
        $check = Faq::where('id',$id)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $delete = Faq::where('id',$id)->delete();
        return redirect()->back()->with('success','Faq Deleted Successfully');
    }

    public function manageFaqGamestone(Request $request,$id)
    {
        $data = [];
        $data['faq'] = Faq::where('product_id',$id);
        if (@$request->keyword) {
            $data['faq'] = $data['faq']->where(function($query){
                $query->where('question','LIKE','%'.request('keyword').'%')
                      ->orWhere('answer','LIKE','%'.request('keyword').'%');
            });
        }

        $data['type'] = 'G';
        $data['id'] = $id;
        $data['code'] = Products::where('id',$id)->first();
        $data['faq'] = $data['faq']->orderBy('id','desc')->paginate(10);
        return view('admin.modules.faq.manage_individual_faq',$data);
    }

    public function manageFaqGemsAddView($id)
    {
        $data['type'] = 'G';
        $data['id'] = $id;
        $data['code'] = Products::where('id',$id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        return view('admin.modules.faq.add_individual_faq',$data);
    }

    public function manageFaqGames_edit($faq)
    {
        $check = Faq::where('id',$faq)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $data = [];
        $data['data'] = $check;
        $data['type'] = $check->type;
        $data['id'] = $check->product_id;
        $data['code']= Products::where('id',$check->product_id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['subcategory'] = FaqCategory::where('parent_id', $check->category_id)->get();
        return view('admin.modules.faq.edit_individual_faq',$data);
    }


    public function manageFaqProduct(Request $request,$id)
    {
        $data = [];
        $data['faq'] = Faq::where('product_id',$id);
        if (@$request->keyword) {
            $data['faq'] = $data['faq']->where(function($query){
                $query->where('question','LIKE','%'.request('keyword').'%')
                      ->orWhere('answer','LIKE','%'.request('keyword').'%');
            });
        }

        $data['type'] = 'P';
        $data['id'] = $id;
        $data['faq'] = $data['faq']->orderBy('id','desc')->paginate(10);
        $data['code'] = Products::where('id',$id)->first();
        return view('admin.modules.faq.manage_individual_faq',$data);
    }

    public function manageFaqProAddView($id)
    {
        $data['type'] = 'P';
        $data['id'] = $id;
        $data['code'] = Products::where('id',$id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        return view('admin.modules.faq.add_individual_faq',$data);
    }



    public function getsubcat(Request $request)
    {
        $data = FaqCategory::where('parent_id',$request->parent_id)->orderBy('faq_category','asc')->get();
        $response=array();
        $result="<option value=''>Select Sub Category</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request->id==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->faq_category."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->faq_category."</option>";
                }
                
            }
        }
        $response['sub_category']=$result;
        return response()->json($response);
    }


    public function showSearch($id)
    {
        $getdata = Faq::where('id',$id)->first();
        if (@$getdata->show_in_search=="N") {
            $update = Faq::where('id',$id)->update(['show_in_search'=>'Y']);
            return redirect()->back()->with('success','Faq Added In Search Page');
        }else{
            $update = Faq::where('id',$id)->update(['show_in_search'=>'N']);
            return redirect()->back()->with('success','Faq Removed From Search Page');
        }

    }


    /**
     *   Method      : manageFaqGems_generalview
     *   Description : show general faq question related to gamestone 
     *   Author      : Sayan
     *   Date        : 2021-NOV-10
     **/

    public function manageFaqGems_generalview(Request $request ,$id)
    {
        $data = [];
        $data['type'] = 'G';
        $data['id'] = $id;
        $data['code'] = Products::where('id',$id)->first();
        $data['selected'] = FaqProduct::where('product_id',$id)->get();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['questions'] = Faq::where('type','G')->where('product_id',0);
        if (@$request->category_id) {
            $data['questions'] = $data['questions']->where('category_id',$request->category_id);
            $data['sub_categories']  = FaqCategory::where('parent_id',@$request->category_id)->get();
        }
        if (@$request->sub_category_id) {
            $data['questions'] = $data['questions']->where('subcategory_id',$request->sub_category_id);
        }
        
        $data['questions'] = $data['questions']->get();
        if (@$request->category_id || @$request->sub_category_id) {
            @$data['request_status'] = 'Y';
            $data['question_get'] = $data['questions']->pluck('id')->toArray();
        }else{
            @$data['request_status'] = 'N';
        }    

        return view('admin.modules.faq.gamestone_general_faq',$data);
    }
    /**
     *   Method      : addGamestone_generalfaq
     *   Description : add general faq question related to gamestone 
     *   Author      : Sayan
     *   Date        : 2021-NOV-10
     **/


   public function addGamestone_generalfaq(Request $request)
   {
    // return $request;
        if (@$request->request_status=="N") {
         
        $question_id =array();
        if(@$request->question){
            foreach (@$request->question as  $value) {
                $c = FaqProduct::where('product_id',$request->id)->where('faq_id',$value)->first();
                if (@$c==null) {
                $ins['product_id'] = $request->id;
                $ins['faq_id'] = $value;
                $add = FaqProduct::create($ins);
                array_push($question_id, $add->id);
              }else{
                 array_push($question_id,$c->id);
              }
            }
        }
            FaqProduct::where('product_id',$request->id)->whereNotIn('id',$question_id)->delete();
            return redirect()->back()->with('success','Faq Added Successfully');
         }else{
            // return $request;
            $array = explode(',', $request->question_get);
            $question_id =array();
             if(@$request->question){
                 FaqProduct::where('product_id',$request->id)->whereIn('faq_id',$array)->delete();
                foreach (@$request->question as $key => $value) {
                    $ins['product_id'] = $request->id;
                    $ins['faq_id'] = $value;
                    $add = FaqProduct::create($ins);

                    //  $c = FaqProduct::where('product_id',$request->id)->where('faq_id',$value)->first();
                    // if (in_array($value,$array) && $c==null) {
                    //     $ins['product_id'] = $request->id;
                    //     $ins['faq_id'] = $value;
                    //     $add = FaqProduct::create($ins);
                    // }
                    // elseif (in_array($value,$array) && $c!=null) {
                    //     continue;
                    // }
                    // else{
                    //     FaqProduct::where('product_id',$request->id)->where('faq_id',$value)->delete();
                    // }

                }
            }else{
                FaqProduct::where('product_id',$request->id)->whereIn('faq_id',$array)->delete();
            }
            
            return redirect()->back()->with('success','Faq Added Successfully');

         }   
   
   }

  /**
     *   Method      : manageFaqProduct_generalview
     *   Description : show general faq question related to product 
     *   Author      : Sayan
     *   Date        : 2021-NOV-17
     **/

   public function manageFaqProduct_generalview(Request $request ,$id)
   {
        // return $request;
        $data = [];
        $data['type'] = 'P';
        $data['id'] = $id;
        $data['code'] = Products::where('id',$id)->first();
        $data['selected'] = FaqProduct::where('product_id',$id)->get();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['questions'] = Faq::where('type','P')->where('product_id',0);
        if (@$request->category_id) {
            $data['questions'] = $data['questions']->where('category_id',$request->category_id);
            $data['sub_categories']  = FaqCategory::where('parent_id',@$request->category_id)->get();
        }
        if (@$request->sub_category_id) {
            $data['questions'] = $data['questions']->where('subcategory_id',$request->sub_category_id);
        }
        
        $data['questions'] = $data['questions']->get();
        if (@$request->category_id || @$request->sub_category_id) {
            @$data['request_status'] = 'Y';
            $data['question_get'] = $data['questions']->pluck('id')->toArray();
        }else{
            @$data['request_status'] = 'N';
        }    

        return view('admin.modules.faq.product_general_faq',$data);
   }


   public function manageFaqPuja_generalview(Request $request ,$id)
   {
        $data = [];
        $data['type'] = 'PU';
        $data['id'] = $id;
        $data['code'] = Products::where('id',$id)->first();
        $data['selected'] = FaqPuja::where('puja_id',$id)->get();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['questions'] = Faq::where('type','PU')->where('puja_id',0);
        if (@$request->category_id) {
            $data['questions'] = $data['questions']->where('category_id',$request->category_id);
            $data['sub_categories']  = FaqCategory::where('parent_id',@$request->category_id)->get();
        }
        if (@$request->sub_category_id) {
            $data['questions'] = $data['questions']->where('subcategory_id',$request->sub_category_id);
        }
        
        $data['questions'] = $data['questions']->get();
        if (@$request->category_id || @$request->sub_category_id) {
            @$data['request_status'] = 'Y';
            $data['question_get'] = $data['questions']->pluck('id')->toArray();
        }else{
            @$data['request_status'] = 'N';
        }    

        return view('admin.modules.faq.puja_general_faq',$data);
   }


   public function addPuja_generalfaq(Request $request)
   {
            if (@$request->request_status=="N") {
         
        $question_id =array();
        if(@$request->question){
            foreach (@$request->question as  $value) {
                $c = FaqPuja::where('puja_id',$request->id)->where('faq_id',$value)->first();
                if (@$c==null) {
                $ins['puja_id'] = $request->id;
                $ins['faq_id'] = $value;
                $add = FaqPuja::create($ins);
                array_push($question_id, $add->id);
              }else{
                 array_push($question_id,$c->id);
              }
            }
        }
            FaqPuja::where('puja_id',$request->id)->whereNotIn('id',$question_id)->delete();
            return redirect()->back()->with('success','Faq Added Successfully');
         }else{
            // return $request;
            $array = explode(',', $request->question_get);
            $question_id =array();
             if(@$request->question){
                 FaqPuja::where('puja_id',$request->id)->whereIn('faq_id',$array)->delete();
                foreach (@$request->question as $key => $value) {
                    $ins['puja_id'] = $request->id;
                    $ins['faq_id'] = $value;
                    $add = FaqPuja::create($ins);

                    //  $c = FaqProduct::where('product_id',$request->id)->where('faq_id',$value)->first();
                    // if (in_array($value,$array) && $c==null) {
                    //     $ins['product_id'] = $request->id;
                    //     $ins['faq_id'] = $value;
                    //     $add = FaqProduct::create($ins);
                    // }
                    // elseif (in_array($value,$array) && $c!=null) {
                    //     continue;
                    // }
                    // else{
                    //     FaqProduct::where('product_id',$request->id)->where('faq_id',$value)->delete();
                    // }

                }
            }else{
                FaqPuja::where('puja_id',$request->id)->whereIn('faq_id',$array)->delete();
            }
            
            return redirect()->back()->with('success','Faq Added Successfully');

         }  
   }



   public function checkDisplay(Request $request)
   {
    if (@$request->id) {
          $check = Faq::where('display_order',$request->display_order)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
              
          }else{
             $check = Faq::where('display_order',$request->display_order)->first();
              if (!empty($check)) {
                   echo "false";
              }else{
                   echo "true";
              }
          }
   }



   public function manageHoroscopeFaq($id)
   {
        $data['type'] = 'H';
        $data['id'] = $id;
        $data['code'] = Horoscope::where('id',$id)->first();
        $data['faq'] = Faq::where('horoscope_id',$id);
        $data['faq'] = $data['faq']->orderBy('id','desc')->paginate(10);
        return view('admin.modules.faq.manage_individual_faq',$data);
   }

   public function manageHoroscopeFaqAddview($id)
   {
        $data['type'] = 'H';
        $data['id'] = $id;
        $data['code'] = Horoscope::where('id',$id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        return view('admin.modules.faq.add_individual_faq',$data);
   }

   public function manageHoroscopeFaqEdit($faq)
   {
        $check = Faq::where('id',$faq)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $data = [];
        $data['data'] = $check;
        $data['type'] = $check->type;
        $data['id'] = $check->horoscope_id;
        $data['code']= Horoscope::where('id',$check->horoscope_id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['subcategory'] = FaqCategory::where('parent_id', $check->category_id)->get();
        return view('admin.modules.faq.edit_individual_faq',$data);
   }


   public function horoscopeGeneral(Request$request,$id)
   {

        $data = [];
        $data['type'] = 'H';
        $data['id'] = $id;
        $data['code'] = Horoscope::where('id',$id)->first();
        $data['selected'] = FaqHoroscope::where('horoscope_id',$id)->get();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['questions'] = Faq::where('type','H')->where('horoscope_id',0);
        if (@$request->category_id) {
            $data['questions'] = $data['questions']->where('category_id',$request->category_id);
            $data['sub_categories']  = FaqCategory::where('parent_id',@$request->category_id)->get();
        }
        if (@$request->sub_category_id) {
            $data['questions'] = $data['questions']->where('subcategory_id',$request->sub_category_id);
        }
        
        $data['questions'] = $data['questions']->get();
        if (@$request->category_id || @$request->sub_category_id) {
            @$data['request_status'] = 'Y';
            $data['question_get'] = $data['questions']->pluck('id')->toArray();
        }else{
            @$data['request_status'] = 'N';
        }    

        return view('admin.modules.faq.hororscope_general_faq',$data);
   }


   public function horoscopeGeneralAdd(Request $request)
   {
    
       if (@$request->request_status=="N") {
         
        $question_id =array();
        if(@$request->question){
            foreach (@$request->question as  $value) {
                $c = FaqHoroscope::where('horoscope_id',$request->id)->where('faq_id',$value)->first();
                if (@$c==null) {
                $ins['horoscope_id'] = $request->id;
                $ins['faq_id'] = $value;
                $add = FaqHoroscope::create($ins);
                array_push($question_id, $add->id);
              }else{
                 array_push($question_id,$c->id);
              }
            }
        }
            FaqHoroscope::where('horoscope_id',$request->id)->whereNotIn('id',$question_id)->delete();
            return redirect()->back()->with('success','Faq Added Successfully');
         }else{
            // return $request;
            $array = explode(',', $request->question_get);
            $question_id =array();
             if(@$request->question){
                 FaqHoroscope::where('horoscope_id',$request->id)->whereIn('faq_id',$array)->delete();
                foreach (@$request->question as $key => $value) {
                    $ins['horoscope_id'] = $request->id;
                    $ins['faq_id'] = $value;
                    $add = FaqHoroscope::create($ins);


                }
            }else{
                FaqHoroscope::where('horoscope_id',$request->id)->whereIn('faq_id',$array)->delete();
            }
            
            return redirect()->back()->with('success','Faq Added Successfully');

         }  
   }



   public function manageFaqAstro($id)
   {
        $data['type'] = 'A';
        $data['id'] = $id;
        $data['code'] = User::where('id',$id)->first();
        $data['faq'] = Faq::where('astrologer_id',$id);
        $data['faq'] = $data['faq']->orderBy('id','desc')->paginate(10);
        return view('admin.modules.faq.manage_individual_faq',$data);
   }

   public function addFaqAstroView($id)
   {
        $data['type'] = 'A';
        $data['id'] = $id;
        $data['code'] = User::where('id',$id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        return view('admin.modules.faq.add_individual_faq',$data);
   }


   public function editFaqAstroView($faq)
   {
       $check = Faq::where('id',$faq)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $data = [];
        $data['data'] = $check;
        $data['type'] = $check->type;
        $data['id'] = $check->astrologer_id;
        $data['code']= User::where('id',$check->astrologer_id)->first();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['subcategory'] = FaqCategory::where('parent_id', $check->category_id)->get();
        return view('admin.modules.faq.edit_individual_faq',$data);
   }


   public function astroGeneral( Request $request,$id)
   {
        // return $id;
        $data = [];
        $data['type'] = 'A';
        $data['id'] = $id;
        $data['code'] = User::where('id',$id)->first();
        $data['selected'] = FaqAstro::where('astro_id',$id)->get();
        $data['category'] = FaqCategory::where('parent_id',0)->get();
        $data['questions'] = Faq::where('type','A')->where('astrologer_id',0);
        if (@$request->category_id) {
            $data['questions'] = $data['questions']->where('category_id',$request->category_id);
            $data['sub_categories']  = FaqCategory::where('parent_id',@$request->category_id)->get();
        }
        if (@$request->sub_category_id) {
            $data['questions'] = $data['questions']->where('subcategory_id',$request->sub_category_id);
        }
        
        $data['questions'] = $data['questions']->get();
        if (@$request->category_id || @$request->sub_category_id) {
            @$data['request_status'] = 'Y';
            $data['question_get'] = $data['questions']->pluck('id')->toArray();
        }else{
            @$data['request_status'] = 'N';
        }    

        return view('admin.modules.faq.astro_general_faq',$data);
   }



   public function addAstroGeneral(Request $request)
   {
       if (@$request->request_status=="N") {
         
        $question_id =array();
        if(@$request->question){
            foreach (@$request->question as  $value) {
                $c = FaqAstro::where('astro_id',$request->id)->where('faq_id',$value)->first();
                if (@$c==null) {
                $ins['astro_id'] = $request->id;
                $ins['faq_id'] = $value;
                $add = FaqAstro::create($ins);
                array_push($question_id, $add->id);
              }else{
                 array_push($question_id,$c->id);
              }
            }
        }
            FaqAstro::where('astro_id',$request->id)->whereNotIn('id',$question_id)->delete();
            return redirect()->back()->with('success','Faq Added Successfully');
         }else{
            // return $request;
            $array = explode(',', $request->question_get);
            $question_id =array();
             if(@$request->question){
                 FaqAstro::where('astro_id',$request->id)->whereIn('faq_id',$array)->delete();
                foreach (@$request->question as $key => $value) {
                    $ins['astro_id'] = $request->id;
                    $ins['faq_id'] = $value;
                    $add = FaqAstro::create($ins);


                }
            }else{
                FaqAstro::where('astro_id',$request->id)->whereIn('faq_id',$array)->delete();
            }
            
            return redirect()->back()->with('success','Faq Added Successfully');

         }  
   }





}
