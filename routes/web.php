<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/sql/injection', function () {
    return view('sql/injection');
});
Route::post('/sql/injection', 'SQLController@injectionMySQLi');
//Route::post('/sql/injection', 'SQLController@noInjectionMySQLi');
//Route::post('/sql/injection', 'SQLController@injectionPDO');
//Route::post('/sql/injection', 'SQLController@noInjectionPDO');
//Route::post('/sql/injection', 'SQLController@injectionLaravelQueryBuilder');
//Route::post('/sql/injection', 'SQLController@noInjectionLaravelQueryBuilder');

////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////
// Sample: PHP Function for DB Search
Route::get('/sql/search_win', function () {
    return view('sql/search_win');
});
Route::post('/sql/search_win_results', 'SQLController@searchWinResults');

Route::get('/ui/search', 'WCController@search');
Route::post('/ui/search_results', 'WCController@searchResults');
Route::get('/ui/search_team', 'WCController@searchTeams');
Route::get('/ui/search_group', 'WCController@searchGroup');
Route::get('/importcsv/select_csv', function (){
    return view ('importcsv/select_csv');
});


//csv
Route::get('/importcsv/tournament', function(){
    return view ('importcsv/tournament');
});
Route::get('/importcsv/round', function(){
    return view ('importcsv/round');
});
Route::get('/importcsv/group', function(){
    return view ('importcsv/group');
});
Route::get('/importcsv/match', function(){
    return view ('importcsv/match');
});
Route::get('/importcsv/result', function(){
    return view ('importcsv/result');
});
Route::get('/importcsv/team', function(){
    return view ('importcsv/team');
});

Route::post('/importcsv/tournament_csv', 'CsvImportController@tournament_csv');
Route::post('/importcsv/round_csv', 'CsvImportController@round_csv');
Route::post('/importcsv/group_csv', 'CsvImportController@group_csv');
Route::post('/importcsv/match_csv', 'CsvImportController@match_csv');
Route::post('/importcsv/result_csv', 'CsvImportController@result_csv');
Route::post('/importcsv/team_csv', 'CsvImportController@team_csv');
// Sample: AJAX
Route::get('/ajax/hello_ajax', function () {
    return view('ajax/hello_ajax');
});





Route::get('/ajax/hello_ajax_message', function () {
    $data = [
        "message1" => "Welcome to Fantastic AJAX World!!",
        "message2" => "async/await is latest way for AJAX handling."
    ];
    return json_encode($data);
});
Route::post('/ajax/hello_ajax_message', function () {
    $data = [
        "message1" => "Welcome to Fantastic AJAX World!!",
        "message2" => "async/await is latest way for AJAX handling."
    ];
    return json_encode($data);
});
////////////////////////////////////////////////////////////
// Sample: GoogleMap
Route::get('/gmap/hello_gmap', function () {
    return view('gmap/hello_gmap');
});
////////////////////////////////////////////////////////////
