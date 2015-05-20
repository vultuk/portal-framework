<?php

    return [
        'view' => [
            'index' => [
                'heading' => 'View Orders',

                'tables' => [
                    'orders' => [
                        'product' => 'Product',
                        'value' => 'Value',
                        'status' => 'Status',
                        'created' => 'Created',
                        'completion' => 'Progress',
                    ],
                ],
            ]
        ],
        'partials' => [
            'ordertable' => [
                'heading' => 'Orders',
                'table' => [
                    'product' => 'Product',
                    'value' => 'Value',
                    'status' => 'Status',
                    'created' => 'Created',
                    'completion' => 'Progress',
                ],
                'button' => [
                    'neworder' => 'Create Order',
                ]
            ]
        ],
    ];
