<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'amadeus' => [
        'url' => env('AMADEUS_BASE_URL', 'https://test.api.amadeus.com/'),
        'client_id' => env('AMADEUS_API_KEY', 'xPQpW1ejd6MdDk71jIYUS5mP24IqLbJn'),
        'client_secret' => env('AMADEUS_API_SECRET', 'NL8jRReAH15sfjp0'),

        'wsdl' => env('AMADEUS_WSDL_PATH'),
        'office_id' => env('AMADEUS_OFFICE_ID'),
        'user_id' => env('AMADEUS_USER_ID'),
        'password' => env('AMADEUS_PASSWORD'),
        'amadeus_url' => env('AMADEUS_URL'),
        'action' => env('AMADEUS_ACTION'),
        'url' => env('AMADEUS_BASE_URL' , 'https://test.api.amadeus.com'),
        'client_id' => env('AMADEUS_API_KEY' , 'xPQpW1ejd6MdDk71jIYUS5mP24IqLbJn'),
        'client_secret' => env('AMADEUS_API_SECRET' , 'NL8jRReAH15sfjp0'),
    ],
    'galileo' => [
        'url' => env('GALILEO_URL' , 'https://airapi.itq.in/Api/flight/'),
        'user_name' => env('GALILEO_USER_NAME' , 'MakeTrueTrip'),
        'password' => env('GALILEO_PASSWORD' , '$W-4tQ(&@22'),
    ],
    'cashfree' => [
        'key' => env('CASHFREE_APP_ID' , '1661862c982a09f6d5f1d93900681661'),
        'secret' => env('CASHFREE_SECRET_KEY' , '781827d26290a6ea98559e65ec895029923b5fa7'),
        'endpoint' => env('CASHFREE_ENDPOINT' , 'https://api.cashfree.com/'),
        'cashfree_order-currency' => env('CASHFREE_ORDER_CURRENCY', 'INR'),
        'cashfree_order_prefix' => env('CASHFREE_ORDER_PREFIX', 'MCG-6'),
    ],
    'paypal' => [
        'mode' => env('PAYPAL_MODE' , 'live'),
        'client_id' => env('PAYPAL_CLIENT_ID' , 'AfVjuAj8RIhB6l_4xVgOrRk511u00lYVTKMErC6Sj7bWOgzpGNhUVtf-zEtn-9QdhSjmyCo-urvqgpiZ'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET' , 'ECAx5h2l_MY00RtLA9NGQy8yZ8lPEcIg214ykOJH2Vz6PCW2IjyznzcOYLLe0m9rksv6PLxfiS7PUrnr'),
    ],
    'razorpay' => [
        'key' => env('RAZORPAY_KEY','rzp_test_VruMADPs1DBV6o'),
        'secret'=>env('RAZORPAY_SECRET','ADrftEFq6AhVZZ4te00pK6qK')
    ]

];
