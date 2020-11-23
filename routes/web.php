<?php

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
//User Routes
Route::get('/',function(){
    return redirect(app()->getLocale());
});
Route::group(['namespace'=> 'User','prefix'=>'{locale}','where'=>['locale'=>'[a-zA-Z]{2}','middleware'=>'setlocale']],function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('post', 'PostController@allpost')->name('allpost');
    Route::get('post/{post}', 'PostController@post')->name('post');
    Route::get('tag/{tag}', 'PostController@tag')->name('tag');
    Route::get('category/{category}', 'PostController@category')->name('category');
    Route::get('post/{year}/{month}', 'PostController@date')->name('date');
    Route::get('/search','SearchController@search')->name('search');
    Route::get('profile/{username}','AuthorController@profile')->name('profile');
});
//Admin Routes
Route::get('admin-login','Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin-login','Admin\Auth\LoginController@login');

Route::group(['namespace'=> 'Admin','middleware'=>'auth:admin'],function(){
    Route::get('admin/home','HomeController@index')->name('admin.home');
    //Users Routes
    Route::resource('admin/user', 'UserController');
    //Post Routes
    Route::resource('admin/post', 'PostController');
    Route::get('changeStatus','PostController@changeStatus');
    Route::get('postselect', 'PostController@postselect');
    Route::post('admin/upload', 'PostController@upload')->name('post.upload');
    //Tag Routes
    Route::resource('admin/tag', 'TagController');
    //Category Routes
    Route::resource('admin/category', 'CategoryController');
    //Comment Routes
    Route::resource('admin/comment', 'CommentController');
    //user Routes
    Route::resource('admin/user', 'UserController');
    //subadmin Routes
    Route::resource('admin/subadmin', 'AuthorController');
    Route::get('changeStatuss','AuthorController@changeStatus');
    //Roles Routes
    Route::resource('admin/role', 'RoleController');
    //Permission Routes
    Route::resource('admin/permission', 'PermissionController');
    //Profile Rotes
    Route::get('admin/settings','ProfileController@index')->name('settings');
    Route::put('profile-update','ProfileController@updateProfile')->name('profile.update');
    Route::put('password-update','ProfileController@updatePassword')->name('passwords.update');
    //logout
    Route::post('/logout','Auth\LoginController@logout')->name('admin.logout');
});
Route::group(['prefix'=>'{locale}','where'=>['locale'=>'[a-zA-Z]{2}','middleware'=>'setlocale']],function(){
    Auth::routes();
    Route::get('/settings','Auth\SettingController@index')->name('user.setting');
});

Route::group(['middleware'=>['auth'],'prefix'=>'{locale}','where'=>['locale'=>'[a-zA-Z]{2}','middleware'=>'setlocale']], function (){
    Route::post('favorite/{post}/add','User\FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}','User\CommentController@store')->name('comment.store');
    Route::post('reply/{post}','User\ReplyController@store')->name('reply.store');
    Route::post('/logout','Auth\LoginController@logout')->name('logout');
    Route::put('profile-update','Auth\SettingController@updateProfile')->name('user.profile.update');
    Route::put('password-update','Auth\SettingController@updatePassword')->name('user.passwords.update');
    
 });

 View::composer('user.layouts.footer',function ($view) {
    $categories = App\Model\user\category::where('language',session('locale'))->get();
    $popular_posts = App\Model\user\post::where(['status'=>1,'language'=>session('locale')])
    ->withCount('comments')
    ->withCount('favorite_post')
    ->orderBy('view_count', 'desc')
    ->orderBy('comments_count', 'desc')
    ->orderBy('favorite_post_count', 'desc')
    ->orderBy('created_at', 'desc')
    ->take(5)->get();
    $view->with(['categories'=>$categories,'popular_posts'=>$popular_posts]);
});