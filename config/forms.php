<?php

return [
    //login form for admin
    'adminLogin' => [
        'class' => "mt-8 space-y-6 columns-1",
        'function' => "login",
        'buttonText' => 'Login to your account',
        'validation' => [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required',
            'rememberMe' => 'nullable|bool',
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
            [
                'name' => 'Your Password',
                'placeholder' => 'Enter Your Password',
                'id' => 'checkbox',
                'wireName' => 'rememberMe',
                'type' => 'rememberMeForgotPassword',
                'forgotPasswordRedirectLint' => '#',
            ],
        ]
    ],
];
