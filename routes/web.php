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

// Route::get('/', function () {
//     return view('welcome');
// });


    
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('login','UserController@index')->name('login');
    Route::post('check_user','UserController@login');

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard','DashboardController@index');
        Route::get('logout','UserController@logout');
        Route::get('users','UserController@users');
        //Route::get('viewUser/{id}','UserController@viewUser');
        Route::get('/viewUser/{id}',['as'=>'viewUser', 'uses' => 'UserController@viewUser']);
        Route::get('/OwnerEdit/{id}',['as'=>'OwnerEdit', 'uses' => 'UserController@OwnerEdit']);
        Route::get('/EditReports/{id}',['as'=>'EditReports', 'uses' => 'UserController@EditReports']);
        
        
        Route::get('/user/blocks',['as'=>'block_user','uses' => 'UserController@block_user']);
        Route::get('/user/block',['as'=>'block_manager','uses' => 'UserController@block_manager']);
        Route::get('/department/delete',['as'=>'delete_department','uses' => 'DepartmentController@delete_department']);
        Route::get('/user/deletes',['as'=>'delete_user','uses' => 'UserController@delete_user']);

        Route::get('/user/delete',['as'=>'delete_manager','uses' => 'UserController@delete_manager']);

        //DepartMent
        Route::get('departmentlist','UserController@departmentlist');
        Route::get('paymentlist','UserController@paymentlist');
        
        Route::get('adddepartment','UserController@adddepartment');

        //User List 
        Route::get('userList','UserController@userList');
        Route::get('managerList','UserController@managerList');
        Route::get('reportList','UserController@reportList');
        Route::get('price','UserController@price');
        
        
        Route::get('addOwner','UserController@addOwner');
        Route::get('addReports','UserController@addReports');
        Route::post('createReports','UserController@createReports');
        
        Route::post('createOwner','UserController@createOwner');
        Route::post('createNotice','UserController@createNotice');
        Route::post('createNotices','UserController@createNotices');
        
        Route::post('UpdateOwner','UserController@UpdateOwner');
        Route::post('updatedReports','UserController@updatedReports');
        
        Route::get('viewNotice','UserController@viewNotice');
        Route::post('UpdateNotice','UserController@UpdateNotice');
        Route::post('Updateprice','UserController@Updateprice');
        
        
        
       
        Route::get('/ViewOwner/{id}',['as'=>'ViewOwner', 'uses' => 'UserController@ViewOwner']);
        Route::get('/ViewManager/{id}',['as'=>'ViewManager', 'uses' => 'UserController@ViewManager']);
        
        Route::get('/sendNotice/{id}',['as'=>'sendNotice', 'uses' => 'UserController@sendNotice']);
       

        Route::get('/sendNotices/{id}',['as'=>'sendNotices', 'uses' => 'UserController@sendNotices']);
        
        
        Route::get('/user_feedback_update/{id}',['as'=>'user_feedback_update', 'uses' => 'UserController@user_feedback_update']);

        Route::post('CreateDepartment','DepartmentController@CreateDepartment');
        Route::get('/user/editlang/{id}',['as'=>'editLang', 'uses' => 'LanguageController@editLang']);
        Route::get('viewTransaction','UserController@viewTransaction');
        Route::get('sendingEmailToUser','UserController@sendingEmailToUser');
        Route::post('sendingEmail','UserController@sendingEmail')->name('sendingEmail');
        Route::get('term','UserController@term');
        Route::get('policy','UserController@policy');
        Route::post('updatePrivacy','UserController@updatePrivacy');
        Route::post('updateTerm','UserController@updateTerm');
        Route::get('contact','UserController@contact');
        Route::post('updateContact','UserController@updateContact');
        Route::get('view_all_notification','UserController@view_all_notification')->name('view_all_notification');
        Route::get('/mark_as_read/{id}',['as'=>'mark_as_read', 'uses' => 'UserController@mark_as_read']);
        //Route::get('anylatics_view','AnylaticsController@index');
        Route::get('stock','AnylaticsController@index');
        Route::get('stock/chart','AnylaticsController@chart');
        Route::get('stock/payment_chart','AnylaticsController@payment_chart');



    });
});


// Route::namespace('Web')->group(function () {
//     Route::get('/','HomeController@index')->name('home');
//     Route::resource('login','LoginController');
// });