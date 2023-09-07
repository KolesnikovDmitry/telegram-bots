<?php
require_once 'config.php';
require_once 'functions.php';

$updates = send_request('getUpdates');

if (!empty($updates->result)) {
    foreach ($updates->result as $update) {
//        echo "{$update->update_id} - {$update->message->chat->id} - {$update->message->from->first_name} - {$update->message->text}<br>";
        $text = isset($update->message->text) ? "Вы написали: <i>{$update->message->text}</i>" : "<u>Добавьте текст</u>";
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
    }

}


debug($updates);