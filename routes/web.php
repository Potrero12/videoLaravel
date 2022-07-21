<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// controlador de video
Route::get('/crear-video', [App\Http\Controllers\VideoController::class, 'createVideo'])
    ->name('video.create')
    ->middleware('auth');

Route::post('/guardar-video', [App\Http\Controllers\VideoController::class, 'saveVideo'])
    ->name('video.save')
    ->middleware('auth');

Route::get('/miniatura/{filename}', [App\Http\Controllers\VideoController::class, 'getImage'])
    ->name('video.getImage');

Route::get('/video/{video_id}', [App\Http\Controllers\VideoController::class, 'getVideoPage'])
     ->name('video.detail');

Route::get('/video-file/{filename}', [App\Http\Controllers\VideoController::class, 'getVideo'])
     ->name('video.getVideo');

Route::get('/delete-video/{video_id}', [App\Http\Controllers\VideoController::class, 'delete'])
     ->name('video.delete')
     ->middleware('auth');

Route::get('/editar-video/{video_id}', [App\Http\Controllers\VideoController::class, 'edit'])
     ->name('video.edit')
     ->middleware('auth');

Route::post('/update-video/{video_id}', [App\Http\Controllers\VideoController::class, 'update'])
     ->name('video.update')
     ->middleware('auth');

Route::get('/buscar/{search?}/{filter?}', [App\Http\Controllers\VideoController::class, 'search'])
     ->name('video.search');

// comentarios
Route::post('/comment', [App\Http\Controllers\CommentController::class, 'store'])
     ->name('comment.store')
     ->middleware('auth');

Route::get('/delete-comment/{comment_id}', [App\Http\Controllers\CommentController::class, 'delete'])
    ->name('comment.delete')
    ->middleware('auth');


// Usuasrios
Route::get('/channel/{user_id}', [App\Http\Controllers\UserController::class, 'channel'])
     ->name('user.channel');

// cache
Route::get('/clear-cache', function(){
     $code = Artisan::call('cache:clear');
});