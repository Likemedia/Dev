<?php

Route::get('/auth/login', 'Auth\CustomAuthController@login');
Route::post('/auth/login', 'Auth\CustomAuthController@checkLogin');
Route::get('/auth/register', 'Auth\CustomAuthController@register');
Route::post('/auth/register', 'Auth\CustomAuthController@checkRegister');
Route::get('/auth/logout', 'Auth\CustomAuthController@logout');


Route::group(['prefix' => 'back', 'middleware' => 'auth'], function () {

    Route::get('/set-language/{lang}', 'LanguagesController@set')->name('set.language');

    Route::get('/', function() {
        return view('admin.welcome');
    });

    Route::get('/users', 'Admin\AdminUserController@index');

    Route::resource('/pages', 'Admin\PagesController');
    Route::patch('/pages/{id}/change-status', 'Admin\PagesController@status')->name('pages.change.status');

    Route::resource('/modules', 'Admin\ModulesController');
    Route::post('/modules/changePosition', 'Admin\ModulesController@changePosition');

    Route::resource('submodules', 'Admin\SubModulesController');

    Route::resource('/forms', 'Admin\FormsController');

    Route::resource('/categories', 'Admin\CategoriesController');
    Route::post('/categories/move/posts', 'Admin\CategoriesController@movePosts')->name('categories.move.posts');
    Route::post('/categories/change', 'Admin\CategoriesController@change')->name('categories.change');
    Route::post('/categories/part', 'Admin\CategoriesController@partialSave')->name('categories.partial.save');
    Route::post('/categories/move/posts_', 'Admin\CategoriesController@movePosts_')->name('categories.move.posts_');
    Route::post('/categories/part', 'Admin\CategoriesController@partialSave')->name('categories.partial.save');

    Route::resource('/menus', 'Admin\MenusController');
    Route::post('/menus/move/posts', 'Admin\MenusController@movePosts')->name('menus.move.posts');
    Route::post('/menus/change', 'Admin\MenusController@change')->name('menus.change');
    Route::post('/menus/part', 'Admin\MenusController@partialSave')->name('menus.partial.save');
    Route::post('/menus/move/posts_', 'Admin\MenusController@movePosts_')->name('menus.move.posts_');
    Route::post('/menus/part', 'Admin\MenusController@partialSave')->name('menus.partial.save');
    Route::post('/menus/categories/assignment', 'Admin\MenusController@assignmentCategory')->name('menus.assignment.category');

    Route::resource('/tags', 'Admin\TagsController');

    Route::resource('/posts', 'Admin\PostsController');
    Route::get('/posts/category/{category}', 'Admin\PostsController@getPostsByCategory')->name('posts.category');

    Route::group(['prefix' => 'settings'], function () {

        Route::resource('/languages', 'Admin\LanguagesController');
        Route::patch('/languages/set-default/{id}', 'Admin\LanguagesController@setDefault')->name('languages.default');

        Route::get('/reviews', 'Admin\PostsRatingController@index')->name('reviews.index');
        Route::patch('/reviews', 'Admin\PostsRatingController@update')->name('reviews.update');
    });
});

$prefix = session('applocale');
$lang = App\Models\Lang::where('default', 1)->first();

echo $prefix;
echo "<br>";

if ($prefix == $lang->lang) {
    echo "default";
    require_once(__DIR__.'/routesFront.php');
}else{
    echo "also";
    Route::group(['prefix' => $prefix], function() {
        require_once(__DIR__.'/routesFront.php');
    });
}
