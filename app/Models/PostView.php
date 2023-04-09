<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    protected $fillable = ['post_id','ip_address'];


    public static function add(Post $post,$ip_address){
        $post_id = $post->id;
   static::firstOrCreate(compact('post_id','ip_address'));
    }
}
