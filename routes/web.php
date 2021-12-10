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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/home/grafik', 'HomeController@grafik')->name('index.grafik');


// Route::get('/home', 'HomeController@index')->name('home');


// DIVISION
Route::get('division', 'Division\controller\divisionController@index')->name('division.index');
Route::get('division/create', 'Division\controller\divisionController@create');
Route::post('division/store', 'Division\controller\divisionController@store');
Route::get('division/edit/{id}', 'Division\controller\divisionController@edit');
Route::post('division/update/{id}', 'Division\controller\divisionController@update');
Route::get('division/delete/{id}', 'Division\controller\divisionController@delete');


// CLIENT
Route::get('client', 'Client\controller\clientController@index')->name('client.index');
Route::get('client/create', 'Client\controller\clientController@create');
Route::post('client/store', 'Client\controller\clientController@store');
Route::get('client/edit/{id}', 'Client\controller\clientController@edit');
Route::post('client/update/{id}', 'Client\controller\clientController@update');
Route::get('client/delete/{id}', 'Client\controller\clientController@delete');
Route::get('client/check_clientcode', 'Client\controller\clientController@checkclientcode');

// URGENCY
Route::get('urgency', 'Urgency\controller\urgencyController@index')->name('urgency.index');
Route::get('urgency/create', 'Urgency\controller\urgencyController@create');
Route::post('urgency/store', 'Urgency\controller\urgencyController@store');
Route::get('urgency/edit/{id}', 'Urgency\controller\urgencyController@edit');
Route::post('urgency/update/{id}', 'Urgency\controller\urgencyController@update');
Route::get('urgency/delete/{id}', 'Urgency\controller\urgencyController@delete');


// ESTIMATE
Route::get('estimate', 'Estimate\controller\estimateController@index')->name('estimate.index');
Route::get('estimate/create', 'estimate\controller\estimateController@create');
Route::post('estimate/store', 'estimate\controller\estimateController@store');
Route::get('estimate/edit/{id}', 'estimate\controller\estimateController@edit');
Route::post('estimate/update/{id}', 'Estimate\controller\estimateController@update');
Route::get('estimate/delete/{id}', 'Estimate\controller\estimateController@delete');

// PROJECT
Route::get('project', 'Project\controller\projectController@index')->name('project.index');
Route::get('project/create', 'Project\controller\projectController@create');
Route::post('project/store', 'Project\controller\projectController@store');
Route::get('project/edit/{id}', 'Project\controller\projectController@edit');
Route::post('project/update/{id}', 'Project\controller\projectController@update');
Route::get('project/delete/{id}', 'Project\controller\projectController@delete');
Route::get('project/check_projectcode', 'Project\controller\projectController@checkprojectcode');

// STAFF ROLE
Route::get('staffrole', 'Staffrole\controller\staffroleController@index')->name('staffrole.index');
Route::get('staffrole/create', 'Staffrole\controller\staffroleController@create');
Route::post('staffrole/store', 'Staffrole\controller\staffroleController@store');
Route::get('staffrole/edit/{id}', 'Staffrole\controller\staffroleController@edit');
Route::post('staffrole/update/{id}', 'Staffrole\controller\staffroleController@update');
Route::get('staffrole/delete/{id}', 'Staffrole\controller\staffroleController@delete');
Route::get('staffrole/check_rolecode', 'Staffrole\controller\staffroleController@checkrolecode');

// STATUS
Route::get('status', 'Status\controller\statusController@index')->name('status.index');
Route::get('status/create', 'Status\controller\statusController@create');
Route::post('status/store', 'Status\controller\statusController@store');
Route::get('status/edit/{id}', 'Status\controller\statusController@edit');
Route::post('status/update/{id}', 'Status\controller\statusController@update');
Route::get('status/delete/{id}', 'Status\controller\statusController@delete');
Route::get('status/check_statuscode', 'Status\controller\statusController@checkstatuscode');

// STAFF
Route::get('staff', 'Staff\controller\staffController@index')->name('staff.index');
Route::get('staff/create', 'Staff\controller\staffController@create');
Route::post('staff/store', 'Staff\controller\staffController@store');
Route::get('staff/edit/{id}', 'Staff\controller\staffController@edit');
Route::post('staff/update/{id}', 'Staff\controller\staffController@update');
Route::get('staff/delete/{id}', 'Staff\controller\staffController@delete');
Route::get('staff/check_staffcode', 'Staff\controller\staffController@checkstaffcode');

// SCRUM
Route::get('scrum', 'Scrum\controller\scrumController@index')->name('scrum.index');
Route::get('scrum/create', 'Scrum\controller\scrumController@create');
Route::post('scrum/store', 'Scrum\controller\scrumController@store');
Route::get('scrum/edit/{id}', 'Scrum\controller\scrumController@edit');
Route::post('scrum/update/{id}', 'Scrum\controller\scrumController@update');
Route::get('scrum/delete/{id}', 'Scrum\controller\scrumController@delete');

// TRANSACTION
Route::get('transaction', 'Transaction\controller\transactionController@index')->name('transaction.index');

// MY SCRUM DEVELOPER
Route::get('myscrum_dev', 'Scrum\controller\scrumController@myscrum_dev')->name('scrum.myscrum_dev');

// MY SCRUM ANALYST
Route::get('myscrum_analyst', 'Scrum\controller\scrumController@myscrum_analyst')->name('scrum.myscrum_analyst');

Route::get('scrum/take/{id}', 'Scrum\controller\scrumController@take');
Route::get('scrum/finish/{id}', 'Scrum\controller\scrumController@finish');
Route::get('scrum/finishdev/{id}', 'Scrum\controller\scrumController@finishdev');
Route::get('scrum/finetuning/{id}', 'Scrum\controller\scrumController@finetuning');

// SCRUM MARKET
Route::get('scrummarket', 'Scrum\controller\scrumController@scrummarket')->name('scrum.scrummarket');

// STATUS
Route::get('week', 'Week\controller\weekController@index')->name('week.index');
Route::get('week/create', 'Week\controller\weekController@create');
Route::post('week/store', 'Week\controller\weekController@store');
Route::get('week/edit/{id}', 'Week\controller\weekController@edit');
Route::post('week/update/{id}', 'Week\controller\weekController@update');
Route::get('week/delete/{id}', 'Week\controller\weekController@delete');


// API
