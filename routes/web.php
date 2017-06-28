<?php

Route::get('/', function () {
    return view('index');
});
Route::get('/login',['as' => 'login', 'uses' => function() {
  return view('index');
}]);
Route::get('/home','HomeController@index') -> name('home');
Route::get('/allowance','AllowanceController@index') -> name('allowance');
Route::get('/allowance/show/{id}','AllowanceController@show') -> name('showAllowance');

Route::get('/expenditure/create','ExpenditureController@create') -> name('createExpenditure');

Route::post('/login','LoginController@login');
