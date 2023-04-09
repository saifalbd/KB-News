<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  
    public function index(){

        $recents = Post::query()->list()->paginate(10);
        $recents->withPath('/news');
        $features = Post::query()->where('on_feature',true)->list()->get();
        $home_tops = Post::query()->where('on_home_top',true)->list()->withCount('views')->get();
       
   
        $data = compact('home_tops','features','recents');
        return view('home',$data);
    }


    public function single(Request $request, Category $category,$post_id){
        $post = Post::findOrFail($post_id);
        $post->load(['categories','attachments','author.avatar','tags']);

        PostView::add($post,$request->ip());
    
        $relevantNews = Post::query()->published()->hasCategory($category->id)->select(['title','slug','id'])->latest()->limit(4)->get();
        $nextPost = Post::query()->select(['title','slug','id','avatar_id'])->with('avatar')->where('id',$post_id+1)->first();
        $prevPost = Post::query()->select(['title','slug','id','avatar_id'])->with('avatar')->where('id',$post_id-1)->first();
    
        return view('single_post',compact('category','post','relevantNews','nextPost','prevPost'));
    }


    public function category(Category $category){
        $posts  = $category->posts()->paginate(10);
        return view('category',compact('category','posts'));
    }

    public function tag(Tag $tag){
        $posts  = $tag->posts()->paginate(10);
        return view('tag',compact('tag','posts'));
    }



    public function news(Request $request){
        $posts  = Post::query()->paginate(10);
        return view('news',compact('posts'));
        
    }


    public function author(User $author){
       
        $posts = $author->posts()->where('show_author',true)->paginate(10);
        return view('author',compact('author','posts'));
    }

    public function search(Request $request){
     $request->validate(['title'=>['required','string']]);
     $title = $request->title;
     $posts = Post::query()->list()->where('title','LIKE',"%$title%")->paginate(10);
     return view('search',compact('posts'));

    }

}
