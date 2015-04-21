<?php

    Route::Group(['prefix' => 'users', 'namespace' => '\Portal\Users\Controllers'], function() {

        // All controller functions related to a reporting.
        Route::Group(['prefix' => 'reports', 'namespace' => 'Reports'], function() {
            Route::controllers([
                'sales' => 'SalesReportController'
            ]);
        });

    });
