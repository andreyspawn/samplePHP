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

$logMess = 'info="APEX SEND REQUEST API: msapi.apex.rest:8080/ords/basket/v1/orders.json, START: 1632733116.9783, END: 1632733117.0555 EXECUTION TIME: 0.07726001739502, DATA: {"ordid":1632733116,"name":null,"surrname":null,"middleName":null,"complete":0,"phone":null,"card":"2017400149954","paid":0,"dat":1632733116,"descr":null,"email":null,"refcity":null,"indexCOATSU":null,"refpost":null,"refAddress":null,"promo":null,"location":"web","orderrows":[{"art":"906110\/04","cnt":2,"sizes":"39\/42","model":"Short Crew 3p Unisex","section":"\u0428\u043a\u0430\u0440\u043f\u0435\u0442\u043a\u0438","brand":"Puma","img_url":"https:\/\/dev.megasport.ua\/ua\/image\/products\/12_20211_906110_04_1_1617056978.jpg"}],"address":null,"deliveryType":1,"trpoint":213,"authStatus":null,"paidtp":0}, STATUS: 200, RESPONSE: {
    "id":24861432
    ,"ordid":1632733116
    ,"complete":1
    ,"totalprice":792
    ,"card":"2017400149954"
    ,"paid":0
    ,"bonus_out":0
    ,"totalpromo":0
    ,"promo_benefit":0
    ,"total_disc":88
    ,"card_disc":88
    ,"act_disc":0
    ,"bonus_disc":0
    ,"orderrows":[
    {
    "rowsid":57517022
    ,"id":84443
    ,"ordid":24861432
    ,"art":"906110\/04"
    ,"cnt":2
    ,"sizes":"39\/42"
    ,"price":792
    ,"model":"Short Crew 3p Unisex"
    ,"section":"\u0428\u043A\u0430\u0440\u043F\u0435\u0442\u043A\u0438"
    ,"brand":"Puma"
    ,"img_url":"https:\/\/dev.megasport.ua\/ua\/image\/products\/12_20211_906110_04_1_1617056978.jpg"
    ,"disc":88
    ,"bonus_disc":0
    ,"act_disc":0
    ,"card_disc":88
    ,"promo_disc":0
    ,"promo_benefit":0
    ,"isdcard_disc":1
    ,"lkey":"1425064"
    ,"lkeys":[
    {
    "fondy":"1425064"
    ,"monobank":"39267972_307"
    }
    ]
    }
    ]
    ,"baskets":[
    {
    "lkey":"1425064"
    ,"lkeys":[
    {
    "fondy":"1425064"
    ,"monobank":"39267972_307"
    }
    ]
    ,"id":25095628
    ,"ordid":24861432
    ,"complete":1
    ,"totalprice":792
    ,"card":"2017400149954"
    ,"paid":0
    ,"bonus_out":0
    ,"totalpromo":0
    ,"promo_benefit":0
    ,"total_disc":88
    ,"card_disc":88
    ,"act_disc":0
    ,"bonus_disc":0
    ,"partly_pay":1
    ,"orderrows":[
    {
    "rowsid":57517022
    ,"id":84443
    ,"ordid":24861432
    ,"art":"906110\/04"
    ,"cnt":2
    ,"sizes":"39\/42"
    ,"price":792
    ,"model":"Short Crew 3p Unisex"
    ,"section":"\u0428\u043A\u0430\u0440\u043F\u0435\u0442\u043A\u0438"
    ,"brand":"Puma"
    ,"img_url":"https:\/\/dev.megasport.ua\/ua\/image\/products\/12_20211_906110_04_1_1617056978.jpg"
    ,"disc":88
    ,"bonus_disc":0
    ,"act_disc":0
    ,"card_disc":88
    ,"promo_disc":0
    ,"promo_benefit":0
    ,"isdcard_disc":1
    ,"lkey":"1425064"
    }
    ]
    ,"action_sets":[
    ]
    }
    ]
    }
    , ERROR: 0 -  [apex:2021-09-27T11:58:36.978175+03:00]"';    

