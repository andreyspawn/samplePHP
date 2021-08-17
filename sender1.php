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
$time1 = time();
for ($i=0; $i <10000; $i++)
{
$msg = new AMQPMessage('Hello world!!! Number:'.$i);


$channel->basic_publish($msg,'','task_queue');
}
$time2 = time();
$timedelta = $time2-$time1;

echo date('d-m-Y H:i:s',$time1).'---'.date('d-m-Y H:i:s',$time2);
echo "\n Time in mks: ".$timedelta;

$finalMsg = date('d-m-Y H:i:s',$time1).'---'.date('d-m-Y H:i:s',$time2).
    "\n Time in mks: ".$timedelta;

$msg = new AMQPMessage($finalMsg);
$channel->basic_publish($msg,'','task_queue');



$channel->close();
$connection->close();