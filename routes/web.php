<?php

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

Route::match(['get', 'post'], '/', 'IndexController@execute')->name('home');
Route::get('page/{alias}', 'PageController@execute')->name('page');

Route::auth();

Route::prefix('admin')->middleware(['auth'])->group(function(){
    // admin
    Route::get('/', function(){

    });

    // admin/pages
    Route::prefix('pages')->group(function(){
        Route::get('/', 'PagesController@execute')->name('pages');
        // admin/pages/add
        Route::match(['get', 'post'], 'add', 'PagesAddController@execute')->name('pagesAdd');
        // admin/pages/edit
        Route::match(['get', 'post', 'delete'], 'edit/{page}', 'PagesEditController@execute')->name('pagesEdit');
    });

    Route::prefix('portfolio')->group(function(){
        Route::get('/', 'PortfolioController@execute')->name('portfolio');
        Route::match(['get', 'post'], 'add', 'PortfolioAddController@execute')->name('portfolioAdd');
        Route::match(['get', 'post', 'delete'], 'edit/{portfolio}', 'PortfolioEditController@execute')->name('portfolioEdit');
    });

    Route::prefix('services')->group(function(){
        Route::get('/', 'ServiceController@execute')->name('services');
        Route::match(['get', 'post'], 'add', 'ServiceAddController@execute')->name('serviceAdd');
        Route::match(['get', 'post', 'delete'], 'edit/{service}', 'ServiceEditController@execute')->name('serviceEdit');
    });
});