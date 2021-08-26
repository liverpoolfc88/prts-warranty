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

Route::get('/', function () {
    return redirect('home');
});
Route::get('/overall', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@overall')->name('overall');
Route::get('/home_m', 'HomeController@home_m')->name('home_m');
Route::get('/charts', 'HomeController@charts')->name('charts');
// Authentication Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['auth']], function() {

//    Route::get('/', function () {
//        return redirect('home');
//    });

    Route::get('/changePassword','HomeController@showChangePasswordForm');
    Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

//    Route::get('/overall', 'HomeController@index')->name('home');
//    Route::get('/home', 'HomeController@overall')->name('overall');
//    Route::get('/home_m', 'HomeController@home_m')->name('home_m');
//    Route::get('/charts', 'HomeController@charts')->name('charts');
    Route::get('/report_p', 'ProblemController@report')->name('problem.report');
    Route::get('/levelsecond', 'ProblemController@levelsecond');
    Route::get('group_problem/{sort}', 'ProblemController@group_problem');

//    check sheet
    Route::resource('level1', 'Level_firstController');
    Route::resource('level2', 'Level_secondController');
    Route::resource('fault_type', 'Fault_typeController');


    Route::resource('stages', 'StageController');
    Route::resource('stage-groups', 'StageGroupController');
    Route::resource('departments', 'DepartmentController');
    Route::resource('users', 'UserController');
    Route::resource('problems', 'ProblemController');

    Route::resource('problem-types', 'ProblemTypeController');
    Route::resource('dealers', 'DealerController');
    Route::resource('vehicle-models', 'VehicleModelController');
    Route::resource('email-list', 'EmaillistController');
    Route::resource('problem-action', 'ProblemActionController',['only'=>['update']]);
    Route::get('reject/{id}', 'ProblemActionController@reject');
    Route::get('many/{id}', 'ProblemController@many');
    Route::get('status', 'ProblemActionController@status');
    Route::get('request', 'ProblemActionController@request');
    Route::get('shows', 'ProblemActionController@shows');
    Route::get('delivery', 'ProblemController@delivery');
    Route::get('select', 'ProblemController@select');

    Route::post('/edit_content','HomeController@postEdit');

});