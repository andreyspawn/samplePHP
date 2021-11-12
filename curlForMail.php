<?php

$ch=curl_init();

// curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/news/closure/');

curl_setopt($ch, CURLOPT_URL, 'https://dev.megasport.ua/ru/emails/order-user/');

$body = [
    'html' => 'mails/mails-sendOrderToUser.twig',
];
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
$response = curl_exec($ch);
var_dump(curl_getinfo($ch));
var_dump($response);

curl_close($ch);