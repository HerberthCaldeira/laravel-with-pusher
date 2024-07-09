<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('public', function (){
    return true;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    return $user->toArray();
});
