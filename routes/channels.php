<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('video', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});
Broadcast::channel('comment.{type}.{id}', function ($user,$type,$id) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});
Broadcast::channel('commentRemove.{id}', function ($user,$id) {
    return true;
});

Broadcast::channel('chat', function ($user) {
    
    return $user;
});

Broadcast::channel('chatread.{id}', function ($user,$id) {
    
  
  
    $user_id = $user->id;
    $chat = DB::table('chats')->select(['id','sender_id'])->where('id',$id)->first();
   
    $sender_id = $chat->sender_id;


    if($user_id == $sender_id){
        return true;
      return  [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }else{
        return false;
    }
});




