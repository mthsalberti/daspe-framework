<?php

$namespace = 'Daspeweb\Framework\Controller';

Route::group(['middleware' => ['auth:api'], 'namespace' => $namespace], function () {
    Route::get('/api/{slug}/show/{id}', 'APIController@show');
    Route::get('/api/{slug}/index', 'APIController@index');
    Route::get('/api/{slug}/count', 'APIController@count');
    Route::post('/api/{slug}', 'APIController@store');
    Route::post('/api/{slug}/raw', 'APIController@storeRaw');
    Route::put('/api/{slug}', 'APIController@update');
    Route::put('/api/{slug}/raw', 'APIController@updateRaw');
    Route::patch('/api/{slug}/{key}/{value}', 'APIController@upsertRaw');
    Route::delete('/api/{slug}/{id}/delete', 'APIController@destroy');
});


