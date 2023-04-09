<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasApiTokens, HasFactory, Notifiable;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_id',
        'status',
        'phone',
        'slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles() {

        return $this->belongsToMany(Role::class,'users_roles');
            
     }

     public function posts(){
        return $this->hasMany(Post::class,'author_id');
     }
   

 

    public function avatar(){
        return $this->belongsTo(Attachment::class,'avatar_id');
    }

    


    public function profile(){
        return $this->hasOne(Profile::class,'user_id');
    }
    public function personalInformation(){
        return $this->hasOne(PersonalInformation::class,'user_id');
    }

    public function emergencyContacts(){
        return $this->hasMany(EmergencyContact::class,'user_id');
    }

    public function getUrlAttribute()
    {
        return route('author',['author'=>$this->id]);
        
    }
    

  
    
}
