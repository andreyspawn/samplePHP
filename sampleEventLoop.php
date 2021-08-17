<?php

use React\EventLoop\Factory;

require __DIR__.'../vendor/autoload.php';

$loop = Factory::create();

$loop->addPeriodicTimer(random_int(1,5),function() {
    echo "Tick"."\n";
});

$loop->addTimer(10, function () use ($loop) {
    echo "Tuck"."\n";
    $loop->stop();
});

$loop->run();

