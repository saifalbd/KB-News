<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserOffline;
use App\Events\UserOnline;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttachResource;
use App\Http\Resources\AuthResource;
use App\Models\Attachment;
use App\Models\EmergencyContact;
use App\Models\User;
use App\Rules\BDPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->whereEmail($request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token-name');
            $token = $token->plainTextToken;
            $user->load('roles');

            $item = (new AuthResource($user))->toArray($request);

            return response()->json(['user' => $item, 'token' => $token], 200);
        } else {
            return response()->json([
                'message' => __('auth.failed'),
                'errors' => [
                    'loginEmail' => [__('auth.failed')],
                    'loginPassword' => [__('auth.failed')],
                ]
            ], 422);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email',Rule::unique('users')],
            'name' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
            'phone' => ['required', 'numeric', new BDPhone,Rule::unique('users')],
        ]);
        $password = Hash::make($request->password);
        $email = $request->email;
        $name = $request->name;
        $phone = $request->phone;
        $avatar_id = 1;
        $user =   User::create(compact('email', 'name', 'password', 'phone','avatar_id'));
        $item = new AuthResource($user);
        return response()->json($item);
    }

    public function uploadAvatar(Request $request)
    {

        if ($request->has('avatar')) {
            $request->validate(['avatar' => ['required', 'image']]);
            $avatar = $request->file('avatar');
            $img = Attachment::add($avatar, User::class);
            $avatar_id = $img->id;
        } else {
            $avatar = Attachment::query()->where('model', class_basename(User::class))->first();
            if ($avatar) {
                $avatar_id = $avatar->id;
            } else {
                $avatar_id = null;
            }

            $img = Attachment::find($avatar_id);
        }
        $user = $request->user();
        $user->update(compact('avatar_id'));
        $item = new AttachResource($img);
        return response()->json($item);
    }


    public function online(User $user)
    {


        $user->update(['status' => true]);
        broadcast(new UserOnline($user));
    }
    public function offline(User $user)
    {

        $user->update(['status' => false]);
        broadcast(new UserOffline($user));
    }


    public function profile(User $user){
        $user->load(['avatar','roles','profile','personalInformation','emergencyContacts']);
        return $user;
    }

    public function updateProfile(Request $request){
        $request->validate([
            'birth_date'=>['required','date'],
            'address'=>['required','string'],
            'gender'=>['required','string'],
        ]);

        $user = $request->user();
        $profile = $user->profile;
        $birth_date = Carbon::create($request->birth_date)->toDateString();
        $address = $request->address;
        $gender = $request->gender;
        $profile->update(compact('birth_date','address','gender'));
    
    }

    public function updatePersonalInformation(Request $request){
        $request->validate([
            'nationality'=>['required','string'],
            'religion'=>['required','string'],
            'marital_status'=>['required','string'],
        ]);
        $user = $request->user(); 

        $user->personalInformation->update($request->toArray());
    }

    public function emergencyContactUpdate(Request $request){
        $request->validate([
            'items'=>['required','array'],
            'items.*'=>['required','array'],
            'items.*.type'=>['required','string'],
            'items.*.name'=>['required','string'],
            'items.*.relationship'=>['required','string'],
            'items.*.phone'=>['required','string'],
        ]);
        $user = $request->user(); 

        $items = $request->items;
        $user_id = $request->user_id;

        foreach ($items as $item) {
            $type = $item['type'];
            $relationship = $item['relationship'];
            $phone = $item['phone'];
            $name = $item['name'];
            EmergencyContact::updateOrCreate(compact('type','user_id'),compact('relationship','phone','name'));
        }
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['message'=>'We have e-mailed your password reset link!']);
    }
}
