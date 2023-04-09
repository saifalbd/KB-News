<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','is_popular'];


    protected $casts = [
        'is_popular' => 'bool',
    ];




    public function posts(){
        return $this->belongsToMany(Post::class,'post-category','category_id','post_id');
    }

    public function getUrlAttribute()
    {
        return route('category',['cat_slug'=>$this->slug]);
        
    }


    public function scopePopular(Builder $builder,$is_popular=true){
        return $builder->where('is_popular',$is_popular);
    }

    
}
