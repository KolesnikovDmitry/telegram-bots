<?php
error_reporting(-1);
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . "/errors.log");

require __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';

$telegram = new \Telegram\Bot\Api(TOKEN);
$update = $telegram->getWebhookUpdate();

debug($update);

$chat_id = $update['message']['chat']['id'] ?? 0;
$text = $update['message']['text'] ?? "";
$name = $update['message']['from']['first_name'] ?? "Гость";

if (!$chat_id) {
    die;
}

if ($text == '/help') {
    try {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Show bot help",
            'parse_mode' => 'HTML',
        ]);
    } catch (\Telegram\Bot\Exceptions\TelegramSDKException $e) {
        error_log($e->getMessage() . PHP_EOL, 3, __DIR__ . "/errors.log");
    }

} elseif ($text == '/test') {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Hello, <b>{$name}</b>!" . PHP_EOL . "Test command...",
        'parse_mode' => 'HTML',
    ]);
} elseif ($text === "photo") {
    $res = $telegram->sendPhoto([
        'chat_id' => $chat_id,
//        'photo' => \Telegram\Bot\FileUpload\InputFile::create('https://loremflickr.com/720/340'),
//        'photo' => 'AgACAgIAAxkDAAN0ZP7MvSzNVz5bL-gjHyLZKexUYukAAhnPMRsRsfhLRiWjL6mqyqMBAAMCAANtAAMwBA',
        'photo' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/img/4.png'),
        'caption' => 'Some photo',
    ]);
    $res = $telegram->sendPhoto([
        'chat_id' => $chat_id,
//        'photo' => \Telegram\Bot\FileUpload\InputFile::create('https://loremflickr.com/720/340'),
//        'photo' => 'AgACAgIAAxkDAAN0ZP7MvSzNVz5bL-gjHyLZKexUYukAAhnPMRsRsfhLRiWjL6mqyqMBAAMCAANtAAMwBA',
        'photo' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/img/1.jpg'),
        'caption' => 'Some photo',
    ]);
} elseif ($text == 'doc'){
    $res = $telegram->sendDocument([
        'chat_id' => $chat_id,
//        'document' => \Telegram\Bot\FileUpload\InputFile::create('https://loremflickr.com/720/340'),
        'document' => "BQACAgIAAxkDAAObZQLAM_fEVuQZVBDO7XiRLBbVQ4YAApczAALCBRlI6G3vDaStML0wBA",
        'thumbnail' => \Telegram\Bot\FileUpload\InputFile::create(__DIR__ . '/img/file.png')
    ]);
    debug($res);
} elseif ($text == 'group') {
//    $telegram->sendMediaGroup([
//        'chat_id' => $chat_id,
//        'media' => json_encode([
//            ['type' => 'photo', 'media' => 'https://tel-bots.ru/bots/1/img/1.jpg', 'caption' => "Photo 1"],
//            ['type' => 'photo', 'media' => 'https://tel-bots.ru/bots/1/img/2.jpg', 'caption' => "Photo 2"],
//            ['type' => 'photo', 'media' => 'https://tel-bots.ru/bots/1/img/3.jpg', 'caption' => "Photo 3"],
//        ]),
//    ]);
} elseif (!empty($text)) {
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

