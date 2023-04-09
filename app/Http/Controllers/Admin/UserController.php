<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\NotificationResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\BDPhone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = User::query()->with(['roles','avatar'])->whereNot('id',$request->user_id);
        $items = $builder->paginate($request->perPage);
        return response()->json($items);
    }


    public function notifications(Request $request){
        $user = User::find($request->user_id);
        $notifications = $user->unreadNotifications;
        $collection = NotificationResource::collection($notifications);
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
            'email' => ['required', 'email'],
            'name' => ['required', 'string'],
            'phone'=> ['required', 'numeric',new BDPhone,Rule::unique('users','phone')->whereNot('email',$request->email)],
            'roles'=>['required','array'],
            'roles.*'=>['required','numeric'],
            'password'=>['nullable','string']
        ]);

    
        $password = Hash::make($request->get('password',12345));
        $email = $request->email;
        $name = $request->name;
        $phone = $request->phone;
        $avatar_id = 1;
       $slug = Str::slug($name);
        $user =  User::firstOrCreate(compact('email'),compact( 'name', 'password', 'phone','avatar_id','slug'));

        $user->roles()->sync($request->roles);
        $user->load(['roles','avatar']);

        return response()->json($user);



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

    public function showByEmail(Request $request){
        $request->validate(['email'=>['required','email']]);
       $user =  User::query()->whereEmail($request->email)->with('roles')->first();
       return response()->json($user);
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
        //
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
