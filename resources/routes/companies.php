<?php


    // Base Company details
    Route::Group(['prefix' => 'company', 'namespace' => '\Portal\Companies\Controllers'], function() {



        Route::get('', 'CompanyController@index');

        Route::get('edit/{company}', 'CompanyController@edit');
        Route::get('view/{company}', 'CompanyController@display');
        Route::get('activity/{company}', 'CompanyController@activities');

    });
