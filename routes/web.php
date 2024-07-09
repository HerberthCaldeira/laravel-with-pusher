<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/chat', \App\Livewire\Chat::class)->name("chat.livewire");

Route::get('/trigger', function () {
    \App\Events\DoSomethingEvent::dispatch(auth()->user());
    return true;
});

Route::get('/pusher-api', function () {

    $pusher =  new \Pusher\Pusher(
        env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
        array('cluster' =>  env('PUSHER_APP_CLUSTER'))
    );

    //$response = $pusher->get('/channels');
    //$response = $pusher->get('/channels/presence-chat');
    $response = $pusher->get('/channels/presence-chat/users');

    return $response;
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
