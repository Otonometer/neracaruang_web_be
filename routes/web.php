<?php

use Illuminate\Http\Request;

use League\Glide\ServerFactory;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;

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
Auth::routes(['register' => false]);

Route::get('set-pblsh',fn () => Artisan::call('publish:cron'));

Route::get('clear-cache', function () {
    // Artisan::call('schedule:run');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect('/dashboard');
});
Route::get('register', function () {
    return redirect('/');
});

Route::get('/dashboard', 'Webcore\HomeController@index')->name('dashboard');
Route::get('profile', 'Webcore\HomeController@profile')->name('profile');
Route::post('profile/submit', 'Webcore\HomeController@update_profile')->name('profile.submit');

Route::resource('permissiongroups', 'Webcore\PermissiongroupController');
Route::resource('permissions', 'Webcore\PermissionController');
Route::resource('roles', 'Webcore\RoleController');
Route::post('users/permissions', 'Webcore\UserController@permissions')->name('users.permissions');
Route::resource('users', 'Webcore\UserController');
Route::resource('moderators', 'Webcore\ModeratorController');


Route::resource('pageTypes', 'PageTypeController');
// Route::post('importPageType', 'PageTypeController@import');

Route::get('contents/create/{contentTypeSlug}', 'ContentController@create')->name('contents.create');
Route::get('contents/{contentTypeSlug}', 'ContentController@index')->name('contents.index');
Route::get('contents/{id}/show', 'ContentController@show')->name('contents.show');
Route::delete('content-media/{id}', 'ContentController@deleteMedia')->name('contents.delete-media');
Route::resource('contents', 'ContentController')->except(['create','index','show']);
// Route::post('importContent', 'ContentController@import');

Route::resource('provinces', 'ProvinceController');
// Route::post('importProvince', 'ProvinceController@import');

Route::resource('cities', 'CityController');
// Route::post('importCity', 'CityController@import');

Route::resource('icons', 'IconController');
// Route::post('importIcon', 'IconController@import');

Route::resource('categories', 'CategoryController');
// Route::post('importCategory', 'CategoryController@import');

Route::resource('tags', 'TagController');
// Route::post('importTag', 'TagController@import');

Route::resource('ads', 'AdController');
// Route::post('importAd', 'AdController@import');


Route::resource('discussions', 'DiscussionController');
// Route::post('importDiscussion', 'DiscussionController@import');

Route::resource('discussionSuggestions', 'DiscussionSuggestionController');
// Route::post('importDiscussionSuggestion', 'DiscussionSuggestionController@import');

Route::resource('writer', 'WriterController');

Route::resource('socialMedia', 'SocialMediaController');
// Route::post('importSocialMedia', 'SocialMediaController@import');

Route::resource('notification', 'NotificationController');

Route::resource('ebook', 'EBookController');

Route::resource('metas', 'MetaController');
// Route::post('importMeta', 'MetaController@import');
