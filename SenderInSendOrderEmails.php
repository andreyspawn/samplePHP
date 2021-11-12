<?php

require './vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

//use React\EventLoop\Factory;
//use React\EventLoop\Loop;
//use Psr\Http\Message\ServerRequestInterface;
//use React\Http\Message\Response;

define("RABBITMQ_HOST","127.0.0.1");
define("RABBITMQ_PORT","5672");
define("RABBITMQ_USERNAME","dev");
define("RABBITMQ_PASS","dev");

$connection = new AMQPStreamConnection(
    RABBITMQ_HOST,
    RABBITMQ_PORT,
    RABBITMQ_USERNAME,
    RABBITMQ_PASS
);

$channel = $connection->channel();

$arguments = new AMQPTable(["x-dead-letter-exchange" => 'dev:megasport-dlx',
"x-dead-letter-routing-key" => 'dev:megasport-dlrk']);

// $arguments = new AMQPTable();

$channel->queue_declare(
    'dev:sendOrderEmails',
    false,
    true,
    false,
    false,
    false,
    $arguments,
    null
);

$message_arr =  [
            "data" => array_merge(["id" => 235], ['template' => 'mails/mails-sendOrderToUser.twig', 'email' => 'prive_s@ukr.net']),
            "language" => 'ru',
            "params" => [
                "theme" => 'Заказ' . ' № ' . '$Order->id' . ' ' . 'создан на MEGASPORT',
                'To_name' => 'Andrey',
                'Reply-To' => 'prive_s@ukr.net',
                'Return-path' => 'prive_s@ukr.net',
                'From' => 'megasport@megasport.ua',
            ],
            "sendToUser" => true,
        ];

$message = new AMQPMessage(
    json_encode($message_arr, JSON_UNESCAPED_UNICODE),
    array('delivery_mode' => 2)
);

var_dump($message);
$channel->basic_publish($message,'','dev:sendOrderEmail');

/***
Пользователю отправляется электронное письмо о том что он успешно совершил заказ на проекте при совершении заказа сразу(только в случае наложки и "заказ в клик").
Title письма: Заказ №111111 создан на MEGASPORT
    ***/
// \Libs\Queue::obj()->basicPublish(
//     [
//         "data" => array_merge(["id" => 235], ['template' => 'mails/mails-sendOrderToUser.twig', 'email' => 'prive_s@ukr.net']),
//         "language" => 'ru',
//         "params" => [
//             "theme" => 'Заказ' . ' № ' . '$Order->id' . ' ' . 'создан на MEGASPORT',
//             'To_name' => 'Andrey',
//             'Reply-To' => 'prive_s@ukr.net',
//             'Return-path' => 'prive_s@ukr.net',
//             'From' => 'megasport@megasport.ua',
//         ],
//         "sendToUser" => true,
//     ],
//     "sendOrderEmails"
// );