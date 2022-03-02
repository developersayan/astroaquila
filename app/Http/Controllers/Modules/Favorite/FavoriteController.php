<?php

namespace App\Http\Controllers\Modules\Favorite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\AddToFavorite;
use App\Models\Products;
class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : addFavorite
     *   Description : user Add Favorite
     *   Author      : Soumojit
     *   Date        : 2021-AUG-23
     **/
    public function addFavorite($id = null){
        $is_product = Products::where('id',$id)->first();
        if($is_product==null){
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
        $check = AddToFavorite::where('user_id',auth()->user()->id)->where('product_id',$id)->first();
        if($check){
            AddToFavorite::where('user_id',auth()->user()->id)->where('product_id',$id)->delete();
            session()->flash('success', 'Product remove form wish list');
            return redirect()->back();
        }
        $ins=[];
        $ins['user_id']=auth()->user()->id;
        $ins['product_id']=$id;
        AddToFavorite::create($ins);
        session()->flash('success', 'Product added to wish list');
        return redirect()->back();
    }
    /**
     *   Method      : favoriteList
     *   Description : user favorite List
     *   Author      : Soumojit
     *   Date        : 2021-AUG-23
     **/
    public function favoriteList(){

        $favoriteList= AddToFavorite::where('user_id',auth()->user()->id)->paginate(10);
        $data['allFavorite']=$favoriteList;
        return view('modules.favorite.favorite')->with($data);
    }

}
