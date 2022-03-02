<?php

namespace App\Http\Controllers\Admin\Modules\ManageAquiliaWiki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AquilaWiki;
use App\Models\WikiTitle;
use App\Models\WikiCategory;
class ManageAquiliaWikiController extends Controller
{
    /**
     *   Method      : addAquiliaWiki
     *   Description : get astro wike list
     *   Author      : Argha
     *   Date        : 2021-DEC-17
     **/
    public function addAquiliaWiki(Request $request,$id=null)
    {
        if($id){
            $data['wiki'] = AquilaWiki::with(['getCategory','getSubCategory','getTitle'])
                                        ->where('id',$id)
                                        ->first();
            $data['subcategory'] = WikiCategory::where('parent_id',$data['wiki']->category)->get();
        }
        $data['title'] = WikiTitle::get();
        $data['category'] = WikiCategory::where('parent_id',0)->get();
        return view('admin.modules.aquilia_wiki.add_aquilia_wiki')->with($data);
    }

    /**
     *   Method      : getSubcategory
     *   Description : get subcategory list
     *   Author      : Argha
     *   Date        : 2021-DEC-17
     **/

     public function getSubcategory(Request $request)
     {
         $subcat_id = $request->id;
         $getSubcat = WikiCategory::where('parent_id',$subcat_id)->get();

         $res['subcat'] = $getSubcat;
         return response()->json($res);
     }
     /**
     *   Method      : insertAquiliaWiki
     *   Description : insert / update aquilia wiki
     *   Author      : Argha
     *   Date        : 2021-DEC-17
     **/
     public function insertAquiliaWiki(Request $request)
     {
        $request->validate([
            'title' => 'required',
            'article_title' => 'required',
            'category' => 'required'
        ]);

        $insWiki['title'] = $request->title;
        $insWiki['article_title'] = $request->article_title;
        $insWiki['category'] = $request->category;
        $insWiki['subcategory'] = $request->subcategory;
        $insWiki['description'] = $request->description;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/wiki_pdf/'.@$request->astro_image)){
                unlink('storage/app/public/wiki_pdf/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/wiki_image/',$filename);
            $insWiki['image'] = $filename;
        }
        if(@$request->pdf){
            if(@$request->astro_pdf && file_exists('storage/app/public/wiki_pdf/'.@$request->astro_pdf)){
                unlink('storage/app/public/wiki_pdf/'.@$request->astro_pdf);
            }
            $pdf = $request->pdf;
            $filename = time().'-'.rand(1000,9999).'.'.$pdf->getClientOriginalExtension();
            $pdf->move('storage/app/public/wiki_pdf/',$filename);
            $insWiki['pdf'] = $filename;
        }

        if(@$request->wiki_id){
            AquilaWiki::where('id',@$request->wiki_id)->update($insWiki);
            return redirect()->back()->with('success','Article updated successfully');
        }else{
            $ins = AquilaWiki::create($insWiki);
            $check_slug = AquilaWiki::where('slug',str_slug($request->article_title))
                                    ->first();
            $slug = '';
            if($check_slug){
                $slug = str_slug($request->article_title).'-'.$ins->id;
            }else{
                $slug = str_slug($request->article_title);
            }
            AquilaWiki::where('id',$ins->id)->update(['slug' =>$slug]);
            return redirect()->back()->with('success','Article added successfully');
        }
     }
     /**
     *   Method      : index
     *   Description : list of aquilia wiki
     *   Author      : Argha
     *   Date        : 2021-DEC-17
     **/
     public function index(Request $request)
     {
        $wiki = AquilaWiki::with(['getCategory','getSubCategory','getTitle']);
        if($request->all()){
            if($request->title){
                $wiki = $wiki->where('title',$request->title);
            }
            if($request->category){
                $wiki = $wiki->where('category',$request->category);
            }
            if($request->keyword){
                $wiki = $wiki->whereHas('getSubCategory',function($q) use($request){
                    $q->where('name','like','%'.$request->keyword.'%');
                })
                ->orWhereHas('getCategory',function($q) use($request){
                    $q->where('name','like','%'.$request->keyword.'%');
                })
                ->where('article_title','like','%'.$request->keyword.'%');
            }
            $data['key'] = $request->all();
        }
        $wiki = $wiki->paginate(10);

        $data['wiki'] = $wiki;
        $data['title'] = WikiTitle::get();
        $data['category'] = WikiCategory::where('parent_id',0)->get();
        return view('admin.modules.aquilia_wiki.aquilia_wiki_list')->with($data);
     }
     /**
     *   Method      : index
     *   Description : delete a wiki
     *   Author      : Argha
     *   Date        : 2021-DEC-17
     **/
    public function deleteWiki(Request $request)
    {
        AquilaWiki::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Article deleted successfully');
    }
    /**
     *   Method      : deletePdf
     *   Description : delete pdf
     *   Author      : Argha
     *   Date        : 2021-DEC-17
     **/
    public function deleteWikiPdf(Request $request)
    {
        $data = AquilaWiki::where('id',$request->id)->first();
        @unlink('storage/app/public/wiki_image/'.$data->pdf);
        AquilaWiki::where('id',$request->id)->update(['pdf'=>'']);
        echo "success";
    }

    public function deleteWikiImage(Request $request)
    {
        $data = AquilaWiki::where('id',$request->id)->first();
        @unlink('storage/app/public/wiki_image/'.$data->image);
        AquilaWiki::where('id',$request->id)->update(['image'=>'']);
        echo "success";
    }
}
