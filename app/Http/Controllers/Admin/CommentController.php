<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewComment;
use App\Events\RemoveComment;
use App\Http\Resources\CommentResource;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'model_type'=>['required','string'],
            'model_id'=>['required','numeric']
        ]);

        $commentable_id = $request->model_id;
        $commentable_type = $request->model_type;

      $items=  Comment::query()->where(compact('commentable_id','commentable_type'))->with(['replayes','user','attachments','reacts'])->where('parent_id',null)->get();

      $collection = CommentResource::collection($items);
      return response()->json($collection);
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
            'text' => ['required', 'string'],
            'parent_id'=>['nullable','numeric'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'numeric'],
            'attachments'=>['nullable','array'],
            'attachments.*'=>['required','image'],
        ]);
        $text = $request->text;
        $parent_id = $request->parent_id;
        $commentable_id = $request->model_id;
        $commentable_type =$request->model_type;
        $user_id = $request->user_id;
       
        $comment =  Comment::create(compact('commentable_id','commentable_type','parent_id','text','user_id'));

        $attachments = $request->attachments;

        if($attachments && count($attachments)){
            $comment->attachments()->delete();
            $list = array_map(function($file){return Attachment::add($file,Comment::class);},$attachments);
            $comment->attachments()->sync(collect($list)->pluck('id')->toArray());
        }

        if($parent_id){
            $name = 'reply'.'.'.$parent_id;
        }else{
            $name = $commentable_type.'.'.$commentable_id;
        }
      
       
        $comment->load(['replayes','user','attachments']);

        $item = (new CommentResource($comment))->toArray($request);
        broadcast(new NewComment($item,$name))->toOthers();
        //->toOthers()
        return response()->json($comment);
    }


    public function toggleLikes(Request $request,Comment $comment){
        $user = $request->user();
        $user_id = $user->id;
        $request->validate([
            'prop'=>['required','in:like,love,disLike,care,haha,wow,sad,angry']
        ]);
        $prop = $request->prop;
        $comment->toggleReact($user_id,$prop);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->attachments()->delete();
        
        $comment->delete();
        broadcast(new RemoveComment($comment->id))->toOthers();
    }
}
