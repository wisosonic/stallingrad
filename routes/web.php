<?php

Route::get("/installation", "HomeController@checkInstallation");

Route::post("/setenv", "ConfigController@createDatabase");
Route::get("/make-migration", "ConfigController@makeMigration");

Route::get('/', "HomeController@index");
Route::get('/get-maps', "HomeController@getMaps");
Route::get('/start-map/{map_id}', "HomeController@startMap");

Route::get('/saved-games', "UserController@savedGames");
Route::post('/save-game', "UserController@saveGame");
Route::get('/continue-game/{gamesession_id}', "UserController@continueGame");
Route::get('/delete-game/{gamesession_id}', "UserController@deleteGame");

Route::get('/download-report', "HomeController@getReport");

Route::post('/checkemailavailability', 'UserController@checkEmailAvailability');

Auth::routes();