$value = 'APEX SEND REQUEST API: msapi.apex.rest:8080/ords/basket/v1/orders.json, START: 1632733116.9783, END: 1632733117.0555 EXECUTION TIME: 0.07726001739502, DATA: {"ordid":1632733116,"name":null,"surrname":null,"middleName":null,"complete":0,"phone":null,"card":"2017400149954","paid":0,"dat":1632733116,"descr":null,"email":null,"refcity":null,"indexCOATSU":null,"refpost":null,"refAddress":null,"promo":null,"location":"web","orderrows":[{"art":"906110\/04","cnt":2,"sizes":"39\/42","model":"Short Crew 3p Unisex","section":"\u0428\u043a\u0430\u0440\u043f\u0435\u0442\u043a\u0438","brand":"Puma","img_url":"https:\/\/dev.megasport.ua\/ua\/image\/products\/12_20211_906110_04_1_1617056978.jpg"}],"address":null,"deliveryType":1,"trpoint":213,"authStatus":null,"paidtp":0}, STATUS: 200, RESPONSE: {
    "id":24861432
    ,"ordid":1632733116
    ,"complete":1
    ,"totalprice":792
    ,"card":"2017400149954"
    ,"paid":0
    ,"bonus_out":0
    ,"totalpromo":0
    ,"promo_benefit":0
    ,"total_disc":88
    ,"card_disc":88
    ,"act_disc":0
    ,"bonus_disc":0
    ,"orderrows":[
    {
    "rowsid":57517022
    ,"id":84443
    ,"ordid":24861432
    ,"art":"906110\/04"
    ,"cnt":2
    ,"sizes":"39\/42"
    ,"price":792
    ,"model":"Short Crew 3p Unisex"
    ,"section":"\u0428\u043A\u0430\u0440\u043F\u0435\u0442\u043A\u0438"
    ,"brand":"Puma"
    ,"img_url":"https:\/\/dev.megasport.ua\/ua\/image\/products\/12_20211_906110_04_1_1617056978.jpg"
    ,"disc":88
    ,"bonus_disc":0
    ,"act_disc":0
    ,"card_disc":88
    ,"promo_disc":0
    ,"promo_benefit":0
    ,"isdcard_disc":1
    ,"lkey":"1425064"
    ,"lkeys":[
    {
    "fondy":"1425064"
    ,"monobank":"39267972_307"
    }
    ]
    }
    ]
    ,"baskets":[
    {
    "lkey":"1425064"
    ,"lkeys":[
    {
    "fondy":"1425064"
    ,"monobank":"39267972_307"
    }
    ]
    ,"id":25095628
    ,"ordid":24861432
    ,"complete":1
    ,"totalprice":792
    ,"card":"2017400149954"
    ,"paid":0
    ,"bonus_out":0
    ,"totalpromo":0
    ,"promo_benefit":0
    ,"total_disc":88
    ,"card_disc":88
    ,"act_disc":0
    ,"bonus_disc":0
    ,"partly_pay":1
    ,"orderrows":[
    {
    "rowsid":57517022
    ,"id":84443
    ,"ordid":24861432
    ,"art":"906110\/04"
    ,"cnt":2
    ,"sizes":"39\/42"
    ,"price":792
    ,"model":"Short Crew 3p Unisex"
    ,"section":"\u0428\u043A\u0430\u0440\u043F\u0435\u0442\u043A\u0438"
    ,"brand":"Puma"
    ,"img_url":"https:\/\/dev.megasport.ua\/ua\/image\/products\/12_20211_906110_04_1_1617056978.jpg"
    ,"disc":88
    ,"bonus_disc":0
    ,"act_disc":0
    ,"card_disc":88
    ,"promo_disc":0
    ,"promo_benefit":0
    ,"isdcard_disc":1
    ,"lkey":"1425064"
    }
    ]
    ,"action_sets":[
    ]
    }
    ]
    }
    , ERROR: 0 -  [apex:2021-09-27T11:58:36.978175+03:00]"';
    $value1 = ',value=1 1632733116978175';

    //echo addslashes(str_replace(PHP_EOL, '', $value));die;

for ($i=1;$i<2;$i++)
{
    $time1 = time();

    $date1 = date("Y-m-d H:i:s");
    sleep(1);
    echo "times - ".$i;

    
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,'http://195.201.120.5:8086/api/v2/write?org=myorg&bucket=mybucket5&precision=s');
    curl_setopt_array($curl, array(
    // CURLOPT_URL => 'http://195.201.120.5:8086/api/v2/write?org=myorg&bucket=mybucket5&precision=s',
    //CURLOPT_POSTFIELDS =>'log,name=text value="Test message '.$time1.'" ',
    CURLOPT_POSTFIELDS =>'log,env=api info='.json_encode($value),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Token td2TbFlFgaPe20IWHoA5oYo0ezWhdtQIOwh2suxFL7ulrVyWGkuqFC64tPZRiDJs1C8Gos7SBUEUmOZffcXBmQ==',
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    var_dump($response);
    echo "RESULT OF CURL:".$response.PHP_EOL;

    curl_close($curl);
    $result=(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 204) ? true : false;
echo "******".PHP_EOL;

    var_dump($result);
    echo "******".PHP_EOL;
    echo strlen(curl_getinfo($curl, CURLINFO_HTTP_CODE)).PHP_EOL;
    var_dump(gettype(curl_getinfo($curl, CURLINFO_HTTP_CODE)));
    echo "RESULT OF CURL:".$response.PHP_EOL;

}
