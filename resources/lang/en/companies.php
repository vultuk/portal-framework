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
    'view' => [
        'noaddress' => 'No addresses added',
        'addaddress' => 'Add Address',
    ],
    'modals' => [
        'address' => [
            'heading' => 'Address',
            'fields' => [
                'description' => 'Description',
                'primary' => 'Primary Address',
                'address1' => 'Address 1',
                'address2' => 'Address 2',
                'town' => 'Town/City',
                'county' => 'County',
                'postalcode' => 'Postal Code',
            ],
            'actions' => [
                'dismiss' => 'Close',
                'submit' => 'Save',
            ]
        ]
    ]
];
