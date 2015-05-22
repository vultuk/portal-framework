<?php

    // Base Company details
    Route::Group(['prefix' => 'company', 'namespace' => '\Portal\Companies\Controllers'], function () {

        Route::get('edit/{company}', 'CompanyController@edit');
        Route::get('view/{company}', 'CompanyController@display');
        Route::get('activity/{company}', 'CompanyController@activities');
        Route::post('address/{company}', 'CompanyController@addAddress');


        Route::get('{company}', 'CompanyController@display');

        Route::get('', 'CompanyController@index');

    });
