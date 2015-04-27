<?php

Route::Group(['prefix' => 'company', 'namespace' => '\Portal\Companies\Controllers'], function() {


    Route::get('edit/{company}', 'CompanyController@edit');
    Route::get('view/{company}', 'CompanyController@display');
    Route::get('activity/{company}', 'CompanyController@activities');


});