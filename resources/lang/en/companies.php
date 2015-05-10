<?php return [
    'index' => [
        'heading'      => 'View Companies',
        'createButton' => 'New Company',
        'panels'       => [
            'companies' => [
                'heading' => 'List of all Companies',
            ]
        ],
        'modals'       => [
            'create' => [
                'title'   => 'New Company',
                'fields'  => [
                    'name'       => 'Company Name',
                    'address1'   => 'Address Line 1',
                    'address2'   => 'Address Line 2',
                    'address3'   => 'Address Line 3',
                    'townCity'  => 'Town',
                    'county'     => 'County',
                    'postalCode' => 'Postal Code',
                    'country' => 'Country',
                ],
                'actions' => [
                    'submit'  => 'Create',
                    'dismiss' => 'Close',
                ]
            ],
        ]
    ],
];
