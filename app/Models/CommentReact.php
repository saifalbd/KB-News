<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CommentReact extends Model
{

    public $timestamps = false;
    protected $fillable = ['user_id','comment_id','prop'];

    public function user(){
        return $this->belongsTo(User::class,'user_id')->select(['id','name']);
    }


   
}
