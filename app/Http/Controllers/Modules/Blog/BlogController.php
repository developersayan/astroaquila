<?php

namespace App\Http\Controllers\Modules\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
class BlogController extends Controller
{
    //
    public function index()
    {
    	$data = [];
    	$data['blogs'] = Blog::where('status','A')->orderBy('id','desc')->paginate(10);
    	$data['recents'] = Blog::where('status','A')->orderBy('id','desc')->limit(6)->get();
    	return view('modules.blog.blog',$data);
    }

    public function blogDetails($slug)
    {
    	$data = [];
    	$data['blog'] = Blog::where('status','A')->where('slug',$slug)->first();
    	$data['allblog'] = Blog::where('status','A')->orderBy('id','desc')->where('id','!=',$data['blog']->id)->limit(3)->get();
    	$data['related'] = Blog::where('status','A')->orderBy('id','desc')->where('id','!=',$data['blog']->id)->where('category_id',$data['blog']->category_id)->get();
    	return view('modules.blog.blog_details',$data);
    }

}
