<?php

namespace App\Http\Controllers\Admin\Modules\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Image;
use App\Providers\Libraries\ImageResize;
class BlogController extends Controller
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
     
    public function index(Request $request)
    {
    	$data = [];
    	$data['blogs'] = Blog::where('status','!=','D');
    	if (@$request->keyword) {
    		// dd($request->keyword);
    		$data['blogs'] = $data['blogs']->where(function($query){
    			$query->where('blog_title','LIKE','%'.request('keyword').'%')
    			->orWhere('blog_desc','LIKE','%'.request('keyword').'%')
    			->orWhere('author_name','LIKE','%'.request('keyword').'%');
    		});
    	}
    	if(@$request->status){
            $data['blogs']= $data['blogs']->where('status', @$request->status);
        }

        if(@$request->category){
            $data['blogs']= $data['blogs']->where('category_id', @$request->category);
        }

    	$data['blogs'] = $data['blogs']->orderBy('id','desc')->paginate(10);
    	$data['category'] = BlogCategory::where('status','A')->orderBy('category','asc')->get();
    	return view('admin.modules.blogs.manage_blog',$data);
    } 

     public function addBlogView()
     {
     	$data = [];
     	$data['category'] = BlogCategory::where('status','A')->orderBy('category','asc')->get();
        return view('admin.modules.blogs.add_blog',$data);
     }

     public function addBlog(Request $request)
     {
		$blog = new Blog;
     	$blog->category_id = $request->category_id;
     	$blog->blog_title = $request->blog_title;
     	$blog->blog_desc = $request->blog_description;
     	$blog->meta_title = $request->meta_title;
     	$blog->meta_desc = $request->meta_description;
     	$blog->author_name = $request->author_name;
     	$blog->status = 'A';
     	if (@$request->image) {
     		$image = $request->image;
     		$filename = time().'_'.$image->getClientOriginalName();
            $destinationPath = "storage/app/public/BlogImage/";
            $image->move($destinationPath, $filename);

            // call to image resize function 300*300
            ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/BigBlogImage/", 'dimension' => [1096,600], 'filename' =>$filename]);

            ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/SmallBlogImage/", 'dimension' => [370, 200], 'filename' =>$filename]);
     	}
     	$blog->blog_pic=$filename;
     	$blog->save();
     	$update = Blog::where('id',$blog->id)->update([
            'slug'=> str_slug($request->blog_title).'-'.$blog->id,
        ]);
        return redirect()->back()->with('success','Blog Added Successfully');
     }

     public function checkSize(Request $request)
     {
     	if ($request->hasFile('img'))
          {

            $image = $request->img;
            $height = Image::make($image)->height();
            $width = Image::make($image)->width();
            return response()->json(['h'=>$height,'w'=>$width]);
          }
     }


     public function checkBlogName(Request $request)
     {
     	if (@$request->id) {
            $checkBlog = Blog::where('blog_title',$request->blog_title)->where('category_id',$request->category_id)->where('id','!=',$request->id)->where('status','!=','D')->first();
            if ($checkBlog!="") {
                echo "found";
            }else{
                echo "not found";
            }
        }else{
        $checkBlog = Blog::where('blog_title',$request->blog_title)->where('category_id',$request->category_id)->where('status','!=','D')->first();
        if ($checkBlog!="") {
            echo "found";
        }else{
            echo "not found";
        }
     }

     }


     public function editBlogView($id)
     {
     	$data = [];
     	$data['data'] = Blog::where('id',$id)->where('status','!=','D')->first();
     	if ($data==null) {
     		return redirect()->back();
     	}
     	$data['category'] = BlogCategory::where('status','A')->orderBy('category','asc')->get(); 
     	return view('admin.modules.blogs.edit_blog',$data);
     }


     public function editBlog(Request $request)
     {
     	$data = Blog::where('id',$request->blog_id)->first();
     	$upd = [];
        $upd['category_id'] = $request->category_id;
        $upd['blog_title'] = $request->blog_title;
        $upd['blog_desc'] = $request->blog_description;
        $upd['meta_title'] = $request->meta_title;
        $upd['meta_desc'] = $request->meta_description;
        $upd['author_name'] = $request->author_name;
        $upd['slug'] = str_slug($request->blog_title).'-'.$request->blog_id;
        // if images-comes
        if ($request->hasFile('image')) {
            $image = $request->image;
     		$filename = time().'_'.$image->getClientOriginalName();
            $destinationPath = "storage/app/public/BlogImage/";
            $image->move($destinationPath, $filename);
            $upd['blog_pic'] = $filename; 
            ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/BigBlogImage/", 'dimension' => [1096,600], 'filename' =>$filename]);

            ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/SmallBlogImage/", 'dimension' => [370, 200], 'filename' =>$filename]);
            
            @unlink(storage_path('app/public/BlogImage/' . $data->blog_pic));
            @unlink(storage_path('app/public/BigBlogImage/' . $data->blog_pic));
            @unlink(storage_path('app/public/SmallBlogImage/' . $data->blog_pic));
      }

      $update = Blog::where('id', $request->blog_id)->update($upd);
      return redirect()->back()->with('success','Blog Updated Successfully');
	}


	public function status($id)
	{
		$blog = Blog::where('status', '!=', 'D')->where('id', $id)->first();
        if (@$blog) {
            if($blog->status=='I'){
                $upd['status'] = 'A';
                Blog::where('id', $blog->id)->update($upd);
                session()->flash('success', 'Blog  Activated Successfully');
            }
            if($blog->status=='A'){
                $upd['status'] = 'I';
                Blog::where('id', $blog->id)->update($upd);
                session()->flash('success', 'Blog  Deactivated Successfully');
            }
            return redirect()->back();
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
	}

   
   public function delBlog($id)
	{
		$blog = Blog::where('status', '!=', 'D')->where('id', $id)->first();
        if (@$blog) {
            $upd['status'] = 'D';
            Blog::where('id', $id)->update($upd);
            session()->flash('success', 'Blog  Deleted Successfully');
            return redirect()->back();
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
	}

   public function featured($id)
   {
    $blog = Blog::where('status', '!=', 'D')->where('id', $id)->first();
    if ($blog==null) {
        return redirect()->back();
    }
    if (@$blog->is_show=="Y") {
        $update = Blog::where('status', '!=', 'D')->where('id', $id)->update(['is_show'=>'N']);
        return redirect()->back()->with('success','Blog Removed From Homepage Successfully');
    }else{
        $update = Blog::where('status', '!=', 'D')->where('id', $id)->update(['is_show'=>'Y']);
        return redirect()->back()->with('success','Blog Added At Homepage Successfully');
    }
   } 
}
