<?php

$namespace = '\Daspeweb\Framework\Controller';

Route::group(['middleware' => ['web'], 'namespace' => $namespace], function () {
    Route::get('logout-get', 'LoginAsController@logoutGet');
    Route::get('admin/login-as/{user}', 'LoginAsController@loginAs');
    Route::get('admin/users/deactivate/by-user-id/{user}', 'UserController@deactivate');
    Route::get('admin/users/activate/by-user-id/{user}', 'UserController@activate');
    Route::get('admin/users/update-refresh-token/{user}', 'UserController@updateRefreshToken');
    Route::get('admin', function (){return redirect()->to('admin/app-center');});
    Route::get('home', function (){return redirect()->to('admin/app-center');});
    Route::get('admin/app-center', 'DashboardController@appCenter');
    Route::get('admin/filter-control/get-options/{slug}', 'ListViewFilterController@getOptions');
    Route::get('admin/custom/permission-control/all', 'PermissionController@loadAll');
    Route::post('admin/custom/permission-control/all', 'PermissionController@save');
    Route::get('admin/api/{slug}/show/{id}', 'APIController@show');
    Route::get('admin/api/{slug}/index', 'APIController@index');
    Route::get('admin/api/{slug}/count', 'APIController@count');
    Route::post('admin/api/{slug}', 'APIController@store');
    Route::post('admin/api/{slug}/raw', 'APIController@storeRaw');
    Route::put('admin/api/{slug}', 'APIController@update');
    Route::put('admin/api/{slug}/raw', 'APIController@updateRaw');
    Route::put('admin/api/{slug}/{key}/{value}', 'APIController@upsert');
    Route::delete('admin/api/{slug}/{id}/delete', 'APIController@destroy');
    Route::get('admin/consulta-cep/{cep}', 'CEPController@searchCEP');
    Route::get('admin/lookup/{lookup}', 'BaseController@lookup');
    Route::get('admin/{slug}', 'BaseController@index');
    Route::get('admin/{slug}/create', 'BaseController@create');
    Route::get('admin/{slug}/{id}', 'BaseController@show');
    Route::get('admin/{slug}/{id}/get-field/{field}/', 'BaseController@getFieldContent');
    Route::get('admin/{slug}/{id}/edit', 'BaseController@edit');
    Route::put('admin/{slug}/{id}', 'BaseController@update');
    Route::post('admin/{slug}', 'BaseController@store');
    Route::post('admin/{slug}/upload-file', 'BaseController@fileUpload');
    Route::delete('admin/{slug}', 'BaseController@destroy');
});



