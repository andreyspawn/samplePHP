<?php

use React\EventLoop\Factory;
use React\Promise\Deferred;

require __DIR__.'../vendor/autoload.php';

$loop = Factory::create();
$deferred = new Deferred();

$loop->addPeriodicTimer(1,function($timer) use ($loop, $deferred) {
    static $second = 0;
    echo "passed $second \n";
    if ($second > 7) {
        $loop->cancelTimer($timer);
        $deferred->resolve();
    }
    $second++;
});

$deferred->promise()->then(function () {
    echo "Stop after $second second;";
});

$loop->run();