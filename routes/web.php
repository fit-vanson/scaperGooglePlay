<?php

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
    Route::post('/getIndex', [GooglePlayController::class,'getIndex'])->name('googleplay-get-index');
    Route::post('/getfollowAppIndex', [GooglePlayController::class,'getFollowAppIndex'])->name('googleplay-get-follow-appIndex');
    Route::post('/post', [GooglePlayController::class,'postIndex'])->name('googleplay-post-index');
    Route::get('/cron', [GooglePlayController::class,'cronApps'])->name('googleplay-cron-apps');
    Route::post('/followApp', [GooglePlayController::class,'followApp'])->name('googleplay-followApp');
    Route::post('/chooseApp', [GooglePlayController::class,'chooseApp'])->name('googleplay-chooseApp');
    Route::get('/unfollowApp', [GooglePlayController::class,'unfollowApp'])->name('googleplay-unfollowApp');
    Route::get('/detail', [GooglePlayController::class,'detailApp'])->name('googleplay-detailApp');
    Route::get('/detail-ajax', [GooglePlayController::class,'detailApp_Ajax'])->name('googleplay-detailApp-Ajax');

});
// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
