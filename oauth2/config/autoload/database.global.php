<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/5/17
 * Time: 6:42 PM
 */


$db_host = getenv('db_host');
$db_name = getenv('db_name');
$db_user = getenv('db_user');
$db_pass = getenv('db_pass');
$db_port = getenv('db_port');


return [
    'db' => [
        'driver'   => 'Pdo',
        'dsn'      => 'mysql:host='.$db_host.';port=3306;dbname='.$db_name.';',
        'user'     => $db_user,
        'password' => $db_pass
    ],
];