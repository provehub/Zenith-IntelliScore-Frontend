<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;



Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// 2 Your private‐channel rule
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return \App\Models\Chat::where('id', $chatId)
        ->where(function($q) use ($user) {
            $q->where('user1_id', $user->id)
              ->orWhere('user2_id', $user->id);
        })
        ->exists();
});

