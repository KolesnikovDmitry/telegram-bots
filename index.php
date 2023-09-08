<?php
error_reporting(-1);
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . "/errors.log");

require_once 'config.php';
require_once 'functions.php';

//var_dump(BASE_URL . 'setWebhook?url=https://tel-bots.ru/bots/1/');

$update = json_decode(file_get_contents('php://input'));

debug($update);

$text = isset($update->message->text) ? "Вы написали: <i>{$update->message->text}</i>" : "<u>Добавьте                 текст</u>";
$chat_id = $update->message->chat->id ?? 0;
$name = $update->message->from->first_name ?? "Гость";

if ($chat_id) {
    $res = send_request("sendMessage", [
        'chat_id' => $chat_id,
        'text' => "Hello, <b>{$name}</b>" . PHP_EOL . $text,
        'parse_mode' => 'HTML',
    ]);
    debug($res);
}

