<?php

use App\Http\Controllers\AppGalleryController;
use App\Http\Controllers\GooglePlayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;

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

// Main Page Route
// Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('verified');
Route::get('/', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics');

Auth::routes(['verify' => true]);

/* Route Dashboards */
Route::group(['prefix' => 'dashboard'], function () {
    Route::group(['prefix' => 'analytics'], function () {
        Route::get('/', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');
        Route::get('/post-analytics', [DashboardController::class, 'analytics'])->name('dashboard-post-analytics');
    });
});
/* Route Dashboards */


/* Route GooglePlay */

Route::group(['prefix' => 'googleplay'], function () {
    Route::get('/', [GooglePlayController::class,'index'])->name('googleplay-index');
    Route::get('/follow-app', [GooglePlayController::class,'followAppIndex'])->name('googleplay-follow-app');
    Route::get('/package', [GooglePlayController::class,'package'])->name('googleplay-package');
    Route::get('/filter_app_list', [GooglePlayController::class,'filter_app_list'])->name('googleplay-filter-app-list');
    Route::post('/get-filter_app_list', [GooglePlayController::class,'get_filter_app_list'])->name('googleplay-get-filter-app-list');
    Route::post('/post-filter_app_list', [GooglePlayController::class,'post_filter_app_list'])->name('googleplay-post-filter-app');
    Route::post('/getIndex', [GooglePlayController::class,'getIndex'])->name('googleplay-get-index');
    Route::post('/getfollowAppIndex', [GooglePlayController::class,'getFollowAppIndex'])->name('googleplay-get-follow-appIndex');
    Route::post('/post', [GooglePlayController::class,'postIndex'])->name('googleplay-post-index');
    Route::get('/cron', [GooglePlayController::class,'cronApps'])->name('googleplay-cron-apps');
    Route::post('/followApp', [GooglePlayController::class,'followApp'])->name('googleplay-followApp');
    Route::post('/chooseApp', [GooglePlayController::class,'chooseApp'])->name('googleplay-chooseApp');
    Route::get('/unfollowApp', [GooglePlayController::class,'unfollowApp'])->name('googleplay-unfollowApp');
    Route::get('/detail', [GooglePlayController::class,'detailApp'])->name('googleplay-detailApp');
    Route::get('/detail-ajax', [GooglePlayController::class,'detailApp_Ajax'])->name('googleplay-detailApp-Ajax');
    Route::POST('/change-note', [GooglePlayController::class,'changeNote'])->name('googleplay-change-note');
});

Route::group(['prefix' => 'appgallery'], function () {
    Route::get('/', [AppGalleryController::class,'index'])->name('appgallery-index');
    Route::get('/follow-app', [AppGalleryController::class,'followAppIndex'])->name('appgallery-follow-app');
    Route::get('/package', [AppGalleryController::class,'package'])->name('appgallery-package');
    Route::get('/filter_app_list', [AppGalleryController::class,'filter_app_list'])->name('appgallery-filter-app-list');
    Route::post('/get-filter_app_list', [AppGalleryController::class,'get_filter_app_list'])->name('appgallery-get-filter-app-list');
    Route::post('/post-filter_app_list', [AppGalleryController::class,'post_filter_app_list'])->name('appgallery-post-filter-app');
    Route::post('/getIndex', [AppGalleryController::class,'getIndex'])->name('appgallery-get-index');
    Route::post('/getfollowAppIndex', [AppGalleryController::class,'getFollowAppIndex'])->name('appgallery-get-follow-appIndex');
    Route::get('/post', [AppGalleryController::class,'postIndex'])->name('appgallery-post-index');
    Route::get('/cron', [AppGalleryController::class,'cronApps'])->name('appgallery-cron-apps');
    Route::post('/followApp', [AppGalleryController::class,'followApp'])->name('appgallery-followApp');
    Route::post('/chooseApp', [AppGalleryController::class,'chooseApp'])->name('appgallery-chooseApp');
    Route::get('/unfollowApp', [AppGalleryController::class,'unfollowApp'])->name('appgallery-unfollowApp');
    Route::get('/detail', [AppGalleryController::class,'detailApp'])->name('appgallery-detailApp');
    Route::get('/detail-ajax', [AppGalleryController::class,'detailApp_Ajax'])->name('appgallery-detailApp-Ajax');
    Route::POST('/change-note', [AppGalleryController::class,'changeNote'])->name('appgallery-change-note');
});
// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
