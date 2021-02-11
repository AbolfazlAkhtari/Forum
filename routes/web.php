<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;

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
Auth::routes();

Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::get('/threads/{channel}', [ThreadController::class, 'index'])->name('threads.channel');
Route::get('/threads/{channel}/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');
Route::post('/threads/{thread}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');
Route::post('/replies/{reply}/favorites', [FavoriteController::class, 'store'])->name('replyFavorites.store');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('userProfile.show');


/** provides an easy way to save fake data in database */
Route::get('/seed', function (){
    $threads = \App\Models\Thread::factory()->count(50)->create();
    foreach ($threads as $thread) {
        \App\Models\Reply::factory()->count(10)->create(['thread_id' => $thread->id]);
    }
    return response('Database Seeded!', 200);
});
