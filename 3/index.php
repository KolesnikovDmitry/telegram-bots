<?php

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/errors.log');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
$phrases = require_once __DIR__ . '/phrases.php';
require_once __DIR__ . '/keyboards.php';
require_once __DIR__ . '/functions.php';

/**
 * @var array $phrases
 * @var array $inline_keyboard1
 * @var array $keyboard1
 * @var array $keyboard2
 */

$telegram = new \Telegram\Bot\Api(TOKEN);
$update = $telegram->getWebhookUpdate();
debug($update);


//$chat_id = $update['message']['chat']['id'] ?? 0;
$text = $update['message']['text'] ?? '';
$name = $update['message']['from']['first_name'] ?? 'Guest';

if (isset($update['message']['chat']['id'])) {
    $chat_id = $update['message']['chat']['id'];
} elseif (isset($update['user']['id'])) {
    $chat_id = (int)$update['user']['id'];
    $query_id = $update['query_id'] ?? '';
    $cart = $update['cart'] ?? [];
    $total_sum = $update['total_sum'] ?? 0;
    $total_sum = (int)$total_sum;
} elseif (isset($update['pre_checkout_query']['id'])) {
    $chat_id = $update['pre_checkout_query']['id'];
}

if (!$chat_id) {
    die;
}

if ($text == '/start') {
    $keyboard = check_chat_id($chat_id) ? $keyboard2 : $keyboard1;
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => sprintf($phrases['start'], $name),
        'parse_mode' => 'HTML',
        'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($keyboard),
    ]);
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $phrases['inline_keyboard'],
        'parse_mode' => 'HTML',
        'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($inline_keyboard1),
    ]);
} elseif ($text == $phrases['btn_unsubscribe']) {
    if (delete_subscriber($chat_id)) {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $phrases['success_unsubscribe'],
            'parse_mode' => 'HTML',
            'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($keyboard1),
        ]);
    } else {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $phrases['error_unsubscribe'],
            'parse_mode' => 'HTML',
            'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($keyboard2),
        ]);
    }
} elseif (isset($update['message']['web_app_data'])) {
    $btn = $update['message']['web_app_data']['button_text'];
    $data = json_decode($update['message']['web_app_data']['data'], 1);

    if (!check_chat_id($chat_id) && !empty($data['name']) && !empty($data['email'])) {
        if (add_subscriber($chat_id, $data)) {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => $phrases['success_subscribe'],
                'parse_mode' => 'HTML',
                'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($keyboard2),
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => $phrases['error_subscribe'],
                'parse_mode' => 'HTML',
                'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($keyboard1),
            ]);
        }
    }  else {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $phrases['error'],
            'parse_mode' => 'HTML',
            'reply_markup' => new \Telegram\Bot\Keyboard\Keyboard($keyboard1),
        ]);
    }
} elseif (preg_match('/(?:привет|здравствуйте|можно|вы|как|а|добрый|доброе|фото|фотографии)/iu', $text)) {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Здравствуйте, с вами свяжется менеджер, оставьте свой номер телефона",
        'parse_mode' => 'HTML',
    ]);
} elseif (isset($update['message']['text'])) {
    $text = $update['message']['text'];

    // Проверяем, содержит ли текст номер телефона
    if (preg_match('/\b\d{10,14}\b/', $text, $matches)) {
        // Извлекаем найденный номер телефона
        $phone_number = $matches[0];
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' =>  "Спасибо за предоставленный номер телефона ($phone_number). Мы свяжемся с вами в ближайшее время.",
            'parse_mode' => 'HTML',
        ]);
    } else {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Извините, но текст не содержит корректного номера телефона.",
            'parse_mode' => 'HTML',
        ]);
    }
} elseif (!empty($query_id) && !empty($cart) && !empty($total_sum)) {
    if (check_cart($cart, $total_sum)) {
        if (!$order_id = add_order($chat_id, $update)) {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "Error add order",
                'parse_mode' => 'HTML',
            ]);
            $res = ['res' => false, 'answer' => 'Cart Error'];
            echo json_encode($res);
            die;
        }

        $order_products = [];
        foreach ($cart as $item) {
            $order_products[] = [
                'label' => "{$item['title']} x {$item['qty']}",
                'amount' => $item['price'] * $item['qty'],
            ];

            // Проверка количества товара перед созданием счета
            $product_id = $item['id'];
            $product_quantity = get_product_quantity($product_id);

            if ($product_quantity < $item['qty']) {
                // Если товара в нужном количестве нет на складе
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "Очень сожалеем, но данного товара( '{$item['title']}' ) нет в нужном количестве. \n<b><i>Если вы оставите номер телефона, мы обязательно сообщим, как только данная позиция станет снова доступной для покупки</i></b>",
                    'parse_mode' => 'HTML',
                ]);
                $res = ['res' => false, 'answer' => "Извините, товар '{$item['title']}' не доступен в нужном количестве. (Товаров на складе: $product_quantity)"];
                echo json_encode($res);
                die;
            }
        }

        $cart = $update['cart'] ?? [];
        foreach ($cart as $item) {
            decrease_product_quantity($item['id'], $item['qty']);
        }

        try {
            $telegram->sendInvoice([
                'chat_id' => $chat_id,
                'title' => "Заказ № {$order_id}",
                'description' => "Оплата заказа",
                'payload' => $order_id,
//                'provider_token' => STRIPE_TOKEN,
//                'provider_token' => UKASSA_TOKEN,
                'provider_token' => PAY_MASTER,
                'currency' => 'RUB',
                'prices' => $order_products,
                'photo_url' => PAYMENT_IMG,
                'need_phone_number'=> true,
                'need_name' => true,
                'photo_width' => 640,
                'photo_height' => 427,
            ]);
            $res = ['res' => true];
            echo json_encode($res);
            die;
        } catch (\Telegram\Bot\Exceptions\TelegramSDKException $e) {
            $res = ['res' => false, 'answer' => $e->getMessage()];
            echo json_encode($res);
            die;
        }
    } else {
        $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Cart Error",
            'parse_mode' => 'HTML',
        ]);
        $res = ['res' => false, 'answer' => 'Cart Error'];
    }

    echo json_encode($res);
    die;
} elseif (isset($update['pre_checkout_query'])) {
    $telegram->answerPreCheckoutQuery([
        'pre_checkout_query_id' => $chat_id,
        'ok' => true,
    ]);
} elseif (isset($update['message']['successful_payment'])) {
    $order_id = $update['message']['successful_payment']['invoice_payload'];
    $payment_id = $update['message']['successful_payment']['provider_payment_charge_id'];
    $sum = $update['message']['successful_payment']['total_amount'] / 100;
    $currency = $update['message']['successful_payment']['currency'];
    toggle_order_status($order_id, $payment_id);
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Оплачен заказ #{$order_id} на сумму {$sum} {$currency}\n " . $phrases['payment_success'],
        'parse_mode' => 'HTML',
    ]);

} else {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $phrases['error'],
        'parse_mode' => 'HTML',
    ]);
}