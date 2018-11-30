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
    return view('welcome');
});

//Mawingu HeatMap
Route::get('/map', 'HeatMapController@map');
Route::get('/mapCoordinates', 'HeatMapController@mapCoordinates');
Route::get('/mapCoordinates/{month}/{year}', 'HeatMapController@mapCoordinates');
Route::get('/upload', 'HeatMapController@uploadIndex');
Route::post('import', 'HeatMapController@uploadExcel');
Route::get('/uploadBucket', 'HeatMapController@indexBucket');
Route::post('/uploadBucket', 'HeatMapController@uploadBucket');
Route::get('heatMap', 'HeatMapController@index');
Route::get('/readData', 'HeatMapController@readData');
Route::get('/addBucket', 'HeatMapController@create');
Route::post('/createBucket', 'HeatMapController@store');
Route::get('/salesReport', 'HeatMapController@salesIndex');
Route::post('/salesReports', 'HeatMapController@salesReport');
Route::post('/createBucket', 'HeatMapController@save');
Route::get('/search/Bucket', 'HeatMapController@displayForm');
Route::post('/searchBucket', 'HeatMapController@displaySearch');
Route::patch('/bucket/delete/{id}', 'HeatMapController@destroy');
Route::get('/bucket/edit/{id}', 'HeatMapController@edit');
Route::patch('/bucket/{bucketId}', 'HeatMapController@update');
Route::get('/actionsPage', 'HeatMapController@actions');
Route::get('/heatMapReport', 'HeatMapController@showForm');
Route::post('/heatMapReports', 'HeatMapController@heatMapReports');
Route::post('/createBucket', 'HeatMapController@store');
