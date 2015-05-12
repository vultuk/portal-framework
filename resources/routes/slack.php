<?php

    // Specific Order routes for companies
    Route::Group(['prefix' => 'slack', 'namespace' => '\Portal\Slack\Controllers'], function() {

        Route::get('slash', 'SlackController@slashCommand');

    });
