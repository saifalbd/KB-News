<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Rules\ExistBy;
use App\Rules\UniqueBy;
use App\Rules\UniqueSkipBy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Category::query();
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
            'title'=>['required',Rule::unique('categories','title')],
            'slug'=>['required',Rule::unique('categories','slug')]
            ]);
    
        $title = $request->title;
        $slug = Str::slug($request->slug);
      $category =  Category::create(compact('slug','title'));
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
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title'=>['required',Rule::unique('categories')->whereNot('id',$category->id)],
            'slug'=>['required',Rule::unique('categories','slug')->whereNot('id',$category->id)]
            ]);
        $title = $request->title;
        $slug = make_slug($request->slug);
        $category->update(compact('title','slug'));
        return response()->json($category);
        
    }

    public function popularChange(Request $request, Category $category){
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
