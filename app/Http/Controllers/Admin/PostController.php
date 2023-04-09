<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $posts = Post::query()->with(['categories','attachments','author.avatar'])->get();
    return $posts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         

    $request->validate([
        'title'=>['required','string'],
        'body'=>['required','string'],
        'categories'=>['required','array'],
        'categories.*'=>['required','numeric'],
        'attachments'=>['required','array'],
        'attachments.*'=>['required','image'],
        'description'=>['nullable','string','max:360'],
        'on_feature'=>['required','in:0,1'],
        'on_home_top'=>['required','in:0,1'],
        'on_popular'=>['required','in:0,1'],
        'on_trending'=>['required','in:0,1'],
        'tags'=>['nullable','array'],
        'tags.*'=>['required','string']
    ]);

    $author_id = $request->user_id;
    $title  = $request->title;
    $body = $request->body;
    $categories = $request->categories;
    $attachments = $request->attachments;
    $on_feature = $request->on_feature;
    $on_home_top = $request->on_home_top;
    $on_popular = $request->on_popular;
    $on_trending = $request->on_trending;
    $description = $request->description;

    $slug = make_slug($title);


    $tagList = $request->get('tags',[]);

    $tags = array_map(function($title){
        $title = Str::camel($title);
        $can  = Tag::query()->where('title',$title)->first();
        if(!$can){
            $slug = Str::slug($title);
            $can = Tag::create(compact('title','slug'));
        }
        return $can->id;
    },$tagList);


    $avatar_id = 1;
   $post =  Post::create(compact('title','description','body','avatar_id','slug','author_id','on_feature','on_home_top','on_popular','on_trending'));
   $post->categories()->sync($categories);
   $post->tags()->sync($tags);

   $attachIdList = [];
   foreach ($attachments as $image) {
   $img =  Attachment::add($image,Post::class);
   array_push($attachIdList,$img->id);
   }

   $post->update(['avatar_id'=>$attachIdList[0]]);

   $post->attachments()->sync($attachIdList);
   return response()->json(['message'=>'sucesss']);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load(['categories','attachments','tags','author.avatar']);

        return response()->json($post);
    }

  


    public function changeConfig(Request $request,Post $post){
        $request->validate([
            'col'=>['required','string'],
            'do'=>['required','in:0,1']
        ]);
   

        $post->update([$request->col=>!!$request->do]);
    }

    public function changeAvatar(Request $request,Post $post){
        $request->validate([
            'id'=>['required','numeric'],
        ]);
   

        $post->update(['avatar_id'=>$request->id]);
    }



    public static function removeAttachments(Post $post){
        $post->attachments()->get()->each(function($attach){
            $attach->deleteWithAttach();
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>['required','string'],
            'body'=>['required','string'],
            'categories'=>['required','array'],
            'categories.*'=>['required','numeric'],
            'attachments'=>['nullable','array'],
            'attachments.*'=>['required','image'],
            'description'=>['nullable','string','max:360'],
            'on_feature'=>['required','in:0,1'],
            'on_home_top'=>['required','in:0,1'],
            'on_popular'=>['required','in:0,1'],
            'on_trending'=>['required','in:0,1'],
            'tags'=>['nullable','array'],
            'tags.*'=>['required','string']
        ]);


        
        $title  = $request->title;
        $body = $request->body;
        $categories = $request->categories;
        $attachments = $request->attachments;
        $on_feature = $request->on_feature;
        $on_home_top = $request->on_home_top;
        $on_popular = $request->on_popular;
        $on_trending = $request->on_trending;
        $description = $request->description;
    
        $slug = make_slug($title);
    
    
        $tagList = $request->get('tags',[]);
    
        $tags = array_map(function($title){
            $title = Str::camel($title);
            $can  = Tag::query()->where('title',$title)->first();
            if(!$can){
                $slug = Str::slug($title);
                $can = Tag::create(compact('title','slug'));
            }
            return $can->id;
        },$tagList);
    
    
        $avatar_id = $post->avatar_id;
       $post->update(compact('title','description','body','avatar_id','slug','on_feature','on_home_top','on_popular','on_trending'));
       $post->categories()->sync($categories);
       $post->tags()->sync($tags);
    
       if($attachments && count($attachments)){
        static::removeAttachments($post);
        $attachIdList = [];
        foreach ($attachments as $image) {
        $img =  Attachment::add($image,Post::class);
        array_push($attachIdList,$img->id);
        }
        $post->update(['avatar_id'=>$attachIdList[0]]);
        $post->attachments()->sync($attachIdList);
       }
     

       return response()->json(['message'=>'sucesss']);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $post->delete();
        static::removeAttachments($post);
    }
}
