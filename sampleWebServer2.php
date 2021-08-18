<?php

use React\EventLoop\Factory;
use React\EventLoop\Loop;
use React\Promise\Deferred;
use React\Promise\Promise;
use React\Http\Server;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\Socket\Server as SocketServer;

require __DIR__.'/vendor/autoload.php';

$loop = Factory::create();

$server = new Server($loop,
function (ServerRequestInterface $request) {
    $stream = new \React\Stream\ThroughStream();

    $size = $request->getBody()->getSize();
    $params = $request->getQueryParams();
    $name =$params['name'];

    Loop::addTimer(0.0, function () use ($stream, $name, $size) {
        $stream->write(json_encode(['Name:'=>$name,
            'Size:'=>$size]));
    });

    $timer = Loop::addPeriodicTimer(0.5,function () use ($stream) {
        $stream->write(json_encode(['time' => microtime(true)]));
        $stream->write('HALO!'.PHP_EOL);

    });

    $timer2 = Loop::addPeriodicTimer(0.7, function () use ($stream) {
        $stream->write(json_encode(['tick'=>0.7]));
    });

    Loop::addTimer(5, function () use ($timer, $timer2, $stream) {
        Loop::cancelTimer($timer);
        Loop::cancelTimer($timer2);
        $stream->end();
    });

    return new Response(
        200,
        ['Content-Type' => 'application/json'],
        $stream
    );



//    $size = $request->getBody()->getSize();
//    return new Response(
//        200,
//        ['Content-Type' => 'application/json'],
//        json_encode(['message'=>"TEST MESSAGE(size is $size ) FROM SIMPLEST SERVER"])
//    );

});

$socket = new SocketServer('192.168.1.154:9010',$loop);
$server->listen($socket);
echo 'Working on ' . str_replace('tcp:','http:',$socket->getAddress())."\n";

$loop->run();