<?php

    Route::Group(['prefix' => 'users', 'namespace' => '\Portal\Users\Controllers'], function() {


        // All controller functions related to reporting.
        Route::Group(['prefix' => 'reports', 'namespace' => 'Reports'], function() {
            Route::get('sales', 'SalesReportController@index');
            Route::post('sales/view', 'SalesReportController@viewDetails');
        });

    });
