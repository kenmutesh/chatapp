<?php

    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

   Route::prefix('/')->controller(MessageController::class)->group(function (){
       Route::get('user/{user}', 'byUser')->name('chat.user');
       Route::get('user/{group}', 'byGroup')->name('chat.group');
       Route::get('message/older/{message}', 'loadOlder')->name('message.loadOlder');

       Route::post('message', 'store')->name('message.store');
       Route::post('message/{message}', 'destroy')->name('message.destroy');
   });
    Route::get('/', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
