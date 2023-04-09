<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Attachment extends Model
{
    protected $fillable = ['type','disk','path','sm_path','md_path','model'];

    protected $appends = ['url','sm_url','md_url','isImg'];

    protected static function booted()
    {
        static::deleting(function($model){
            $disk = Storage::disk($model->disk);
            $disk->delete($model->path);
        });
    }


    public function getSmUrlAttribute()
    {
        $disk = Storage::disk($this->disk);
        return $disk->url($this->sm_path);
    }
    

    public function getMdUrlAttribute()
    {
        $disk = Storage::disk($this->disk);
        return $disk->url($this->md_path);
    }

    public function getUrlAttribute()
    {
        $disk = Storage::disk($this->disk);
        return $disk->url($this->path);
    }
    

    public function getIsImgAttribute()
    {
        return Str::startsWith($this->type,'image');
    }
    public static function add(UploadedFile $file,string $model):Attachment{
        $model = class_basename($model);
       $type = $file->getClientMimeType();
       $ex = $file->getClientOriginalExtension();
       $disk = 's3';
       $slug = 'news-master';
       $uid = uniqid();
       $name = $uid.'.'.$ex;
       $path  =$slug.'/'.$name;
       $img = Image::make($file->path());
       $img->resize(875, 700, function ($const) {$const->aspectRatio();});

        Storage::disk($disk)->put($path,$img->encode());

       

       //small path

       $img = Image::make($file->path());
       $img->resize(500, 400, function ($const) {$const->aspectRatio();});
  
 

       $name = $uid.'-md.'.$ex;
       $md_path =$slug.'/'.$name;
     Storage::disk($disk)->put($md_path,$img->encode());


     
     $img = Image::make($file->path());
     $img->resize(125, 100, function ($const) {$const->aspectRatio();});
     $name = $uid.'-sm.'.$ex;
     $sm_path =$slug.'/'.$name;
   Storage::disk($disk)->put($sm_path,$img->encode());

       
      return static::create(compact('type','disk','path','sm_path','md_path','model'));
       
    }


    public function deleteWithAttach(){
        $disk = $this->disk;
        Storage::disk($disk)->delete([$this->path,$this->sm_path,$this->md_path]);
        $this->delete();
    }
}
