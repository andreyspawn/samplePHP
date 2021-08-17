<?php


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require __DIR__.'/vendor/autoload.php';

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
    $queue = "task_queue",
    $passive = false,
    $durable = true,
    $exclusive = false,
    $auto_delete = false,
    $nowait = false,
    $arguments=null,
    $tickets = null
);

echo "Waiting for messages".PHP_EOL;

$callback = function ($msg)
{
    echo " [x] Received ", $msg->body, "\n";
//    $job = json_decode($msg->body, $assocForm=true);
//    sleep($job['sleep_period']);
    echo "[x] Done ", PHP_EOL;
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

};

$channel->basic_qos(null,1,null);

$channel->basic_consume(
    $queue = 'task_queue',
    $consumer_tag = '',
    $nolocal = false,
    $no_ack = false,
    $exclusive = false,
    $nowait = false,
    $callback
);

while (count($channel->callbacks))
{
    $channel->wait();
}

$channel->close();
$connection->close();