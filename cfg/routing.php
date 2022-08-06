<?php

use \cfg\Settings;

return [

    [
        'method'  => 'GET',
        'pattern' => 'foo/bar',
        'action'  => Settings::$def_page . '@' . Settings::$def_method,
    ], [
        'method'  => 'POST',
        'pattern' => 'foo/bar',
        'action'  => 'login@auth',
    ],

];
