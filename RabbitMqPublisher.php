<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require __DIR__.'/vendor/autoload.php';

define("RABBITMQ_HOST","192.168.1.158");
define("RABBITMQ_PORT","5672");
define("RABBITMQ_USERNAME","admin");
define("RABBITMQ_PASS","admin");

$jsonFile = file_get_contents("Exxample.json");
//var_dump($jsonFile);die;

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


$job_id=0;

//while (true)
for ($i=0; $i < 100000; $i++)
{
    $jobArray = [
        'id' => $job_id++,
        'task' => 'sleep',
        'sleep_period' => rand(0,3)
        ];
    $msg = new AMQPMessage(
        json_encode($jobArray, JSON_UNESCAPED_SLASHES),
        ['delivery_mode' => 2]
    );

    $channel->basic_publish($msg,'','task_queue');
    echo 'Job created'.PHP_EOL;
//    sleep(1);
}