<?php

require '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

use React\EventLoop\Factory;
use React\EventLoop\Loop;
use React\Http\Server;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\Socket\Server as SocketServer;

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

$loop = Factory::create();

$server = new Server($loop,
    function (ServerRequestInterface $request) use($channel)
    {

        $size = $request->getBody()->getSize();
//    return new Response(
//        200,
//        ['Content-Type' => 'application/json'],
//        json_encode(['message'=>"TEST MESSAGE(size is $size ) FROM SIMPLEST SERVER"])
//    );

            $msg = new AMQPMessage("ReactPHP^ request size $size HTTPserver:".rand(0,100));
            $channel->basic_publish($msg,'','task_queue');
    });

$socket = new SocketServer('192.168.1.154:9010',$loop);
$server->listen($socket);
echo 'Working on ' . str_replace('tcp:','http:',$socket->getAddress())."\n";

$loop->run();

$channel->close();
$connection->close();

