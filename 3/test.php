<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$cart = [
    1 => [
        'price' => 650,
        'qty' => 1,
    ],
    2 => [
        'price' => 399,
        'qty' => 1,
    ],
    3 => [
        'price' => 500,
        'qty' => 1,
    ],

];
var_dump(check_cart($cart, 1549));

