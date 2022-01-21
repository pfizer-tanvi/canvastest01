<?php

use App\Services\CognitoUserServiceLaravel;
use Pfizer\CognitoAuthLaravel\CognitoAuthLaravelServiceProvider;

return [
    'service_class'     => env('COGNITO_SERVICE_CLASS', CognitoUserServiceLaravel::class),
    'client_id'     => env('COGNITO_KEY'),
    'open_registration'    => env("COGNITO_OPEN_REGISTRATION", true),
    'client_secret' => env('COGNITO_SECRET'),
    'endpoint'      => env('COGNITO_ENDPOINT'),
    'redirect_uri'  => env('COGNITO_REDIRECT_URI', env('APP_URL') . '/auth/cognito'),
    'grant_type'    => env('COGNITO_GRANT_TYPE', 'authorization_code'),
    'keyfile'       => env('COGNITO_KEYFILE', base_path('storage/app/jwks.json')),
    'user_model'    => \App\Models\User::class /* Map to user model */
];
