<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TagController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Tag::query();
        $items = $builder->paginate(100);
        return response()->json($items);
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
            'title'=>['required',Rule::unique('tags','title')],
            'slug'=>['required',Rule::unique('tags','slug')]
            ]);
    
            $title = Str::camel($request->title);
        $slug = make_slug($request->slug);
      $category =  Tag::create(compact('slug','title'));
      return response()->json($category);
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
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'title'=>['required',Rule::unique('tags')->whereNot('id',$tag->id)],
            'slug'=>['required',Rule::unique('tags','slug')->whereNot('id',$tag->id)]
            ]);
            $title = Str::camel($request->title);
            $slug = make_slug($request->slug);

        $tag->update(compact('title','slug'));
        return response()->json($tag);
        
    }

    public function popularChange(Request $request, Tag $category){
        $request->validate([
            'do'=>['required','in:0,1']
        ]);
        $is_popular = $request->do;
        $category->update(compact('is_popular'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
