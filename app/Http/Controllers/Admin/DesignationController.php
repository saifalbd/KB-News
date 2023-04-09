<?php

namespace App\Http\Controllers\Admin;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        
        $builder = Designation::query()->where(compact('user_id'));

        $items =$builder->paginate($request->perPage);

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
        $user_id = $request->user_id;
        $request->validate([
            'title'=>['required','string',Rule::unique(Designation::class,'title')->where('user_id',$user_id)]
        ]);
        $title = $request->title;
        $department = Designation::create(compact('user_id','title'));
        return response()->json($department);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        $user_id = $request->user_id;
        $request->validate([
            'title'=>['required','string',Rule::unique(Designation::class,'title')->where('user_id',$user_id)->ignore($designation->id)]
        ]);
        $title = $request->title;
        $designation->update(compact('title'));
        return response()->json($designation);
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
