<?php

    // Specific Order routes for companies
    Route::Group(['prefix' => 'company/order', 'namespace' => '\Portal\Orders\Controllers'], function() {

        Route::get('view/{company}', 'OrderController@showCompanyOrders');

    });
