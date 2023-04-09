<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        
        $items = Department::query()->where(compact('user_id'))->paginate(10);

        return response()->json($items);
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
            'title'=>['required','string',Rule::unique(Department::class,'title')->where('user_id',$user_id)]
        ]);
        $title = $request->title;
        $department = Department::create(compact('user_id','title'));
        return response()->json($department);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $user_id = $request->user_id;
        $request->validate([
            'title'=>['required','string',Rule::unique(Department::class,'title')->where('user_id',$user_id)->ignore($department->id,'id')]
        ]);
        $title = $request->title;
        $department->update(compact('title'));
        return response()->json($department);
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
