<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	| social@dontpayall.com / HWU35vGcJU
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],
	'facebook' => [
        'client_id' => '353050588424332',
        'client_secret' => '48676d1f57459eb9ef94587a379a70af',
		'redirect' => 'http://www.dontpayall.com/auth/facebook',
	],
	'google' => [
        'client_id' => '20997377210-2pcu21lkbdle4b1pr770r0956gf443tj.apps.googleusercontent.com',
        'client_secret' => 'BCAWvceT9uQKJ_1E15P-v934',
		'redirect' => 'http://www.dontpayall.com/auth/google',
	],
	'twitter' => [
		'client_id' => 'MWH4xowaoUj9Mrnvx8zVU2mUV',
		'client_secret' => 'nQEMrkBBX5A3QgOSkyhH74MrATFfFAhTz0tol7FhiIIdmmneUx',
		'redirect' => 'http://www.dontpayall.com/auth/twitter',
	],
//    'facebook' => [
//        'client_id' => '1200783539949452',
//        'client_secret' => 'b777919fe8afc2ee1d94f8e559401e5c',
//        'redirect' => 'http://localhost:8004/auth/facebook',
//    ],
//    'google' => [
//        'client_id' => '370018940822-h3h6npnm2v1ihbdfk7vsucmmtk8sqh1c.apps.googleusercontent.com',
//        'client_secret' => 'Y2Y5jVYQ0j6y0MRWz2iC4VQe',
//        'redirect' => 'http://localhost:8004/auth/google',
//    ],
//    'github' => [
//        'client_id' => '1c3750a73cf9ac2ba36f',
//        'client_secret' => '236ad432229308046c5fb1c278c4cd77b33f0409',
//        'redirect' => 'http://localhost:8004/auth/github',
//    ],
//    'facebook' => [
//        'client_id' => '121404881528927',
//        'client_secret' => '1a4e76137429d96d1de37171b3d75375',
//        'redirect' => 'http://dev.mccorp.co.com/master/mostcoupon_v1/auth/facebook',
//    ],
//    'google' => [
//        'client_id' => '871074240838-i61p7tmm2ri59kuscm6ahtr41ss2paq0.apps.googleusercontent.com',
//        'client_secret' => 'SxSAbhvg6hVMJjneUhJe0Rat',
//        'redirect' => 'http://dev.mccorp.co.com/master/mostcoupon_v1/auth/google',
//    ],
//    'twitter' => [
//        'client_id' => 'pzo1a7ytRm3ZNfL60YqAyjbnO',
//        'client_secret' => 'To69ScJ5WhdMoyAPzsq9mrDVlkvBP8WjcvXwvWjRZR20F564x6',
//        'redirect' => 'http://dev.mccorp.co.com/master/dontpayall.com_v2/auth/twitter',
//    ],
//    'facebook' => [
//        'client_id' => '480536748770640',
//        'client_secret' => '93d07261d4ef76fc522c947af7e2b3ff',
//        'redirect' => 'http://dev.mccorp.co.com/DV-4/discountsvoucher_v1/auth/facebook',
//    ],
//    'google' => [
//        'client_id' => '871074240838-i61p7tmm2ri59kuscm6ahtr41ss2paq0.apps.googleusercontent.com',
//        'client_secret' => 'SxSAbhvg6hVMJjneUhJe0Rat',
//        'redirect' => 'http://dev.mccorp.co.com/DV-4/discountsvoucher_v1/auth/google',
//    ],
//    'twitter' => [
//        'client_id' => '7RNF9uxxbLezaLCtFylWGwUKf',
//        'client_secret' => 'd7TTPWuEwqmtR8KU15mOoPLKrDXJfBALZOugDbJM1l0DDkzwm1',
//        'redirect' => 'http://dev.mccorp.co.com/DV-4/discountsvoucher_v1/auth/twitter',
//    ],
//    'github' => [
//        'client_id' => 'e50b5eed938892e896d6',
//        'client_secret' => 'c4f72f2b74b0eba30b706d31a1bb9eab15f5c0df',
//        'redirect' => 'http://dev.mccorp.co.com/DV-4/discountsvoucher_v1/auth/github',
//    ],
];
