<?php

Route::get('/', function () {
    return view('index');
});
Route::get('/login',['as' => 'login', 'uses' => function() {
  return view('index');
}]);

Route::get('/home','HomeController@index');
Route::post('/login','LoginController@login');
