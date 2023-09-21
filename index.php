<?php

error_reporting(-1);
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/errors.log');

require __DIR__.'/vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';
$phrases = require_once 'phrases.php';
require_once 'keyboards.php';

/**
 * @var array $keyboard1
 * @var array $keyboard2
 * @var array $inline_keyboard1
 */

$telegram = new \Telegram\Bot\Api(TOKEN);
$update = $telegram->getWebhookUpdate();

debug($update);

//$chat_id = $update['message']['chat']['id'] ?? 0;

if (isset($update['message']['chat']['id'])) {
    $chat_id = ($update['message']['chat']['id']);
} elseif (isset($update['callback_query']['message']['chat']['id'])) {
    $chat_id = ($update['callback_query']['message']['chat']['id']);
}



$text = $update['message']['text'] ?? '';
$name = $update['message']['from']['first_name'] ?? 'Guest';

if (!$chat_id) {
    die;
}

if ($text == '/start') {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Welcome!",
        'reply_markup' => json_encode($keyboard1),
    ]);
} elseif ($text == $phrases['keyboard2']) {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Change keyboard",
        'reply_markup' => new Telegram\Bot\Keyboard\Keyboard($keyboard2),
    ]);
} elseif ($text == $phrases['keyboard1']) {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Change keyboard",
        'reply_markup' => new Telegram\Bot\Keyboard\Keyboard($keyboard1),
    ]);
} elseif ($text == $phrases['inline_keyboard1']) {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Show inline Keyboard",
        'reply_markup' => new Telegram\Bot\Keyboard\Keyboard($inline_keyboard1),
    ]);
} elseif (isset($update['callback_query'])) {
    $telegram->answerCallbackQuery([
        'callback_query_id' => $update['callback_query']['id'],
//        'text' => "Pressed Button {$update['callback_query']['data']}",
//        'show_alert'=> false
    ]);
    $telegram->editMessageText([
        'chat_id' => $chat_id,
        'message_id' => $update['callback_query']['message']['message_id'],
        'text' => 'Show inline Keyboard' . PHP_EOL . '<i>edited ⌚</i>' . date("H:i:s"),
        'parse_mode' => 'HTML',
        'reply_markup' => new Telegram\Bot\Keyboard\Keyboard($inline_keyboard1),
    ]);
}elseif ($text == 'contact') {
    $telegram->sendLocation([
        'chat_id' => $chat_id,
        'latitude' => 54.00016678926494,
        'longitude' => 117.99994091369174
    ]);
}elseif ($text == '/help' || $text == $phrases['help']) {
    try {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Show bot help",
            'parse_mode' => 'HTML',
        ]);
    } catch (\Telegram\Bot\Exceptions\TelegramSDKException $e) {
        error_log($e->getMessage() . PHP_EOL, 3, __DIR__ . '/errors.log');
    }
} elseif ($text == $phrases['close']) {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Close keyboard",
        'reply_markup' => new Telegram\Bot\Keyboard\Keyboard(['remove_keyboard'=> true]),
    ]);
} elseif ($text == '/test') {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Hello, <b>{$name}</b>!" . PHP_EOL . "Test command...",
        'parse_mode' => 'HTML',
    ]);
} elseif ($text == 'photo') {
    $res = $telegram->sendPhoto([
        'chat_id' => $chat_id,
        'photo' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/img/1.jpg'),
        'caption' => 'Some photo',
    ]);

    $res = $telegram->sendPhoto([
        'chat_id' => $chat_id,
        'photo' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/img/2.jpg'),
        'caption' => 'Some photo',
    ]);
//    debug($res);
}elseif ($text == 'doc') {
    $res = $telegram->sendDocument([
        'chat_id' => $chat_id,
        'document' => 'BQACAgIAAxkDAAOwZF4HGu3bvnXzcu_8d4yZYQfgJqUAAnUoAAIvMPFKSe5JkeRshEkvBA',
        'thumb' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/img/file.png'),
    ]);
} elseif ($text == 'group') {
    $telegram->sendMediaGroup([
        'chat_id' => $chat_id,
        'media' => json_encode([
            ['type' => 'document', 'media' => 'attach://logs.txt', 'caption' => 'Doc 1'],
            ['type' => 'document', 'media' => 'attach://errors.log', 'caption' => 'Doc 2'],
            ['type' => 'document', 'media' => 'attach://test.txt', 'caption' => 'Doc 3'],
        ]),
        'logs.txt' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/logs.txt'),
        'errors.log' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/errors.log'),
        'test.txt' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/test.txt'),
    ]);
}  elseif (!empty($text)) {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Hello, <b>{$name}</b>!" . PHP_EOL . "You wrote: <i>{$text}</i>",
        'parse_mode' => 'HTML',
    ]);
} else {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Hello, <b>{$name}</b>!" . PHP_EOL . "<u>I need some text</u>",
        'parse_mode' => 'HTML',
    ]);
}
