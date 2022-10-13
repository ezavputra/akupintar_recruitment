<?php
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::post('/carikampus', 'CariKampusController@carikampus');
Route::post('/jurusankampus', 'CariKampusController@jurusankampus');
Route::post('/jurusankampus_byname', 'CariKampusController@jurusankampus_byname');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/followkampus', 'CariKampusController@followkampus');
    Route::post('/followingkampus', 'CariKampusController@followingkampus');
    Route::post('/unfollowkampus', 'CariKampusController@unfollowkampus');
});
