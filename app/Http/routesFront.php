<?php

Route::get('/test/{ok}', 'Controller@test1');

Route::get('/posts', function() {
    $posts = App\Models\Post::with('translation')->get();

    return view('front.posts', compact('posts'));
});
