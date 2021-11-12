<?php

$text = "Test message " . date('d-m-Y h:m:s').PHP_EOL;

$fileName = "sendOrderEmailNewArchitecture.log";

$modeFile = "a+"; #file open and handler set up to EOF. if file not exists - attempt to create it

$modeFile = "w+"; #file cuttin up to zero size and handler set up to start of file. if file not exists - attempt to create it

$modeFile = filesize($fileName)<1000000 ? "a+" : "w+";

$file = fopen("sendOrderEmailNewArchitecture.log", $modeFile);
for ($i = 1; $i < 5000; $i++) {
    fwrite($file, $text);
}
fclose($file);

var_dump(filesize($fileName));
