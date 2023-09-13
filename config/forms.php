<?php

return [
    //login form for admin
    'adminLogin' => [
        'validation' => [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|password',
        ],
        'fildes' => [
            [
                'name' => 'Your Email',
                'placeholder' => 'Enter Your Email',
                'id' => 'email',
                'type' => 'email',
                'wireName' => 'email',
            ],
            [
                'name' => 'Your Password',
                'placeholder' => 'Enter Your Password',
                'id' => 'password',
                'type' => 'password',
                'wireName' => 'password',
            ],
        ]
    ],
];
