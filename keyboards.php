<?php

/**
 * @var array $phrases
 */

$keyboard1 = [
    'keyboard' => [
        [['text'=> $phrases['contact'], 'request_contact'=> true],
        ['text'=> $phrases['location'], 'request_location' => true ]],
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
