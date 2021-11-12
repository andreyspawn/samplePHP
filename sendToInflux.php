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
// $token = 'td2TbFlFgaPe20IWHoA5oYo0ezWhdtQIOwh2suxFL7ulrVyWGkuqFC64tPZRiDJs1C8Gos7SBUEUmOZffcXBmQ==';
// $org = 'myorg';
// $bucket = 'mybucket';

// $client = new Client([
//     "url" => "http://195.201.120.5:8086",
//     "token" => $token,
// ]);

// $response = curl_exec($curl);

// var_dump($client);

for ($i=1;$i<10;$i++)
{
    $time1 = time();

    $date1 = date("Y-m-d H:i:s");
    sleep(2);
    echo "times - ".$i;

    for ($c=1;$c<1;$c++) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://195.201.120.5:8086/api/v2/write?org=myorg&bucket=mybucket5&precision=s',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'log,name=text value="Text message '.$c.' from '.$date1.'" '.$time1-$i,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Token td2TbFlFgaPe20IWHoA5oYo0ezWhdtQIOwh2suxFL7ulrVyWGkuqFC64tPZRiDJs1C8Gos7SBUEUmOZffcXBmQ==',
          'Content-Type: application/json'
        ),
      ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

}
