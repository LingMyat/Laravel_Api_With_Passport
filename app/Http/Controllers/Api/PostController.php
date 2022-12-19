<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostListResource;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request){
        $query = Post::with('user','category','image')->orderBy('id','desc');
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

    public function create(PostRequest $request){
        DB::beginTransaction();
        try {
            $media = [];
            $requestData = $request->only('title','description','category_id');
            $requestData['user_id']=auth()->id();

            $post = Post::create($requestData);
            if ($request->hasFile('image')) {
                $name = uniqid().'-'.date('Y-m-d-H-i-s').'.'.$request->file('image')->getClientOriginalExtension();
                Storage::put(Post::UPLOAD_PATH.$name, file_get_contents($request->file('image')));
                $media = Media::create([
                    'file_name'=>'storage/'.Post::UPLOAD_PATH.$name,
                    'file_type'=>'image',
                    'model_id'=>$post->id,
                    'model_type'=>Post::class
                ]);
            }
            DB::commit();
            $data = [new PostResource($post),$media];
        return ResponseHelper::success($data,'Successfully uploaded');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::fail($e->getMessage());
        }
    }

    public function show($id){
        $posts = Post::with('user','category','image')->all();
        $postIds = [];
        foreach ($posts as $post) {
            array_push($postIds,$post->id);
        }
        if (in_array($id,$postIds)) {
            $post = Post::findOrFail($id);
            return ResponseHelper::success(new PostDetailResource($post));
        }
        return ResponseHelper::fail('Post Not Found');

    }
}
