<?php

/**
 * @var array $phrases
 */

$keyboard1 = [
    'keyboard' => [
        [
            [
                'text' => $phrases['btn_subscribe'], 'web_app' => ['url' => WEBAPP1],
                //  'request_contact' => true
            ]
        ]
    ],
    'resize_keyboard' => true,
    'input_field_placeholder' => $phrases['select_btn'],
];

$keyboard2 = [
    'keyboard' => [
        [
            ['text' => $phrases['btn_unsubscribe']]
        ]
    ],
    'resize_keyboard' => true,
    'input_field_placeholder' => $phrases['select_btn'],
];

$inline_keyboard1 = [
    'inline_keyboard' => [
        [
            ['text' => $phrases['inline_btn'], 'web_app' => ['url' => WEBAPP2]]
        ]
    ],
];

$price = [
    'inline_keyboard' => [
        [
            ['text' => $phrases['open'], 'web_app' => ['url' => PRICE]]
        ]
    ],
];
