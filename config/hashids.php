<?php

/*
 * This file is part of Laravel Hashids.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => '3d43Z45E6QtLzJY7a2RXHj8Qep8e5LNo',
            'length' => '20',
            'alphabet' => 'abcdefghij1234567890',
        ],

        'alternative' => [
            'salt' => '3d43Z45E6QtLzJY7a2RXHj8Qep8e5LNo',
            'length' => '20',
            'alphabet' => 'abcdefghij1234567890',
        ],

        'patient_appointment' => [
            'salt' => '4LU67PPI7Fsfp10155Ws0LKn16z8K1fD',
            'length' => '20',
            'alphabet' => 'abcdefghij1234567890',
        ],

        'user_picture' => [
            'salt' => 'fubh5ghc6YYZ7yM8dEA77Y2hyieglJqa',
            'length' => '20',
            'alphabet' => 'abcdefghij1234567890',
        ],

        'doctor' => [
            'salt' => 'x9XrwYzHR5awVCPoH4hyDXs7zZLgb4iq',
            'length' => '20',
            'alphabet' => 'abcdefghij1234567890',
        ],

    ],

];
