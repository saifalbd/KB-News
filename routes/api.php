<?php

use App\Http\Controllers\Admin\{AuthController,CategoryController,ContactController,DepartmentController,DesignationController,
HomeController,
PostController, TagController, UserController};
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UtilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::put('/online/{user}',[AuthController::class,'online'])->name('online');
Route::put('/offline/{user}',[AuthController::class,'offline'])->name('offline');
Route::post('/forget-password',[AuthController::class,'submitForgetPasswordForm'])->name('forgetPassword');

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/profile/{user}',[AuthController::class,'profile'])->name('profile');
    Route::put('/update-profile',[AuthController::class,'updateProfile'])->name('updateProfile');
    Route::put('/update-personal-information',[AuthController::class,'updatePersonalInformation'])->name('updatePersonalInformation');
    Route::put('/update-emergency-contact',[AuthController::class,'emergencyContactUpdate'])->name('emergencyContactUpdate');
    
    
    /**Start UtilityController */
    Route::get('/dropdowns/{slug}',[UtilityController::class,'dropdowns'])->name('dropdown');
    /**End UtilityController */
    

    Route::get('/notifications',[UserController::class,'notifications'])->name('notification');
    Route::put('/mark-as-read-notify/{id}',[UtilityController::class,'markAsReadNotify'])->name('markAsReadNotify');
    Route::put('/category-popular/{category}',[CategoryController::class,'popularChange'])->name('category.popularChange');
    Route::apiResource('/category',CategoryController::class)->names('category');
    Route::put('/tag-popular/{tag}',[TagController::class,'popularChange'])->name('tag.popularChange');
    Route::apiResource('/tags',TagController::class)->names('tag');
    Route::post('/avatar',[AuthController::class,'uploadAvatar'])->name('avatar');
    Route::get('/users/by-email',[UserController::class,'showByEmail'])->name('user.showByEmail');
   

    Route::apiResource('/users',UserController::class)->names('user');

    Route::apiResource('/contacts',ContactController::class)->names('contact');

    Route::apiResource('/departments',DepartmentController::class)->only(['index','store','update','destroy'])->names('department');
    Route::apiResource('/designations',DesignationController::class)->only(['index','store','update','destroy'])->names('designation');


    Route::put('/post-avatar-change/{post}',[PostController::class,'changeAvatar'])->name('post.changeAvatar');
    Route::put('/post-change-config/{post}',[PostController::class,'changeConfig'])->name('post.changeConfig');
    Route::post('/posts-update/{post}',[PostController::class,'update'])->name('post.update');
    Route::apiResource('/posts',PostController::class)->names('post')->except('update');
    




    // Route::post('/comments/{comment}/toggle-likes',[CommentController::class,'toggleLikes'])->name('comment.toggleLike');
    // Route::apiResource('/comments',CommentController::class)->names('comment');


//changeStatus


  
    
});
