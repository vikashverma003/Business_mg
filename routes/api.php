<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

 Route::get('get-user-details', function ( Request $request ) {
      return ['status' => 200, 'user' => $request->user() ];
  })->middleware('auth:api');

Route::namespace('Api')->group(function () {
    Route::post('login', 'UserController@login');
    Route::post('signup', 'UserController@signup');
    Route::post('signupManager', 'UserController@signupManager'); 
    Route::post('employeeSignup', 'UserController@employeeSignup');
    Route::post('check_social_user_exist','UserController@checkSocialUserExist');
    Route::get('gettask', 'UserController@gettask');

    Route::get('downlaodGraphPdf','GraphController@downlaodGraphPdf');

    Route::get('newget', 'UserController@newget');
    Route::get('send_due_date_email', 'UserController@send_due_date_email');


    Route::middleware(['auth:api'])->group(function () {

    //Route::get('performa', 'UserController@getDepartment');

    Route::get('getDepartment', 'UserController@getDepartment');
    Route::post('getManager', 'UserController@getManager');
    Route::post('editManager', 'UserController@editManager'); 
    Route::post('updateOwner', 'UserController@updateOwner');
    Route::post('DeleteManager', 'UserController@DeleteManager');

    Route::post('logout', 'UserController@logout');

    Route::post('getEmployee', 'UserController@getEmployee');
    Route::post('managerDetails', 'UserController@managerDetails');
    Route::post('getEmployeedetail', 'UserController@getEmployeedetail');
     
    Route::post('formal_notice', 'UserController@formal_notice');


    Route::post('assignTask', 'UserController@assignTask');
    Route::post('taskList', 'UserController@taskList');
    Route::post('EmployeeTaskList', 'UserController@EmployeeTaskList');

    Route::post('allTasklist', 'UserController@allTasklist'); 
    Route::post('changePassword', 'UserController@changePassword');
    //Update Single task
    Route::post('singleTask', 'UserController@singleTask');
    Route::post('singleTaskDetails', 'UserController@singleTaskDetails');
    Route::post('deleteImage', 'UserController@deleteImage');
    Route::post('deleteDocument', 'UserController@deleteDocument');
    Route::post('getProfile', 'UserController@getProfile');

    Route::post('managerTask', 'UserController@managerTask');

    //Manager Graph
    Route::post('managerGraph', 'GraphController@managerGraph');
    Route::post('KpiGraph', 'GraphController@KpiGraph');
    Route::post('KpiGraphEmployee', 'GraphController@KpiGraphEmployee');

    Route::post('EmployeeRevinueGraph', 'GraphController@EmployeeRevinueGraph');



    Route::post('KpiIndicatorGraph', 'GraphController@KpiIndicatorGraph');

    Route::post('managerRavenueGraph','GraphController@managerRavenueGraph');

    Route::post('KpiRavenueGraph', 'GraphController@KpiRavenueGraph');
    //Add export History
    Route::post('addExportHistory', 'UserController@addExportHistory');
    Route::post('getHistory', 'UserController@getHistory');
    Route::post('transferTask', 'UserController@transferTask');

    //Payment Process API's
    Route::post('addCardToStripe','PaymentController@addCardToStripe');
    Route::post('getCard', 'PaymentController@getCard');
    Route::post('deleteCard', 'PaymentController@deleteCard');
    Route::post('cardStatus', 'PaymentController@cardStatus');

    Route::post('getNotice', 'UserController@getNotice');

    Route::post('getOwnerNotice', 'UserController@getOwnerNotice');

    Route::post('notify','UserController@notify');
    Route::post('searchTask','UserController@searchTask');
    Route::post('alltransferTask','UserController@alltransferTask');

    Route::post('getManagerCount', 'UserController@getManagerCount');

    Route::post('payment', 'PaymentController@payment');


     
     });
});