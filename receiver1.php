<?php

require '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//use React\EventLoop\Factory;
//use React\EventLoop\Loop;
//use Psr\Http\Message\ServerRequestInterface;
//use React\Http\Message\Response;

define("RABBITMQ_HOST","192.168.1.158");
define("RABBITMQ_PORT","5672");
define("RABBITMQ_USERNAME","admin");
define("RABBITMQ_PASS","admin");

$connection = new AMQPStreamConnection(
    RABBITMQ_HOST,
    RABBITMQ_PORT,
    RABBITMQ_USERNAME,
    RABBITMQ_PASS
);

$channel = $connection->channel();

$channel->queue_declare(
    'task_queue',
    false,
    true,
    false,
    false
);

echo "Waiting for messages and open file for writing".PHP_EOL;

try {
    $file = fopen('queue.txt','aw+');
}
catch (Exception $e) {
    echo $e->getMessage();
}

$callback = function ($msg) {
    echo "Received: ".$msg->body,"\n";
    $file = fopen('queue.txt','aw+');
    fwrite($file,$msg->body."\n");
    fclose($file);

};

$channel->basic_consume(
    'task_queue',
    '',
    false,
    true,
    false,
    false,
    $callback
);

while (count($channel->callbacks))
{
    $channel->wait();
}

$channel->close();
$connection->close();

