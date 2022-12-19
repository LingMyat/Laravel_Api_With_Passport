<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','description','category_id','user_id'
    ];

    public const UPLOAD_PATH = 'upload/posts/';

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image(){
        // return $this->morphMany(Media::class,'model');
        return $this->morphOne(Media::class,'model');
    }
}
