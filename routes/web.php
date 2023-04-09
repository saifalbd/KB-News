<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Models\Chat;
use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use App\Service\DateConvert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/{any?}', function () {
    return view('admin.app');
})->where('any', '[\/\w\.-]*');


Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/search',[HomeController::class,'search'])->name('search');
Route::get('/news',[HomeController::class,'news'])->name('news');
Route::get('/author/{author}',[HomeController::class,'author'])->name('author');
Route::get('/home/{cat_slug}',[HomeController::class,'category'])->name('category');
Route::get('/tags/{tag_slug}',[HomeController::class,'tag'])->name('tag');
Route::get('/home/{cat_slug}/{post_id}',[HomeController::class,'single']);
Route::get('/home/{cat_slug}/{post_id}/{slug}',[HomeController::class,'single'])->name('single');





Route::get('check',function(){
    $rep = new DateConvert;
    $d = now();
   
    return $rep->convert($d,true);
});


