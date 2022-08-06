<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 10:39
 */

use Illuminate\Database\Capsule\Manager as Capsule;

$configs_db = [
    'moto' => [
        'driver'    => 'mysql',
        'host'      => '128.0.0.1:3306',
        'database'  => 'data',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ],
];

$dbObj = new Capsule();

foreach ($configs_db as $name => $config) {
    $dbObj->addConnection($config, $name);
}

$dbObj->setAsGlobal();