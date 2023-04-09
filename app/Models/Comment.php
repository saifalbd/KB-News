<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'parent_id', 'user_id', 'react_count', 'commentable_id', 'commentable_type'];

    protected $with = ['replayes', 'user'];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->replayes()->delete();
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replayes()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachale');
    }

    public function  reacts()
    {
        return $this->hasMany(CommentReact::class,'comment_id');
    }


    public function canReact($user_id){
        return $this->reacts()->where(compact('user_id'))->first();
    }


    public function toggleReact($user_id,$prop){
        $can = $this->canReact($user_id);
        if($can){
            $canProp = $can->prop;
            if($canProp == $prop){
                $can->delete();
                $this->decrement('react_count');
            }else{
                $can->prop = $prop;
                $can->save();
            }
        }else{
            $this->reacts()->create(compact('user_id','prop'));
            $this->increment('react_count');
        }

    }
}
