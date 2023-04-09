<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $fillable = ['author_id', 'avatar_id', 'title', 'slug', 'description', 'body', 'publish',
     'on_feature', 'on_home_top', 'on_popular', 'on_trending','show_author'];


    protected $casts = [
        'on_feature' => 'bool',
        'on_home_top' => 'bool',
        'on_popular' => 'bool',
        'on_trending' => 'bool',
        'publish' => 'bool',
        'show_author'=>'bool'
    ];


    public function avatar()
    {
        return $this->belongsTo(Attachment::class, 'avatar_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post-category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post-tag');
    }

    public function views(){
        return $this->hasMany(PostView::class,'post_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'post-attachment');
    }



    public function getUrlAttribute()
    {
        $category = $this->categories->first();

        $data = ['cat_slug' => $category->slug, 'post_id' => $this->id, 'slug' => $this->slug];
       
        return route('single', $data);
    }

    public function scopePublished(Builder $builder){
        return $builder->where('publish',true);
    }

    public function scopeHasCategory(Builder $builder,$category_id){
        return $builder->whereHas('categories',fn($c)=>$c->where('category_id',$category_id));
    }

    public function scopeList(Builder $builder){
        $builder->published()->with(['categories','attachments','avatar','author.avatar']);
    }
}
