<?php

Route::get('/', function () {
    return view('index');
});
Route::get('/login',['as' => 'login', 'uses' => function() {
  return view('index');
}]);
Route::get('/home','HomeController@index') -> name('home');
Route::get('/allowance','AllowanceController@index') -> name('allowance');

Route::post('/login','LoginController@login');
