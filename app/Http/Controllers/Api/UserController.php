<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostListResource;

class UserController extends Controller
{
    //
    public function profile(){
        $user = auth()->guard()->user();
        return ResponseHelper::success(new ProfileResource($user));
    }

    public function posts(Request $request){
        $query = Post::with('user','category','image')->orderBy('id','desc')->where('user_id',auth()->id());
        if ($request->category_id) {
           $query->where('category_id',$request->category_id);
        }
        if ($request->search) {
            $query->where(function($q1) use($request){
                $q1->where('title','like',"%$request->search%")
                    ->orWhere('description','like',"%$request->search%");
            });
        }
        $posts = $query->paginate(10);
        // return ResponseHelper::success(PostListResource::collection($posts));
        return PostListResource::collection($posts)->additional(['message'=>'success']);
    }

    public function categories(){
        $categories = Category::orderBy('name')->get();
        return ResponseHelper::success(CategoryResource::collection($categories));
    }
}
