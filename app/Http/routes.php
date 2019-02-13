<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Home page
Route::get('/', 'ConvertNumberIndexController@index');
Route::get('/convertCurrency', 'ConvertNumberIndexController@generateConvertCurrency');
Route::get('/{inputNumber}-numbers', 'ConvertNumberIndexController@inputNumberUrl');
Route::get('/numberMobile', 'ConvertNumberIndexController@numberMobile');
Route::get('/sitemap.xml', 'SitemapController@index');
Route::get('/sitemap/keywords_{page}.xml', 'SitemapController@keywords');
Route::get('/insertToDB', 'SitemapController@insertToDB');
