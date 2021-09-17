<?php

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

use React\EventLoop\Factory;
use React\EventLoop\Loop;
use React\Http\HttpServer;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\Socket\SocketServer;

require __DIR__.'/vendor/autoload.php';


# You can generate a Token from the "Tokens Tab" in the UI
$token = 'td2TbFlFgaPe20IWHoA5oYo0ezWhdtQIOwh2suxFL7ulrVyWGkuqFC64tPZRiDJs1C8Gos7SBUEUmOZffcXBmQ==';
$org = 'myorg';
$bucket = 'mybucket';

$client = new Client([
    "url" => "http://195.201.120.5:8086",
    "token" => $token,
]);

var_dump($client);



$loop = Loop::get();

$server = new HttpServer($loop,
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

$socket = new SocketServer('0.0.0.0:9010');
$server->listen($socket);
echo 'Working on ' . str_replace('tcp:','http:',$socket->getAddress())."\n";





