<?php

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EBookController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\SocialMediaController;
use App\Http\Controllers\Api\DiscussionApiController;
use App\Http\Controllers\Api\EBookApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('login', 'Api\AuthAPIController@login')->name('login');
Route::post('register', 'Api\AuthAPIController@register')->name('register');
Route::post('forgot-password', 'Api\AuthAPIController@sentEmailResetPassword')->name('forgot-password');
Route::post('reset-password', 'Api\AuthAPIController@resetPassword')->name('reset-password');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('check-user', 'Api\AuthAPIController@checkUser')->name('check-user');
    Route::post('update-profile', 'Api\AuthAPIController@updateProfile')->name('update-profile');
    Route::post('update-password', 'Api\AuthAPIController@updatePassword')->name('update-password');

    // Content Comment
    Route::post('post-comment/{content_id}', 'Api\ContentCommentAPIController@postComment')->name('post-comment');
    Route::post('reply-comment/{content_id}/{parent_id}', 'Api\ContentCommentAPIController@replyComment')->name('reply-comment');

    Route::middleware(['throttle:likes'])->group(function ()
    {
        Route::post('like', 'Api\ContentCommentAPIController@like')->name('like');
    });
});

// Route::get('/home', function ()
// {
//     return response()->json(['data' => new LandingPageResource()]);
// })->name('home');

// Content Comment
Route::get('get-comment/{content_id}', 'Api\ContentCommentAPIController@getComment')->name('get-comment');

// Website
Route::get('get-ads/{slug}', 'Api\AdsAPIController@getAds')->name('get-ads');

// Location
Route::get('provinces','Api\LocationApiController@getProvince');
Route::get('cities','Api\LocationApiController@getCityByProvince');
Route::get('cities/{province_id}','Api\LocationApiController@getCityByProvince');

// Discussion
Route::get('discussion-suggests','Api\DiscussionApiController@getDiscussionSuggestion');
Route::post('discussion-suggests','Api\DiscussionApiController@storeDiscussionSuggestion');
Route::get('discussion-archives','Api\DiscussionApiController@getArchiveDiscussion');
Route::get('discussion-archives/{slug}','Api\DiscussionApiController@getArchiveDiscussionDetail');
Route::get('discussions','Api\DiscussionApiController@getDiscussion');
Route::get('discussions/{slug}','Api\DiscussionApiController@getDiscussionDetail');
// Route::get('discussions-like/{id}','Api\DiscussionApiController@likeDiscussion');
Route::get('discussion-comment-paginate/{discussion_id}', 'Api\DiscussionCommentController@commentPaginate')->name('discussions.comment');
Route::post('discussion/comment/{discussion_id}', 'Api\DiscussionCommentController@comment')->name('discussions.comment');
Route::post('discussion/reply/{discussion_id}/{parent_id}', 'Api\DiscussionCommentController@reply')->name('discussions.reply');
Route::post('discussion-read/{slug}', [DiscussionApiController::class,'read']);

Route::prefix('content')->group(function () {
    Route::get('/', [ContentController::class,'index']);
    Route::group(['prefix' => '{slug}'],function ()
    {
        Route::get('/', [ContentController::class,'show'])->name('api.content.show');
        Route::get('/comments', [ContentController::class,'getComment'])->name('api.content.comments');
        Route::get('/{location}', [ContentController::class,'show'])->name('api.content.show');
        Route::post('/reads', [ContentController::class,'readContent'])->name('api.content.read');
    });
    Route::get('/replies-comment/{id}',[ContentController::class,'getReplies'])->name('api.content.replies-comment');
});

Route::get('/similar/{slug}',[ContentController::class,'getSimilarContent']);

Route::get('/tags',function ()
{
    $tags = Tag::select(['id','category_id','title','slug'])->get()->groupBy(fn($tag,$key) => Str::snake($tag->category_name));

    return response()->json(['tags' => $tags]);
});

Route::get('social-medias', [SocialMediaController::class,'getSocialMedia']);

Route::get('ebooks', [EBookApiController::class, 'getEbooks']);
