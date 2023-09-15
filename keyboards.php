<?php

/**
 * @var array $phrases
 */

$keyboard1 = [
    'keyboard' => [
        [$phrases['contact'], $phrases['location']],
        [$phrases['close'], $phrases['keyboard2']],
    ],
    'resize_keyboard' => true,
    'one_time_keyboard' => false,
    'input_field_placeholder' => 'Select button...',
];

$keyboard2 = [
    'keyboard' => [
        [$phrases['help'], $phrases['about']],
        [$phrases['keyboard1']],
    ],
    'resize_keyboard' => true,
    'input_field_placeholder' => 'Select button...',
];
